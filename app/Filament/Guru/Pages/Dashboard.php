<?php

namespace App\Filament\Guru\Pages;

use App\Filament\Guru\Widgets\GuruApprovalWidget;
use App\Filament\Guru\Widgets\GuruPesertaTable;
use App\Filament\Guru\Widgets\GuruStatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = '/';

    protected static ?string $title = 'Dashboard Guru';

    public function getWidgets(): array
    {
        return [
            GuruStatsOverview::class,
            GuruApprovalWidget::class,
            GuruPesertaTable::class,
        ];
    }
}
