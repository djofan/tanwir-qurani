<?php

namespace App\Console\Commands;

use App\Models\Profile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GeocodeProfiles extends Command
{
    protected $signature = 'profiles:geocode';
    protected $description = 'Geocode kelurahan peserta/guru menjadi koordinat lat/long';

    public function handle(): void
    {
        $profiles = Profile::whereNotNull('kelurahan_nama')
            ->whereNull('latitude')
            ->get();

        if ($profiles->isEmpty()) {
            $this->info('Tidak ada data yang perlu di-geocode.');
            return;
        }

        $this->info("Geocoding {$profiles->count()} lokasi...");
        $bar = $this->output->createProgressBar($profiles->count());
        $bar->start();

        foreach ($profiles as $profile) {
            $coords = $this->geocodeWithFallback($profile);

            if ($coords) {
                $profile->update([
                    'latitude'  => $coords['lat'],
                    'longitude' => $coords['lon'],
                ]);
            } else {
                $this->newLine();
                $this->error("Gagal total untuk profile #{$profile->id} ({$profile->kelurahan_nama})");
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Selesai!');
    }


    private function geocodeWithFallback(Profile $profile): ?array
    {
        $attempts = [
            implode(', ', array_filter([
                $profile->kelurahan_nama,
                $profile->kecamatan_nama,
                $profile->kota_nama,
                $profile->provinsi_nama,
            ])),
            // Level 2: kecamatan + kota + provinsi
            implode(', ', array_filter([
                $profile->kecamatan_nama,
                $profile->kota_nama,
                $profile->provinsi_nama,
            ])),
            // Level 3: kota + provinsi
            implode(', ', array_filter([
                $profile->kota_nama,
                $profile->provinsi_nama,
            ])),
            // Level 4: provinsi saja (last resort)
            $profile->provinsi_nama,
        ];

        foreach ($attempts as $level => $query) {
            if (! $query) continue;

            $coords = $this->geocode($query . ', Indonesia');
            sleep(1); // Nominatim rate limit

            if ($coords) {
                if ($level > 0) {
                    $this->newLine();
                    $this->warn("⚠ Fallback level " . ($level + 1) . " dipakai untuk: {$profile->kelurahan_nama} -> ditemukan via \"{$query}\"");
                }
                return $coords;
            }
        }

        return null;
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
            $this->newLine();
            $this->error("Error geocoding \"{$query}\": {$e->getMessage()}");
        }

        return null;
    }
}