<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MusimTanam extends Model
{
    protected $fillable = [
        'lahan_id',
        'komoditas',
        'tanggal_tanam',
        'tanggal_panen',
        'hasil_panen_kg',
        'status',
        'catatan',
    ];

    protected $casts = [
        'tanggal_tanam'  => 'date',
        'tanggal_panen'  => 'date',
        'hasil_panen_kg' => 'decimal:2',
    ];

    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'berhasil'   => 'text-green-700 bg-green-100',
            'gagal'      => 'text-red-700 bg-red-100',
            default      => 'text-amber-700 bg-amber-100',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'berhasil'   => 'SUKSES',
            'gagal'      => 'GAGAL',
            default      => 'BERLANGSUNG',
        };
    }
}
