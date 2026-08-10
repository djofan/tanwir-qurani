<?php

namespace App\Filament\Peserta\Resources\AnakDidikResource\Pages;

use App\Filament\Peserta\Resources\AnakDidikResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateAnakDidik extends CreateRecord
{
    protected static string $resource = AnakDidikResource::class;

    protected function getRedirectUrl(): string
    {
        // Balik lagi ke form Tambah biar bisa langsung isi data anak berikutnya
        return static::getResource()::getUrl('create');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Data anak tersimpan')
            ->body('Silakan isi data anak berikutnya.');
    }
}
