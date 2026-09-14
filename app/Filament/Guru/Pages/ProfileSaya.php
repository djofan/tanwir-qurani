<?php

namespace App\Filament\Guru\Pages;

use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class ProfilSaya extends Page implements HasSchemas
{
    use InteractsWithSchemas;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $navigationLabel = 'Profil Saya';

    protected static ?string $slug = 'profil-saya';

    protected string $view = 'filament.guru.pages.profil-saya';

    public function getTitle(): string
    {
        return 'Profil Saya';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Profil')
                ->icon('heroicon-o-pencil-square')
                ->url(fn () => EditProfilSaya::getUrl()),
        ];
    }

    public function profilInfolist(Schema $schema): Schema
    {
        /** @var User $user */
        $user = Auth::user();

        return $schema
            ->record($user)
            ->components([
                Section::make('Detail Akun')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('name')
                                ->label('Nama Lengkap')
                                ->icon('heroicon-m-user')
                                ->weight('bold'),

                            TextEntry::make('code')
                                ->label('Kode Login')
                                ->icon('heroicon-m-identification')
                                ->badge()
                                ->color('success')
                                ->copyable()
                                ->copyMessage('Kode disalin!'),

                            TextEntry::make('email')
                                ->label('Email')
                                ->icon('heroicon-m-envelope')
                                ->default('-')
                                ->copyable(),

                            TextEntry::make('kelompokDiampu.name')
                                ->label('Kelompok yang Diampu')
                                ->badge()
                                ->color('info')
                                ->separator(', ')
                                ->default('Belum ada kelompok'),
                        ]),
                    ]),

                Section::make('Informasi Profil')
                    ->schema([
                        Grid::make(2)->schema([
                            TextEntry::make('profile.nomor_hp')
                                ->label('Nomor HP')
                                ->icon('heroicon-m-phone')
                                ->default('-'),

                            TextEntry::make('profile.gender')
                                ->label('Jenis Kelamin')
                                ->formatStateUsing(fn ($state) => match ($state) {
                                    'laki-laki' => '👨 Laki-laki',
                                    'perempuan' => '👩 Perempuan',
                                    default     => '-',
                                }),

                            TextEntry::make('profile.alamat_lengkap')
                                ->label('Alamat Lengkap')
                                ->icon('heroicon-m-map-pin')
                                ->default('-')
                                ->columnSpanFull(),
                        ]),
                    ]),
            ]);
    }
}