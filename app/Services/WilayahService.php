<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WilayahService
{
    private static string $baseUrl = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    public static function provinsi(): array
    {
        return Cache::remember('wilayah_provinsi', now()->addDays(30), function () {
            return Http::timeout(10)->get(self::$baseUrl . '/provinces.json')->json() ?? [];
        });
    }

    public static function kota(string $provinsiId): array
    {
        return Cache::remember("wilayah_kota_{$provinsiId}", now()->addDays(30), function () use ($provinsiId) {
            return Http::timeout(10)->get(self::$baseUrl . "/regencies/{$provinsiId}.json")->json() ?? [];
        });
    }

    public static function kecamatan(string $kotaId): array
    {
        return Cache::remember("wilayah_kecamatan_{$kotaId}", now()->addDays(30), function () use ($kotaId) {
            return Http::timeout(10)->get(self::$baseUrl . "/districts/{$kotaId}.json")->json() ?? [];
        });
    }

    public static function kelurahan(string $kecamatanId): array
    {
        return Cache::remember("wilayah_kelurahan_{$kecamatanId}", now()->addDays(30), function () use ($kecamatanId) {
            return Http::timeout(10)->get(self::$baseUrl . "/villages/{$kecamatanId}.json")->json() ?? [];
        });
    }
}