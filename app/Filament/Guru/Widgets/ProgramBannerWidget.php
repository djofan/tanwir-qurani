<?php

namespace App\Filament\Guru\Widgets;

use App\Models\Group;
use Filament\Widgets\Widget;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ProgramBannerWidget extends Widget
{
    protected string $view = 'filament.guru.widgets.program-banner-widget';

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public function getViewData(): array
    {
        $kelompokCount = Group::where('guru_id', Auth::id())->count();

        return [
            'name'          => Auth::user()?->name,
            'today'         => Carbon::now()->translatedFormat('l, d F Y'),
            'kelompokCount' => $kelompokCount,
        ];
    }
}
