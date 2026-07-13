<?php

namespace App\Filament\Peserta\Pages;

use App\Models\QuizAnswer;
use App\Models\Submission;
use App\Models\Task;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;

class KerjakanKuisPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = null;
    protected static bool $shouldRegisterNavigation = false;
    protected string $view = 'filament.peserta.pages.kerjakan-kuis-page';
    protected static ?string $slug = 'tugas/{task}/kuis';

    public Task $task;

    /** @var array<int, string> question_id => selected option (a/b/c/d) */
    public array $answers = [];

    public function mount(Task $task): void
    {
        $this->task = $task->load('questions');

        $alreadyDone = Submission::where('task_id', $task->id)
            ->where('student_id', Auth::id())
            ->exists();

        if ($alreadyDone) {
            $this->redirect(route('filament.peserta.pages.tugas.{task}.detail', ['task' => $task->id]));
            return;
        }

        if ($this->task->isLocked()) {
            Notification::make()
                ->title('Kuis ini sudah lewat deadline')
                ->body('Minta guru untuk memperpanjang deadline kalau kamu masih perlu mengerjakan.')
                ->danger()
                ->send();

            $this->redirect(route('filament.peserta.pages.tugas'));
        }
    }

    public function submitQuiz(): void
    {
        if ($this->task->isLocked()) {
            Notification::make()->title('Deadline sudah lewat, kuis tidak bisa dikumpulkan lagi.')->danger()->send();
            $this->redirect(route('filament.peserta.pages.tugas'));
            return;
        }

        $questions = $this->task->questions;

        foreach ($questions as $question) {
            if (empty($this->answers[$question->id])) {
                Notification::make()
                    ->title('Semua soal wajib dijawab dulu!')
                    ->warning()
                    ->send();

                return;
            }
        }

        $submission = Submission::create([
            'task_id'        => $this->task->id,
            'student_id'     => Auth::id(),
            'status'         => 'approved',
            'attempts_count' => 1,
            'is_late'        => $this->task->isPastOriginalDeadline(),
        ]);

        $correctCount = 0;

        foreach ($questions as $question) {
            $selected  = $this->answers[$question->id];
            $isCorrect = $selected === $question->correct_option;

            if ($isCorrect) {
                $correctCount++;
            }

            QuizAnswer::create([
                'submission_id'    => $submission->id,
                'quiz_question_id' => $question->id,
                'selected_option'  => $selected,
                'is_correct'       => $isCorrect,
            ]);
        }

        $totalQuestions = $questions->count();
        $score = $totalQuestions > 0 ? (int) round(($correctCount / $totalQuestions) * 100) : 0;

        $submission->update(['score' => $score]);

        Notification::make()
            ->title('Kuis selesai!')
            ->body("Nilai kamu: {$score} ({$correctCount} dari {$totalQuestions} benar)" . ($submission->is_late ? ' — dikumpulkan setelah deadline awal (terlambat)' : ''))
            ->success()
            ->send();

        $this->redirect(route('filament.peserta.pages.tugas.{task}.detail', ['task' => $this->task->id]));
    }
}
