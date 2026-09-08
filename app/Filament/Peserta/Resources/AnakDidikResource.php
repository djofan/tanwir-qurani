<?php

namespace App\Filament\Peserta\Resources;

use App\Filament\Peserta\Resources\AnakDidikResource\Pages;
use App\Models\AnakDidik;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AnakDidikResource extends Resource
{
    protected static ?string $model = AnakDidik::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Data Anak Didik';

    protected static ?string $modelLabel = 'Anak Didik';

    protected static ?string $pluralModelLabel = 'Data Anak Didik';

    protected static ?string $slug = 'anak-didik';

    protected static ?int $navigationSort = 5;

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('peserta_id', Auth::id());
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Anak')
                    ->columns(2)
                    ->schema([
                        Hidden::make('peserta_id')
                            ->default(fn () => Auth::id())
                            ->dehydrated(),

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
                            ->placeholder('Contoh: Sudah hafal Juz 30, sedang belajar tajwid dasar')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Anak')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('kelas')
                    ->label('Kelas')
                    ->default('-')
                    ->badge()
                    ->color('info'),

                // Kolom di bawah ini disembunyikan secara default di mobile agar rapi
                TextColumn::make('usia')
                    ->label('Usia')
                    ->suffix(' th')
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

                TextColumn::make('progres_belajar')
                    ->label('Progres Belajar')
                    ->limit(40)
                    ->default('-')
                    ->tooltip(fn (AnakDidik $record) => $record->progres_belajar)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada data anak didik')
            ->emptyStateDescription('Klik "Tambah Anak Didik" untuk mulai mencatat data anak-anak di TPQ Anda.');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAnakDidiks::route('/'),
            'create' => Pages\CreateAnakDidik::route('/create'),
            'view'   => Pages\ViewAnakDidik::route('/{record}'),
            'edit'   => Pages\EditAnakDidik::route('/{record}/edit'),
        ];
    }
}
