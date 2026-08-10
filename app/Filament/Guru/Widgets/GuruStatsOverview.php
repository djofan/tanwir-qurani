<?php

namespace App\Filament\Guru\Widgets;

use App\Models\Submission;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GuruStatsOverview extends BaseWidget
{
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $guruId = Auth::id();

        $scopeTask = fn (Builder $q) => $q->where('teacher_id', $guruId)
            ->orWhereHas('approvers', fn (Builder $q2) => $q2->where('users.id', $guruId));

        $butuhPeriksa = Submission::where('status', 'pending')
            ->whereHas('task', $scopeTask)
            ->count();

        $tugasSaya = Task::where('teacher_id', $guruId)->count();

        $tugasSayaApprove = Task::where(fn (Builder $q) => $scopeTask($q))->count();

        return [
            Stat::make('Butuh Diperiksa', $butuhPeriksa)
                ->description($butuhPeriksa > 0 ? '⚠️ Ada setoran menunggu koreksi kamu' : 'Semua sudah diperiksa 🎉')
                ->descriptionIcon($butuhPeriksa > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($butuhPeriksa > 0 ? 'danger' : 'success')
                ->icon('heroicon-o-inbox')
                ->extraAttributes($butuhPeriksa > 0 ? [
                    'class' => 'ring-2 ring-danger-400 ring-offset-2 ring-offset-white dark:ring-offset-gray-900 animate-pulse',
                ] : []),

            Stat::make('Tugas Saya', $tugasSaya)
                ->description('Tugas yang saya buat')
                ->color('success'),

            Stat::make('Total Bisa Saya Review', $tugasSayaApprove)
                ->description('Tugas saya + jadi approver')
                ->color('info'),
        ];
    }
}
