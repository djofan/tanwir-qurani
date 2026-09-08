<?php

namespace App\Filament\Admin\Resources\AnakDidikResource\Pages;

use App\Filament\Admin\Resources\AnakDidikResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAnakDidik extends ViewRecord
{
    protected static string $resource = AnakDidikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
