<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPriceInsight extends Model
{
    protected $fillable = [
        'komoditas',
        'wilayah',
        'insight_data',
        'expires_at',
    ];

    protected $casts = [
        'insight_data' => 'array',
        'expires_at'   => 'datetime',
    ];

    /**
     * Cek apakah cache masih valid (belum expired).
     */
    public function isValid(): bool
    {
        return $this->expires_at && $this->expires_at->isFuture();
    }

    /**
     * Ambil insight yang masih valid untuk komoditas + wilayah tertentu.
     */
    public static function getCached(string $komoditas, string $wilayah): ?array
    {
        $insight = static::where('komoditas', $komoditas)
            ->where('wilayah', $wilayah)
            ->first();

        if ($insight && $insight->isValid()) {
            return $insight->insight_data;
        }

        return null;
    }

    /**
     * Simpan / update insight cache (6 jam).
     */
    public static function cacheInsight(string $komoditas, string $wilayah, array $data): static
    {
        return static::updateOrCreate(
            ['komoditas' => $komoditas, 'wilayah' => $wilayah],
            [
                'insight_data' => $data,
                'expires_at'   => now()->addHours(6),
            ]
        );
    }
}
