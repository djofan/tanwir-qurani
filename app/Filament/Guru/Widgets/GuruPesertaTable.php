<?php

namespace App\Filament\Guru\Widgets;

use App\Models\Task;
use App\Models\User;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GuruPesertaTable extends BaseWidget
{
    protected static ?string $heading = 'Progress Murid per Tugas Saya';

    protected static bool $isLazy = false;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $guruId = Auth::id();

        $scopeTaskIds = Task::query()
            ->where(function (Builder $q) use ($guruId) {
                $q->where('teacher_id', $guruId)
                    ->orWhereHas('approvers', fn (Builder $q2) => $q2->where('users.id', $guruId));
            })
            ->pluck('id');

        // Ambil semua group_id yang jadi target tugas-tugas di scope guru ini
        $groupIds = Task::whereIn('id', $scopeTaskIds)
            ->with('groups')
            ->get()
            ->pluck('groups')
            ->flatten()
            ->pluck('id')
            ->unique()
            ->values();

        return $table
            ->query(
                User::query()
                    ->where('role', 'peserta')
                    ->where('status', true)
                    ->whereHas('profile', function ($q) use ($groupIds) {
                        $q->whereIn('group_id', $groupIds);
                    })
                    ->with(['profile.group'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Peserta')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('profile.group.name')
                    ->label('Kelompok')
                    ->badge()
                    ->color('info')
                    ->default('-'),

                Tables\Columns\TextColumn::make('sudah_count')
                    ->label('Sudah')
                    ->badge()
                    ->color('success')
                    ->getStateUsing(fn (User $record) => $record->submissions()
                        ->whereIn('task_id', $scopeTaskIds)
                        ->where('status', 'approved')
                        ->count()),

                Tables\Columns\TextColumn::make('pending_count')
                    ->label('Pending')
                    ->badge()
                    ->color('warning')
                    ->getStateUsing(fn (User $record) => $record->submissions()
                        ->whereIn('task_id', $scopeTaskIds)
                        ->where('status', 'pending')
                        ->count()),

                Tables\Columns\TextColumn::make('belum_count')
                    ->label('Belum')
                    ->badge()
                    ->color('gray')
                    ->getStateUsing(function (User $record) use ($scopeTaskIds) {
                        $groupId = $record->profile?->group_id;

                        $totalTugasUntukDia = Task::whereIn('id', $scopeTaskIds)
                            ->whereHas('groups', fn ($q) => $q->where('groups.id', $groupId))
                            ->count();

                        $sudahDikerjakan = $record->submissions()
                            ->whereIn('task_id', $scopeTaskIds)
                            ->distinct('task_id')
                            ->count('task_id');

                        return max($totalTugasUntukDia - $sudahDikerjakan, 0);
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('Filter Kelompok')
                    ->relationship('profile.group', 'name'),
            ])
            ->emptyStateHeading('Belum ada peserta di kelompok yang kena tugas Anda')
            ->emptyStateDescription('Buat tugas dan pilih kelompok untuk melihat progress murid di sini.');
    }
}
