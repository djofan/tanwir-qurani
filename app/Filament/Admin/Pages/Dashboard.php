<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\AdminNewUsersTable;
use App\Filament\Admin\Widgets\AdminStatsOverview;
use App\Filament\Admin\Widgets\PetaIndonesiaWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = '/';

    protected static ?string $title = 'Dashboard Admin';

    public function getWidgets(): array
    {
        return [
            AdminStatsOverview::class,
            PetaIndonesiaWidget::class,
            AdminNewUsersTable::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 1;
    }
}