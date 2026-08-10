<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\AnakDidikGuruResource\Pages;
use App\Models\AnakDidik;
use App\Models\Group;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AnakDidikGuruResource extends Resource
{
    protected static ?string $model = AnakDidik::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Data Anak Didik';

    protected static ?string $modelLabel = 'Anak Didik';

    protected static ?string $pluralModelLabel = 'Data Anak Didik';

    protected static ?string $slug = 'anak-didik';

    protected static ?int $navigationSort = 6;

    /**
     * Peserta (guru ngaji) yang ada di kelompok-kelompok yang di-PIC-in guru ini.
     */
    protected static function pesertaOptions()
    {
        $groupIds = Group::where('guru_id', Auth::id())->pluck('id');

        return User::where('role', 'peserta')
            ->whereHas('profile', fn (Builder $q) => $q->whereIn('group_id', $groupIds))
            ->pluck('name', 'id');
    }

    public static function getEloquentQuery(): Builder
    {
        $guruId = Auth::id();

        $groupIds = Group::where('guru_id', $guruId)->pluck('id');

        return parent::getEloquentQuery()
            ->whereHas('peserta.profile', function (Builder $q) use ($groupIds) {
                $q->whereIn('group_id', $groupIds);
            })
            ->with(['peserta.profile.group']);
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
                            ->options(fn () => static::pesertaOptions())
                            ->searchable()
                            ->required()
                            ->native(false)
                            ->helperText('Cuma peserta di kelompok yang kamu naungi yang bisa dipilih')
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
                TextColumn::make('nama')
                    ->label('Nama Anak')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('usia')
                    ->label('Usia')
                    ->suffix(' th')
                    ->default('-'),

                TextColumn::make('kelas')
                    ->label('Kelas')
                    ->default('-')
                    ->badge()
                    ->color('info'),

                TextColumn::make('peserta.name')
                    ->label('Guru Ngaji (Peserta)')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('peserta.profile.group.name')
                    ->label('Kelompok')
                    ->badge()
                    ->color('success')
                    ->default('-'),

                TextColumn::make('nama_orang_tua')
                    ->label('Orang Tua')
                    ->default('-'),

                TextColumn::make('nomor_orang_tua')
                    ->label('No. HP Ortu')
                    ->default('-'),

                TextColumn::make('progres_belajar')
                    ->label('Progres Belajar')
                    ->limit(40)
                    ->default('-')
                    ->tooltip(fn (AnakDidik $record) => $record->progres_belajar),

                TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                SelectFilter::make('peserta')
                    ->label('Guru Ngaji (Peserta)')
                    ->relationship('peserta', 'name'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('Belum ada data anak didik dari peserta di kelompok Anda');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAnakDidikGurus::route('/'),
            'create' => Pages\CreateAnakDidikGuru::route('/create'),
            'edit'   => Pages\EditAnakDidikGuru::route('/{record}/edit'),
        ];
    }
}
