<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\GroupResource\Pages;
use App\Models\Group;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
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
                        Select::make('program')
                            ->label('Program')
                            ->options([
                                'tanwir_qurani' => 'Tanwir Qurani (kode: TQ)',
                                'ojol_mengaji'  => 'Ojol Mengaji (kode: OM)',
                            ])
                            ->required()
                            ->native(false)
                            ->helperText('Kode kelompok otomatis dibuat urut sesuai program: TQ001, TQ002, dst / OM001, OM002, dst'),

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

                TextColumn::make('program')
                    ->label('Program')
                    ->formatStateUsing(fn (?string $state) => match ($state) {
                        'ojol_mengaji'  => 'Ojol Mengaji',
                        'tanwir_qurani' => 'Tanwir Qurani',
                        default         => '-',
                    })
                    ->badge()
                    ->color(fn (?string $state) => $state === 'ojol_mengaji' ? 'warning' : 'info'),

                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->default('-')
                    ->limit(50),

                TextColumn::make('profiles_count')
                    ->label('Jumlah Anggota')
                    ->counts('profiles')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('tasks_count')
                    ->label('Tugas Terkirim')
                    ->counts('tasks')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
