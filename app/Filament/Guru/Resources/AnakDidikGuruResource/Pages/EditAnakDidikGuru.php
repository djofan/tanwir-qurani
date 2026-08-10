<?php

namespace App\Filament\Guru\Resources\AnakDidikGuruResource\Pages;

use App\Filament\Guru\Resources\AnakDidikGuruResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAnakDidikGuru extends EditRecord
{
    protected static string $resource = AnakDidikGuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
