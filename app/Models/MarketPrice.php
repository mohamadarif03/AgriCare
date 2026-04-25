<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    protected $fillable = [
        'komoditas',
        'tanggal',
        'harga',
        'wilayah',
        'sumber',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'harga'   => 'integer',
    ];

    // ─── Scopes ──────────────────────────────────────────────────────────────

    public function scopeForCommodity($query, string $komoditas)
    {
        return $query->where('komoditas', $komoditas);
    }

    public function scopeForRegion($query, string $wilayah)
    {
        return $query->where('wilayah', $wilayah);
    }

    public function scopeRecent($query, int $months = 3)
    {
        return $query->where('tanggal', '>=', now()->subMonths($months));
    }

    // ─── Helpers ─────────────────────────────────────────────────────────────

    /**
     * Daftar komoditas yang tersedia.
     */
    public static function availableCommodities(): array
    {
        return [
            'padi'         => 'Padi',
            'jagung'       => 'Jagung',
            'cabai_merah'  => 'Cabai Merah',
            'cabai_rawit'  => 'Cabai Rawit',
            'bawang_merah' => 'Bawang Merah',
            'bawang_putih' => 'Bawang Putih',
            'kedelai'      => 'Kedelai',
            'gula_pasir'   => 'Gula Pasir',
        ];
    }

    /**
     * Daftar wilayah yang tersedia.
     */
    public static function availableRegions(): array
    {
        return [
            'cilacap'        => 'Cilacap, Jawa Tengah',
            'semarang'       => 'Semarang, Jawa Tengah',
            'surabaya'       => 'Surabaya, Jawa Timur',
            'jakarta'        => 'Jakarta',
            'bandung'        => 'Bandung, Jawa Barat',
            'yogyakarta'     => 'Yogyakarta',
            'solo'           => 'Solo, Jawa Tengah',
            'malang'         => 'Malang, Jawa Timur',
        ];
    }
}
