<?php

namespace App\Filament\Guru\Resources\TugasGuruResource\Pages;

use App\Filament\Guru\Resources\TugasGuruResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTugasGuru extends EditRecord
{
    protected static string $resource = TugasGuruResource::class;

    protected array $approverIds = [];
    protected array $groupIds = [];

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->approverIds = $data['approver_ids'] ?? [];
        $this->groupIds    = $data['group_ids'] ?? [];
        unset($data['approver_ids'], $data['group_ids']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->approvers()->sync($this->approverIds);
        $this->record->groups()->sync($this->groupIds);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
