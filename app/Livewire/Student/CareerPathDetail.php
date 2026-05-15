<?php

namespace App\Livewire\Student;

use App\Models\CareerPath;
use App\Models\StudentCareerPath;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CareerPathDetail extends Component
{
    public CareerPath $careerPath;
    public bool $isSaved = false;

    public function mount(CareerPath $careerPath): void
    {
        $this->careerPath = $careerPath->load('experts', 'certifications');

        $this->isSaved = StudentCareerPath::where('user_id', Auth::id())
            ->where('career_path_id', $careerPath->id)
            ->value('is_saved') ?? false;
    }

    public function toggleSave(): void
    {
        $pivot = StudentCareerPath::firstOrCreate(
            ['user_id' => Auth::id(), 'career_path_id' => $this->careerPath->id],
        );

        $pivot->update(['is_saved' => ! $pivot->is_saved]);
        $this->isSaved = $pivot->fresh()->is_saved;
    }

    public function render()
    {
        return view('livewire.student.career-path-detail')
            ->layout('layouts.app', ['title' => $this->careerPath->name]);
    }
}
