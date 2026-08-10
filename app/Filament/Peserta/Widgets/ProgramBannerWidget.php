<?php

namespace App\Filament\Peserta\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProgramBannerWidget extends Widget
{
    protected string $view = 'filament.peserta.widgets.program-banner-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $user = Auth::user();

        return [
            'name'      => $user?->name,
            'today'     => Carbon::now()->translatedFormat('l, d F Y'),
            'groupName' => $user?->profile?->group?->name,
        ];
    }
}
