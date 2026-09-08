<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AnakDidikResource\Pages;
use App\Models\AnakDidik;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AnakDidikResource extends Resource
{
    protected static ?string $model = AnakDidik::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Data Anak Didik';

    protected static ?string $modelLabel = 'Anak Didik';

    protected static ?string $pluralModelLabel = 'Data Anak Didik';

    protected static ?string $slug = 'anak-didik';

    protected static ?int $navigationSort = 5;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return false;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Anak')
                    ->columns(2)
                    ->schema([
                        Select::make('peserta_id')
                            ->label('Peserta (Guru Ngaji)')
                            ->options(fn () => User::where('role', 'peserta')->pluck('name', 'id'))
                            ->searchable()
                            ->required()
                            ->native(false)
                            ->columnSpanFull(),

                        TextInput::make('nama')
                            ->label('Nama Anak')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('usia')
                            ->label('Usia')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(99)
                            ->suffix('tahun'),

                        TextInput::make('kelas')
                            ->label('Kelas')
                            ->placeholder('Contoh: Iqro 3, Al-Qur\'an Juz 5, TK B')
                            ->maxLength(255),

                        TextInput::make('nama_orang_tua')
                            ->label('Nama Orang Tua / Wali')
                            ->maxLength(255),

                        TextInput::make('nomor_orang_tua')
                            ->label('Nomor HP Orang Tua / Wali')
                            ->tel()
                            ->maxLength(30),

                        Textarea::make('progres_belajar')
                            ->label('Progres Belajar / Hafalan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Kolom Utama yang selalu tampil di Mobile
                TextColumn::make('nama')
                    ->label('Nama Anak')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kelas')
                    ->label('Kelas')
                    ->default('-')
                    ->badge()
                    ->color('info'),

                TextColumn::make('peserta.name')
                    ->label('Peserta (Guru Ngaji)')
                    ->searchable()
                    ->sortable(),

                // Kolom Pendukung yang disembunyikan di Mobile
                TextColumn::make('usia')
                    ->label('Usia')
                    ->suffix(' th')
                    ->default('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('peserta.profile.group.name')
                    ->label('Kelompok')
                    ->badge()
                    ->color('success')
                    ->default('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('nama_orang_tua')
                    ->label('Orang Tua')
                    ->default('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('nomor_orang_tua')
                    ->label('No. HP Ortu')
                    ->default('-')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                SelectFilter::make('peserta')
                    ->label('Peserta (Guru Ngaji)')
                    ->relationship('peserta', 'name')
                    ->searchable(),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->emptyStateHeading('Belum ada data anak didik');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAnakDidiks::route('/'),
            'view' => Pages\ViewAnakDidik::route('/{record}'),
            'edit'   => Pages\EditAnakDidik::route('/{record}/edit'),
        ];
    }
}