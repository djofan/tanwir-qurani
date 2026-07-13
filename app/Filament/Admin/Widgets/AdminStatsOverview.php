<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Task;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Guru Aktif', User::where('role', 'guru')->where('status', true)->count())
                ->description('Guru yang sedang aktif')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),

            Stat::make('Total Peserta Aktif', User::where('role', 'peserta')->where('status', true)->count())
                ->description('Peserta yang sedang aktif')
                ->descriptionIcon('heroicon-m-users')
                ->color('info'),

            Stat::make('Total Tugas Berjalan', Task::count())
                ->description('Semua tugas yang terpublish')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning'),
        ];
    }
}