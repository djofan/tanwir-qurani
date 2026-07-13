<?php

namespace App\Filament\Peserta\Pages;

use App\Models\Submission;
use App\Models\Task;
use BackedEnum;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class DetailTugasPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static bool    $shouldRegisterNavigation      = false;
    protected string  $view                                 = 'filament.peserta.pages.detail-tugas-page';
    protected static ?string $slug                          = 'tugas/{task}/detail';

    public Task        $task;
    public ?Submission $submission = null;

    public function mount(Task $task): void
    {
        $this->task       = $task;
        $this->submission = Submission::where('task_id', $task->id)
            ->where('student_id', Auth::id())
            ->with('quizAnswers')
            ->latest()
            ->first();
    }
}
