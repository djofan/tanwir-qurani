<?php

namespace App\Filament\Guru\Resources\ApprovalResource\Pages;

use App\Filament\Guru\Resources\ApprovalResource;
use App\Models\SubmissionLog;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Auth;

class ViewApproval extends ViewRecord
{
    protected static string $resource = ApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('Approve Tugas')
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->requiresConfirmation()
                ->modalHeading('Setujui Tugas Ini?')
                ->modalDescription('Tugas peserta akan ditandai sebagai selesai.')
                ->action(function () {
                    $this->record->update(['status' => 'approved']);

                    SubmissionLog::create([
                        'submission_id'  => $this->record->id,
                        'teacher_id'     => Auth::id(),
                        'status_at_time' => 'approved',
                        'feedback'       => 'Tugas disetujui.',
                        'attempt_number' => $this->record->attempts_count,
                    ]);

                    $this->redirect($this->getResource()::getUrl('index'));
                }),

            Action::make('reject')
                ->label('Reject Tugas')
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->form([
                    Textarea::make('feedback')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->rows(4)
                        ->placeholder('Contoh: Screenshot tidak terbaca, jawaban salah...'),
                ])
                ->action(function (array $data) {
                    $this->record->update(['status' => 'rejected']);

                    SubmissionLog::create([
                        'submission_id'  => $this->record->id,
                        'teacher_id'     => Auth::id(),
                        'status_at_time' => 'rejected',
                        'feedback'       => $data['feedback'],
                        'attempt_number' => $this->record->attempts_count,
                    ]);

                    $this->redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }
}