<?php

namespace App\Filament\Guru\Resources;

use App\Filament\Guru\Resources\AnakDidikGuruResource\Pages;
use App\Models\AnakDidik;
use App\Models\Group;
use BackedEnum;
use Filament\Resources\Resource;
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
            ->emptyStateHeading('Belum ada data anak didik dari peserta di kelompok Anda');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnakDidikGurus::route('/'),
        ];
    }
}
