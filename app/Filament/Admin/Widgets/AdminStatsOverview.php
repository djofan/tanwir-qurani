<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Task;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
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
        return [
            Stat::make('Guru', User::where('role', 'guru')->count()) // Judul dipersingkat agar muat
                ->description('Aktif') // Deskripsi dibuat ringkas
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),
            
            Stat::make('Peserta', User::where('role', 'peserta')->count())
                ->description('Aktif')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),
            
            Stat::make('Tugas', Task::count())
                ->description('Total')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('warning'),
        ];
    }
}