<?php

namespace App\Filament\Peserta\Pages;

use App\Filament\Peserta\Widgets\PesertaShortcutTable;
use App\Filament\Peserta\Widgets\PesertaStatsOverview;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = '/';

    protected static ?string $title = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            PesertaStatsOverview::class,
            PesertaShortcutTable::class,
        ];
    }
}