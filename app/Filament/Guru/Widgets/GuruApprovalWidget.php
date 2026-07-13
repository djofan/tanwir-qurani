<?php

namespace App\Filament\Guru\Widgets;

use App\Models\Task;
use Filament\Actions\Action;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GuruApprovalWidget extends BaseWidget
{
    protected static ?string $heading = 'Tugas Saya yang Butuh Approval';

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $guruId = Auth::id();

        return $table
            ->query(
                Task::query()
                    ->where('type', '!=', 'quiz') // kuis auto-approved, ga pernah butuh review manual
                    ->where(function (Builder $q) use ($guruId) {
                        $q->where('teacher_id', $guruId)
                            ->orWhereHas('approvers', fn (Builder $q2) => $q2->where('users.id', $guruId));
                    })
                    ->withCount([
                        'submissions as pending_count' => fn (Builder $q) => $q->where('status', 'pending'),
                    ])
                    ->having('pending_count', '>', 0)
                    ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('teacher.name')
                    ->label('Pembuat'),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipe')
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'voice_note' => 'Voice Note',
                        'video'      => 'Video',
                        default      => $state,
                    }),

                Tables\Columns\TextColumn::make('pending_count')
                    ->label('Butuh Approval')
                    ->badge()
                    ->color('warning'),

                Tables\Columns\TextColumn::make('deadline')
                    ->label('Deadline')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('Bebas')
                    ->badge()
                    ->color(fn (Task $record) => $record->isLocked() ? 'danger' : 'gray'),
            ])
            ->actions([
                Action::make('lihatApproval')
                    ->label('Lihat')
                    ->color('warning')
                    ->url(fn () => route('filament.guru.resources.approval.index')),
            ])
            ->emptyStateHeading('Ga ada tugas yang butuh approval saat ini 🎉');
    }
}