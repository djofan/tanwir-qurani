<?php

namespace App\Filament\Admin\Widgets;

use App\Models\User;
use Filament\Widgets\Widget;

class PetaIndonesiaWidget extends Widget
{
    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.admin.widgets.peta-indonesia-widget';

    public function getLocations(): array
    {
        return User::whereIn('role', ['guru', 'peserta'])
            ->whereHas('profile', function ($q) {
                $q->whereNotNull('latitude')->whereNotNull('longitude');
            })
            ->with('profile')
            ->get()
            ->map(function (User $user) {
                return [
                    'name'   => $user->name,
                    'role'   => $user->role,
                    'alamat' => $user->profile->alamat_lengkap,
                    'lat'    => (float) $user->profile->latitude,
                    'lng'    => (float) $user->profile->longitude,
                ];
            })
            ->values()
            ->toArray();
    }
}