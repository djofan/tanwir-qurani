<?php

namespace App\Filament\Concerns;

use App\Services\WilayahService;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;

/**
 * Dipakai di halaman/form manapun yang butuh input wilayah bertingkat
 * (Provinsi -> Kota/Kabupaten -> Kecamatan -> Kelurahan) memakai WilayahService.
 *
 * Cara pakai:
 *   ...$schema->components([
 *       ...static::wilayahFormFields(),
 *   ])
 */
trait HasWilayahFormFields
{
    protected static function wilayahFormFields(): array
    {
        return [
            Select::make('provinsi_id')
                ->label('Provinsi')
                ->options(function () {
                    $data = WilayahService::provinsi();
                    return collect($data)->pluck('name', 'id');
                })
                ->searchable()
                ->live()
                ->afterStateUpdated(function ($state, $set) {
                    $set('kota_id', null);
                    $set('kecamatan_id', null);
                    $set('kelurahan_id', null);
                    $set('kota_nama', null);
                    $set('kecamatan_nama', null);
                    $set('kelurahan_nama', null);

                    if (! $state) {
                        $set('provinsi_nama', null);
                        return;
                    }
                    $data = WilayahService::provinsi();
                    $found = collect($data)->firstWhere('id', $state);
                    $set('provinsi_nama', $found['name'] ?? null);
                }),

            Select::make('kota_id')
                ->label('Kota / Kabupaten')
                ->options(function ($get) {
                    $provinsiId = $get('provinsi_id');
                    if (! $provinsiId) return [];
                    $data = WilayahService::kota($provinsiId);
                    return collect($data)->pluck('name', 'id');
                })
                ->searchable()
                ->live()
                ->disabled(fn ($get) => ! $get('provinsi_id'))
                ->afterStateUpdated(function ($state, $get, $set) {
                    $set('kecamatan_id', null);
                    $set('kelurahan_id', null);
                    $set('kecamatan_nama', null);
                    $set('kelurahan_nama', null);

                    $provinsiId = $get('provinsi_id');
                    if (! $provinsiId || ! $state) {
                        $set('kota_nama', null);
                        return;
                    }
                    $data = WilayahService::kota($provinsiId);
                    $found = collect($data)->firstWhere('id', $state);
                    $set('kota_nama', $found['name'] ?? null);
                }),

            Select::make('kecamatan_id')
                ->label('Kecamatan')
                ->options(function ($get) {
                    $kotaId = $get('kota_id');
                    if (! $kotaId) return [];
                    $data = WilayahService::kecamatan($kotaId);
                    return collect($data)->pluck('name', 'id');
                })
                ->searchable()
                ->live()
                ->disabled(fn ($get) => ! $get('kota_id'))
                ->afterStateUpdated(function ($state, $get, $set) {
                    $set('kelurahan_id', null);
                    $set('kelurahan_nama', null);

                    $kotaId = $get('kota_id');
                    if (! $kotaId || ! $state) {
                        $set('kecamatan_nama', null);
                        return;
                    }
                    $data = WilayahService::kecamatan($kotaId);
                    $found = collect($data)->firstWhere('id', $state);
                    $set('kecamatan_nama', $found['name'] ?? null);
                }),

            Select::make('kelurahan_id')
                ->label('Kelurahan / Desa')
                ->options(function ($get) {
                    $kecamatanId = $get('kecamatan_id');
                    if (! $kecamatanId) return [];
                    $data = WilayahService::kelurahan($kecamatanId);
                    return collect($data)->pluck('name', 'id');
                })
                ->searchable()
                ->live()
                ->disabled(fn ($get) => ! $get('kecamatan_id'))
                ->afterStateUpdated(function ($state, $get, $set) {
                    $kecamatanId = $get('kecamatan_id');
                    if (! $kecamatanId || ! $state) {
                        $set('kelurahan_nama', null);
                        return;
                    }
                    $data = WilayahService::kelurahan($kecamatanId);
                    $found = collect($data)->firstWhere('id', $state);
                    $set('kelurahan_nama', $found['name'] ?? null);
                }),

            Hidden::make('provinsi_nama'),
            Hidden::make('kota_nama'),
            Hidden::make('kecamatan_nama'),
            Hidden::make('kelurahan_nama'),
        ];
    }
}