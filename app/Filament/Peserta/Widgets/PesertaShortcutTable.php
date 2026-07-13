<?php

namespace App\Filament\Peserta\Widgets;

use App\Models\Task;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PesertaShortcutTable extends BaseWidget
{
    protected static ?string $heading = 'Tugas Terbaru Belum Dikerjakan';

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $student   = Auth::user();
        $studentId = $student->id;
        $groupId   = $student->profile?->group_id;

        return $table
            ->query(
                Task::query()
                    ->when($groupId, function (Builder $q) use ($groupId) {
                        $q->whereHas('groups', fn($q2) => $q2->where('groups.id', $groupId));
                    }, function (Builder $q) {
                        $q->whereRaw('1 = 0');
                    })
                    ->whereDoesntHave('submissions', function (Builder $q) use ($studentId) {
                        $q->where('student_id', $studentId);
                    })
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Guru'),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipe')
                    ->formatStateUsing(fn($state) => match ($state) {
                        'voice_note' => 'Voice Note',
                        'video'      => 'Video',
                        'quiz'       => 'Kuis',
                        default      => $state,
                    })
                    ->colors([
                        'info'    => 'voice_note',
                        'warning' => 'video',
                        'success' => 'quiz',
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y'),
            ])
            ->actions([
                Action::make('kerjakan')
                    ->label('Kerjakan')
                    ->color('warning')
                    ->url(fn(Task $record) => '/peserta/tugas/' . $record->id . '/kerjakan'),
            ]);
    }
}
