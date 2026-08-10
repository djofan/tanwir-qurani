<?php

namespace App\Filament\Guru\Resources\TugasGuruResource\Pages;

use App\Filament\Guru\Resources\TugasGuruResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTugasGuru extends CreateRecord
{
    protected static string $resource = TugasGuruResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['teacher_id'] = Auth::id();

        return $data;
    }

    protected function afterCreate(): void
    {
        // Tugas otomatis dikirim ke semua kelompok yang di-PIC-in guru ini,
        // gak perlu manual pilih kelompok lagi.
        $groupIds = \App\Models\Group::where('guru_id', Auth::id())->pluck('id');

        $this->record->groups()->sync($groupIds);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
