<?php

namespace App\Filament\Admin\Resources\GuruResource\Pages;

use App\Filament\Admin\Resources\GuruResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateGuru extends CreateRecord
{
    protected static string $resource = GuruResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        $this->record->profile()->firstOrCreate([
            'user_id' => $this->record->id,
        ]);
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->title('Guru berhasil dibuat')
            ->body('Kode login: ' . $this->record->code . ' — catat/kasih tau kode ini ke gurunya.')
            ->success()
            ->persistent();
    }
}
