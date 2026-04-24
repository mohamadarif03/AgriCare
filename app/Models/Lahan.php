<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lahan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'nama',
        'komoditas',
        'luas',
        'foto',
        'alamat',
        'kode_wilayah',
        'provinsi',
        'kota',
        'kecamatan',
        'kelurahan',
        'latitude',
        'longitude',
        'fase_tanam',
        'tanggal_tanam',
        'estimasi_panen',
        'durasi_tanam_hari',
        'status_risiko',
        'status_risiko_updated_at',
        'kalender_tanam',
        'kalender_tanam_generated_at',
        'notifikasi_aktif',
        'is_aktif',
    ];

    protected $casts = [
        'tanggal_tanam'               => 'date',
        'estimasi_panen'              => 'date',
        'status_risiko_updated_at'    => 'datetime',
        'kalender_tanam'              => 'array',
        'kalender_tanam_generated_at' => 'datetime',
        'notifikasi_aktif'            => 'boolean',
        'is_aktif'                    => 'boolean',
        'luas'                        => 'decimal:2',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke riwayat musim tanam
    public function musimTanams()
    {
        return $this->hasMany(MusimTanam::class);
    }

    // Helper: progress fase tanam (0-100)
    public function getFaseProgressAttribute(): int
    {
        $map = [
            'persiapan'   => 5,
            'persemaian'  => 15,
            'tanam'       => 30,
            'vegetatif'   => 55,
            'generatif'   => 80,
            'panen'       => 95,
            'pasca_panen' => 100,
        ];
        return $map[$this->fase_tanam] ?? 0;
    }

    // Helper: label fase tanam (Indonesia)
    public function getFaseLabelAttribute(): string
    {
        $labels = [
            'persiapan'   => 'Persiapan Lahan',
            'persemaian'  => 'Persemaian',
            'tanam'       => 'Penanaman',
            'vegetatif'   => 'Vegetatif',
            'generatif'   => 'Generatif',
            'panen'       => 'Panen',
            'pasca_panen' => 'Pasca Panen',
        ];
        return $labels[$this->fase_tanam] ?? ucfirst($this->fase_tanam);
    }

    // Helper: warna status risiko
    public function getRisikoBadgeClassAttribute(): string
    {
        return match ($this->status_risiko) {
            'kritis'  => 'bg-red-500',
            'waspada' => 'bg-amber-500',
            default   => 'bg-green-600',
        };
    }

    // Helper: label status risiko
    public function getRisikoLabelAttribute(): string
    {
        return match ($this->status_risiko) {
            'kritis'  => 'Kritis',
            'waspada' => 'Waspada',
            default   => 'Aman',
        };
    }

    // Scope: hanya lahan aktif
    public function scopeAktif($query)
    {
        return $query->where('is_aktif', true);
    }

    // Scope: milik user tertentu
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Foto URL helper
    public function getFotoUrlAttribute(): string
    {
        if ($this->foto && file_exists(public_path('storage/' . $this->foto))) {
            return asset('storage/' . $this->foto);
        }
        // Default image berdasarkan komoditas
        $defaults = [
            'padi'         => 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80',
            'jagung'       => 'https://images.unsplash.com/photo-1551754655-cd27e38d2076?auto=format&fit=crop&w=800&q=80',
            'cabai'        => 'https://images.unsplash.com/photo-1592982537447-7440770cbfc9?auto=format&fit=crop&w=800&q=80',
            'bawang_merah' => 'https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?auto=format&fit=crop&w=800&q=80',
            'kedelai'      => 'https://images.unsplash.com/photo-1558818498-28c1e002b655?auto=format&fit=crop&w=800&q=80',
        ];
        return $defaults[$this->komoditas] ?? 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?auto=format&fit=crop&w=800&q=80';
    }
}
