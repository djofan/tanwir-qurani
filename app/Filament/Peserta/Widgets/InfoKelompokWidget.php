<?php

namespace App\Filament\Peserta\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Auth;

class InfoKelompokWidget extends Widget
{
    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.peserta.widgets.info-kelompok-widget';

    public function getGroupName(): string
    {
        $group = Auth::user()->profile?->group;
        return $group?->name ?? 'Belum ditentukan';
    }

    public function getGroupDescription(): ?string
    {
        return Auth::user()->profile?->group?->description;
    }
}