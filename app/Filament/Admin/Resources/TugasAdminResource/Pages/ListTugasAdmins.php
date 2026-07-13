<?php

namespace App\Filament\Admin\Resources\TugasAdminResource\Pages;

use App\Filament\Admin\Resources\TugasAdminResource;
use Filament\Resources\Pages\ListRecords;

class ListTugasAdmins extends ListRecords
{
    protected static string $resource = TugasAdminResource::class;

    protected function getHeaderActions(): array
    {
        return []; 
    }
}