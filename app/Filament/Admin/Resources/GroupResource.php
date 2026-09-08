<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GroupResource\Pages;
use App\Filament\Admin\Resources\GroupResource\RelationManagers\ProfilesRelationManager;
use App\Models\Group;
use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $navigationLabel = 'Kelompok';

    protected static ?string $modelLabel = 'Kelompok';

    protected static ?string $pluralModelLabel = 'Data Kelompok';

    protected static ?string $slug = 'kelompok';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Kelompok')
                    ->schema([
                        Hidden::make('program')
                            ->default('tanwir_qurani')
                            ->dehydrated(),

                        Select::make('guru_id')
                            ->label('PIC (Guru)')
                            ->options(fn () => User::where('role', 'guru')->pluck('name', 'id'))
                            ->searchable()
                            ->native(false)
                            ->required()
                            ->helperText('Guru yang menaungi & bertanggung jawab atas kelompok ini')
                            ->columnSpanFull(),

                        TextInput::make('name')
                            ->label('Nama Kelompok')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Kelompok Tanwir Qurani'),

                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Ringkasan')
                    ->visible(fn (?Group $record) => $record !== null)
                    ->columns(2)
                    ->schema([
                        Placeholder::make('profiles_count')
                            ->label('Jumlah Anggota')
                            ->content(fn (?Group $record) => $record ? $record->profiles()->count() . ' orang' : '-'),

                        Placeholder::make('tasks_count')
                            ->label('Tugas Terkirim')
                            ->content(fn (?Group $record) => $record ? $record->tasks()->count() . ' tugas' : '-'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Kode')
                    ->badge()
                    ->color('success')
                    ->copyable(),

                TextColumn::make('name')
                    ->label('Nama Kelompok')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('guru.name')
                    ->label('PIC (Guru)')
                    ->badge()
                    ->color('warning')
                    ->default('Belum ada PIC')
                    ->searchable(),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->default('-')
                    ->limit(50)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('profiles_count')
                    ->label('Jumlah Anggota')
                    ->counts('profiles')
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('tasks_count')
                    ->label('Tugas Terkirim')
                    ->counts('tasks')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProfilesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGroups::route('/'),
            'create' => Pages\CreateGroup::route('/create'),
            'edit'   => Pages\EditGroup::route('/{record}/edit'),
        ];
    }
}