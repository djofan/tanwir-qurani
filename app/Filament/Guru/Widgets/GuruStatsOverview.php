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

    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int | array
    {
        return [
            'default' => 3,
            'md' => 3,
        ];
    }

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
            Stat::make('Tugas Terkumpul', $butuhPeriksa)
                ->description($butuhPeriksa > 0 ? 'Butuh dikoreksi' : 'Semua selesai ')
                ->color($butuhPeriksa > 0 ? 'danger' : 'success')
                ->extraAttributes($butuhPeriksa > 0 ? [
                    'class' => 'ring-2 ring-danger-400 ring-offset-2 ring-offset-white dark:ring-offset-gray-900 animate-pulse',
                ] : []),

            Stat::make('Tugas Saya', $tugasSaya)
                ->description('Tugas yang dibuat')
                ->color('success'),

            Stat::make('Total Review', $tugasSayaApprove)
                ->description('Selesai direview')
                ->color('info'),
        ];
    }
}
