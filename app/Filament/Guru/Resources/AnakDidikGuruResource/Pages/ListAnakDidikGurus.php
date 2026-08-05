<?php

namespace App\Filament\Guru\Resources\AnakDidikGuruResource\Pages;

use App\Filament\Guru\Resources\AnakDidikGuruResource;
use Filament\Resources\Pages\ListRecords;

class ListAnakDidikGurus extends ListRecords
{
    protected static string $resource = AnakDidikGuruResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
