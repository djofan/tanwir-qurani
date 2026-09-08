<?php

namespace App\Filament\Guru\Resources\AnakDidikGuruResource\Pages;

use App\Filament\Guru\Resources\AnakDidikGuruResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class ViewAnakDidikGuru extends ViewRecord
{
    protected static string $resource = AnakDidikGuruResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Anak Didik')
                    ->schema([
                        TextEntry::make('nama')
                            ->label('Nama Anak'),
                        
                        TextEntry::make('usia')
                            ->label('Usia')
                            ->suffix(' tahun')
                            ->default('-'),

                        TextEntry::make('kelas')
                            ->label('Kelas')
                            ->badge()
                            ->color('info')
                            ->default('-'),

                        TextEntry::make('peserta.name')
                            ->label('Guru Ngaji (Peserta)')
                            ->default('-'),

                        TextEntry::make('peserta.profile.group.name')
                            ->label('Kelompok')
                            ->badge()
                            ->color('success')
                            ->default('-'),
                    ])
                    ->columns(2),

                Section::make('Informasi Orang Tua & Progres')
                    ->schema([
                        TextEntry::make('nama_orang_tua')
                            ->label('Nama Orang Tua / Wali')
                            ->default('-'),

                        TextEntry::make('nomor_orang_tua')
                            ->label('Nomor HP Orang Tua / Wali')
                            ->default('-'),

                        TextEntry::make('progres_belajar')
                            ->label('Progres Belajar / Hafalan')
                            ->columnSpanFull()
                            ->default('Belum ada catatan progres.'),
                    ])
                    ->columns(2),
            ]);
    }
}