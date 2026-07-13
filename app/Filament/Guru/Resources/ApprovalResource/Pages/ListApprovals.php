<?php

namespace App\Filament\Guru\Resources\ApprovalResource\Pages;

use App\Filament\Guru\Resources\ApprovalResource;
use Filament\Resources\Pages\ListRecords;

class ListApprovals extends ListRecords
{
    protected static string $resource = ApprovalResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}