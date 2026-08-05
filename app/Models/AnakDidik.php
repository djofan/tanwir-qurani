<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnakDidik extends Model
{
    protected $fillable = [
        'peserta_id',
        'nama',
        'usia',
        'kelas',
        'nama_orang_tua',
        'nomor_orang_tua',
        'progres_belajar',
    ];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(User::class, 'peserta_id');
    }
}
