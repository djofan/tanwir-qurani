<?php

namespace App\Filament\Peserta\Resources\AnakDidikResource\Pages;

use App\Filament\Peserta\Resources\AnakDidikResource;
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
