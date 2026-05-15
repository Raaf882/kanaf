<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SapPredictionService
{
    private string $baseUrl;

    /** Cache TTL in seconds (1 hour) */
    private int $cacheTtl = 3600;

    /** HTTP timeout in seconds */
    private int $timeout = 10;

    public function __construct()
    {
        $this->baseUrl = rtrim(
            config('services.sap_api.url', 'https://sap-model-api.onrender.com'),
            '/'
        );
    }

    // ─────────────────────────────────────────────────────────────────
    //  Public API
    // ─────────────────────────────────────────────────────────────────

    /**
     * Fetch the AI prediction for a student.
     *
     * Returns the decoded JSON array on success, or null when:
     *   - The student ID is not found in the model's dataset
     *   - The API is unreachable / times out
     *
     * Results are cached per student ID to avoid hammering the API on
     * every page load.
     */
    public function predict(string $studentId): ?array
    {
        if (blank($studentId)) {
            return null;
        }

        $cacheKey = 'sap_pred_' . md5($studentId);

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($studentId) {
            try {
                $response = Http::timeout($this->timeout)
                    ->get("{$this->baseUrl}/predict/student/{$studentId}");

                if (! $response->successful()) {
                    return null;
                }

                $data = $response->json();

                // API returns {"error": "..."} when student not found
                if (isset($data['error'])) {
                    return null;
                }

                return $data ?: null;

            } catch (\Throwable $e) {
                Log::warning("[SAP API] Could not fetch prediction for student '{$studentId}': {$e->getMessage()}");
                return null;
            }
        });
    }

    /**
     * Flush the cached prediction for a specific student.
     * Useful after grades are updated.
     */
    public function forget(string $studentId): void
    {
        Cache::forget('sap_pred_' . md5($studentId));
    }

    // ─────────────────────────────────────────────────────────────────
    //  Helpers
    // ─────────────────────────────────────────────────────────────────

    /**
     * Returns true when the prediction indicates an academic-decline risk.
     * Handles multiple possible field names / value conventions.
     */
    public function isAtRisk(?array $prediction): bool
    {
        if (! $prediction) {
            return false;
        }

        // Numeric probability (0–1 scale)
        if (isset($prediction['probability']) && is_numeric($prediction['probability'])) {
            return (float) $prediction['probability'] >= 0.5;
        }

        // Binary class label
        if (isset($prediction['prediction'])) {
            $val = strtolower((string) $prediction['prediction']);
            return in_array($val, ['1', 'true', 'at_risk', 'risk', 'decline', 'تدني', 'danger'], true);
        }

        // Risk-level string
        if (isset($prediction['risk_level'])) {
            $lvl = strtolower((string) $prediction['risk_level']);
            return in_array($lvl, ['high', 'critical', 'عالي', 'خطر'], true);
        }

        // SAP status field
        if (isset($prediction['status'])) {
            $status = strtolower((string) $prediction['status']);
            return in_array($status, ['at_risk', 'decline', 'fail', 'تدني'], true);
        }

        return false;
    }

    /**
     * Human-readable Arabic label for the prediction.
     */
    public function getLabel(?array $prediction): string
    {
        if (! $prediction) {
            return 'غير متاح';
        }

        return $this->isAtRisk($prediction) ? 'خطر تدني' : 'أداء مستقر';
    }

    /**
     * Confidence percentage (0–100), or null if unavailable.
     */
    public function getConfidence(?array $prediction): ?int
    {
        if (! $prediction) {
            return null;
        }

        foreach (['probability', 'confidence', 'score'] as $key) {
            if (isset($prediction[$key]) && is_numeric($prediction[$key])) {
                $val = (float) $prediction[$key];
                // Handle both 0–1 and 0–100 scales
                return (int) round($val > 1 ? $val : $val * 100);
            }
        }

        return null;
    }
}
