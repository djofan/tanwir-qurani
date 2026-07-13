<?php

namespace App\Filament\Admin\Resources\PesertaResource\Pages;

use App\Filament\Admin\Resources\PesertaResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreatePeserta extends CreateRecord
{
    protected static string $resource = PesertaResource::class;

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
            ->title('Peserta berhasil dibuat')
            ->body('Kode login: ' . $this->record->code . ' — catat/kasih tau kode ini ke pesertanya.')
            ->success()
            ->persistent();
    }
}
