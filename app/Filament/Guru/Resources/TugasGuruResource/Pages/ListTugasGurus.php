<?php

namespace App\Filament\Guru\Resources\TugasGuruResource\Pages;

use App\Filament\Guru\Resources\TugasGuruResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTugasGurus extends ListRecords
{
    protected static string $resource = TugasGuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Buat Tugas Baru'),
        ];
    }
}