<?php

namespace App\Filament\Admin\Resources\AnakDidikResource\Pages;

use App\Filament\Admin\Resources\AnakDidikResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAnakDidiks extends ListRecords
{
    protected static string $resource = AnakDidikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Anak Didik'),
        ];
    }
}
