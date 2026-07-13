<?php

namespace App\Http\Controllers;

use App\Services\WilayahService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WilayahController extends Controller
{
    public function provinsi()
    {
        return response()->json(WilayahService::provinsi());
    }

    public function kota(string $provinsiId)
    {
        return response()->json(WilayahService::kota($provinsiId));
    }

    public function kecamatan(string $kotaId)
    {
        return response()->json(WilayahService::kecamatan($kotaId));
    }

    public function kelurahan(string $kecamatanId)
    {
        return response()->json(WilayahService::kelurahan($kecamatanId));
    }

    public function geocodeKelurahan(Request $request)
    {
        $query = $request->input('query');

        $response = Http::timeout(10)->withHeaders(['User-Agent' => 'TadarusApp/1.0'])
            ->get('https://nominatim.openstreetmap.org/search', [
                'q'            => $query,
                'format'       => 'json',
                'limit'        => 1,
                'countrycodes' => 'id',
            ]);

        $data = $response->json();

        if (! empty($data)) {
            return response()->json([
                'lat' => (float) $data[0]['lat'],
                'lon' => (float) $data[0]['lon'],
            ]);
        }

        return response()->json(null);
    }
}