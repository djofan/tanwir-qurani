<?php

namespace App\Observers;

use App\Models\Profile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProfileObserver
{
    public function saved(Profile $profile): void
    {
        if (! $profile->kelurahan_nama) {
            return;
        }

        $shouldGeocode = $profile->wasChanged('kelurahan_id')
            || (! $profile->latitude && $profile->kelurahan_nama);

        if ($shouldGeocode) {
            $this->geocodeWithFallback($profile);
        }
    }

    private function geocodeWithFallback(Profile $profile): void
    {
        $attempts = [
            implode(', ', array_filter([
                $profile->kelurahan_nama,
                $profile->kecamatan_nama,
                $profile->kota_nama,
                $profile->provinsi_nama,
            ])),
            implode(', ', array_filter([
                $profile->kecamatan_nama,
                $profile->kota_nama,
                $profile->provinsi_nama,
            ])),
            implode(', ', array_filter([
                $profile->kota_nama,
                $profile->provinsi_nama,
            ])),
            $profile->provinsi_nama,
        ];

        foreach ($attempts as $query) {
            if (! $query) continue;

            $coords = $this->geocode($query . ', Indonesia');

            if ($coords) {
                $profile->updateQuietly([
                    'latitude'  => $coords['lat'],
                    'longitude' => $coords['lon'],
                ]);
                return;
            }
        }

        Log::warning("Geocoding gagal total untuk profile {$profile->id}: {$profile->kelurahan_nama}");
    }

    private function geocode(string $query): ?array
    {
        try {
            $response = Http::timeout(10)->withHeaders([
                'User-Agent' => 'TadarusApp/1.0',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q'            => $query,
                'format'       => 'json',
                'limit'        => 1,
                'countrycodes' => 'id',
            ]);

            $data = $response->json();

            if (! empty($data)) {
                return [
                    'lat' => (float) $data[0]['lat'],
                    'lon' => (float) $data[0]['lon'],
                ];
            }
        } catch (\Exception $e) {
            Log::warning("Geocoding error untuk \"{$query}\": {$e->getMessage()}");
        }

        return null;
    }
}