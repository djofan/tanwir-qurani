<?php

namespace App\Filament\Peserta\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class ProgramBannerWidget extends Widget
{
    protected string $view = 'filament.peserta.widgets.program-banner-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'name' => Auth::user()?->name,
        ];
    }
}
