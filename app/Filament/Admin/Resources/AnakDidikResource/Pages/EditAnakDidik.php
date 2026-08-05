<?php

namespace App\Filament\Admin\Resources\AnakDidikResource\Pages;

use App\Filament\Admin\Resources\AnakDidikResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAnakDidik extends EditRecord
{
    protected static string $resource = AnakDidikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
