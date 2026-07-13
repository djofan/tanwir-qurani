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
                ->description('Tugas saya / yang saya approve')
                ->color('warning'),

            Stat::make('Tugas Saya', $tugasSaya)
                ->description('Tugas yang saya buat')
                ->color('success'),

            Stat::make('Total Bisa Saya Review', $tugasSayaApprove)
                ->description('Tugas saya + jadi approver')
                ->color('info'),
        ];
    }
}
