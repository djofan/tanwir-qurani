<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nomor_hp',
        'gender',
        'alamat',
        'foto',               // Dipertahankan dari kode lama
        'tempat_mengajar',   // Dipertahankan dari kode lama
        'provinsi_id',       // Baru
        'provinsi_nama',     // Baru
        'kota_id',           // Baru
        'kota_nama',         // Baru
        'kecamatan_id',      // Baru
        'kecamatan_nama',    // Baru
        'kelurahan_id',      // Baru
        'kelurahan_nama',    // Baru
        'latitude',
        'longitude',
        'group_id',
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * Alamat lengkap untuk ditampilkan di popup peta
     */
    public function getAlamatLengkapAttribute(): string
    {
        $parts = array_filter([
            $this->alamat,
            $this->kelurahan_nama,
            $this->kecamatan_nama,
            $this->kota_nama,
            $this->provinsi_nama,
        ]);
        
        return implode(', ', $parts) ?: '-';
    }
}