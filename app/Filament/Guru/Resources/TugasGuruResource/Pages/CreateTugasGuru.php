<?php

namespace App\Filament\Guru\Resources\TugasGuruResource\Pages;

use App\Filament\Guru\Resources\TugasGuruResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateTugasGuru extends CreateRecord
{
    protected static string $resource = TugasGuruResource::class;

    protected array $approverIds = [];
    protected array $groupIds = [];

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['teacher_id'] = Auth::id();

        // 'approver_ids' dan 'group_ids' bukan kolom di tabel tasks, jadi dikeluarkan dulu
        // dan disimpan buat di-sync ke pivot table setelah task-nya dibuat.
        $this->approverIds = $data['approver_ids'] ?? [];
        $this->groupIds    = $data['group_ids'] ?? [];
        unset($data['approver_ids'], $data['group_ids']);

        return $data;
    }

    protected function afterCreate(): void
    {
        $this->record->approvers()->sync($this->approverIds);
        $this->record->groups()->sync($this->groupIds);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
