<?php

namespace App\Filament\Peserta\Pages;

use App\Models\Submission;
use App\Models\Task;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class TugasPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static ?string $navigationLabel               = 'Tugas';
    protected string  $view                                 = 'filament.peserta.pages.tugas-page';
    protected static ?string $slug                          = 'tugas';
    protected static ?int    $navigationSort                = 2;

    public function getTasks(): \Illuminate\Support\Collection
    {
        $student   = Auth::user();
        $studentId = $student->id;
        $groupId   = $student->profile?->group_id;

        $tasks = Task::with(['teacher', 'groups'])
            ->when($groupId, function ($q) use ($groupId) {
                $q->whereHas('groups', fn ($q2) => $q2->where('groups.id', $groupId));
            }, function ($q) {
                $q->whereRaw('1 = 0');
            })
            ->latest()
            ->get();

        return $tasks->map(function (Task $task) use ($studentId) {
            $submission = Submission::where('task_id', $task->id)
                ->where('student_id', $studentId)
                ->latest()
                ->first();

            $task->submission        = $submission;
            $task->submission_status = $submission?->status ?? 'belum';
            $task->submission_score  = $submission?->score;
            $task->is_locked         = $task->isLocked();
            $task->is_late           = $submission?->is_late ?? false;

            return $task;
        });
    }
}
