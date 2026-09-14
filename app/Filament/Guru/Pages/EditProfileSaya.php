<?php

namespace App\Filament\Guru\Pages;

use App\Filament\Concerns\HasWilayahFormFields;
use App\Models\User;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EditProfilSaya extends Page implements HasSchemas
{
    use HasWilayahFormFields;
    use InteractsWithSchemas;

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.guru.pages.edit-profil-saya';

    protected static ?string $slug = 'profil-saya/edit';

    public ?array $data = [];

    public function getTitle(): string
    {
        return 'Edit Profil';
    }

    public function mount(): void
    {
        /** @var User $user */
        $user = Auth::user();
        $profile = $user->profile;

        $this->form->fill([
            'name'  => $user->name,
            'email' => $user->email,

            'nomor_hp'       => $profile?->nomor_hp,
            'gender'         => $profile?->gender,
            'provinsi_id'    => $profile?->provinsi_id,
            'provinsi_nama'  => $profile?->provinsi_nama,
            'kota_id'        => $profile?->kota_id,
            'kota_nama'      => $profile?->kota_nama,
            'kecamatan_id'   => $profile?->kecamatan_id,
            'kecamatan_nama' => $profile?->kecamatan_nama,
            'kelurahan_id'   => $profile?->kelurahan_id,
            'kelurahan_nama' => $profile?->kelurahan_nama,
            'alamat'         => $profile?->alamat,
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Akun')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Email (opsional)')
                            ->email()
                            ->nullable()
                            ->rule(fn () => Rule::unique('users', 'email')->ignore(Auth::id()))
                            ->maxLength(255),

                        TextInput::make('password')
                            ->label('Password Baru')
                            ->password()
                            ->revealable()
                            ->autocomplete('new-password')
                            ->extraInputAttributes(['autocomplete' => 'new-password'])
                            ->maxLength(255)
                            ->helperText('Kosongkan jika tidak ingin mengubah password'),
                    ])->columns(2),

                Section::make('Informasi Profil')
                    ->schema([
                        TextInput::make('nomor_hp')
                            ->label('Nomor HP')
                            ->tel()
                            ->maxLength(15),

                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'laki-laki' => '👨 Laki-laki',
                                'perempuan' => '👩 Perempuan',
                            ])
                            ->native(false),

                        ...static::wilayahFormFields(),

                        Textarea::make('alamat')
                            ->label('Alamat Detail (Nama Jalan, Perumahan, RT/RW)')
                            ->rows(3)
                            ->placeholder('Contoh: Puri Nirwana 3, Blok C No. 5, RT 02/RW 04')
                            ->columnSpanFull(),
                    ])->columns(2),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),

            Action::make('cancel')
                ->label('Batal')
                ->color('gray')
                ->url(fn () => ProfilSaya::getUrl()),
        ];
    }

    public function save(): void
    {
        $data = $this->form->getState();

        /** @var User $user */
        $user = Auth::user();

        $userData = [
            'name'  => $data['name'],
            'email' => $data['email'],
        ];

        if (filled($data['password'] ?? null)) {
            $userData['password'] = Hash::make($data['password']);
        }

        $user->update($userData);

        $user->profile()->updateOrCreate([], [
            'nomor_hp'       => $data['nomor_hp'] ?? null,
            'gender'         => $data['gender'] ?? null,
            'provinsi_id'    => $data['provinsi_id'] ?? null,
            'provinsi_nama'  => $data['provinsi_nama'] ?? null,
            'kota_id'        => $data['kota_id'] ?? null,
            'kota_nama'      => $data['kota_nama'] ?? null,
            'kecamatan_id'   => $data['kecamatan_id'] ?? null,
            'kecamatan_nama' => $data['kecamatan_nama'] ?? null,
            'kelurahan_id'   => $data['kelurahan_id'] ?? null,
            'kelurahan_nama' => $data['kelurahan_nama'] ?? null,
            'alamat'         => $data['alamat'] ?? null,
        ]);

        Notification::make()
            ->title('Profil berhasil diperbarui')
            ->success()
            ->send();

        $this->redirect(ProfilSaya::getUrl());
    }
}