<?php

namespace App\Filament\Admin\Resources\GroupResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProfilesRelationManager extends RelationManager
{
    protected static string $relationship = 'profiles';

    protected static ?string $title = 'Anggota Kelompok';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('user.name')
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('user.code')
                    ->label('Kode Akun')
                    ->badge()
                    ->color('success')
                    ->copyable(),

                TextColumn::make('user.role')
                    ->label('Role')
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'guru'    => 'Guru',
                        'peserta' => 'Peserta',
                        'admin'   => 'Admin',
                        default   => '-',
                    })
                    ->badge()
                    ->color(fn (?string $state) => $state === 'guru' ? 'warning' : 'info'),

                TextColumn::make('nomor_hp')
                    ->label('No. HP')
                    ->default('-'),

                TextColumn::make('tempat_mengajar')
                    ->label('Tempat Mengajar / TPQ')
                    ->default('-'),
            ])
            ->emptyStateHeading('Belum ada anggota di kelompok ini');
    }
}
