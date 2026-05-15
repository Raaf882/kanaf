<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PoorPerformanceNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly string $courseName,
        public readonly int    $score,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'poor_performance',
            'title'   => 'تنبيه: أداء يحتاج تحسيناً ⚠️',
            'message' => "مجموع درجاتك الحالي في مادة {$this->courseName} هو {$this->score}%. كَـنَـف يقترح عليك الاستعانة بكنف التعليم أو حجز جلسة إرشادية.",
            'course'  => $this->courseName,
            'color'   => 'orange',
            'icon'    => 'warning',
        ];
    }
}
