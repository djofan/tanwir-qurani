<?php

namespace App\Filament\Guru\Resources\TugasGuruResource\Pages;

use App\Filament\Guru\Resources\TugasGuruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditTugasGuru extends EditRecord
{
    protected static string $resource = TugasGuruResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Pastikan tetap konsisten ke kelompok yang di-PIC-in guru ini
        $groupIds = \App\Models\Group::where('guru_id', Auth::id())->pluck('id');

        $this->record->groups()->sync($groupIds);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
