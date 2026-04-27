<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendationChecklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'recommendation_id',
        'title',
        'detail',
        'estimasi_waktu',
        'dampak_jika_diabaikan',
        'kategori',
        'is_checked',
        'checked_at',
    ];

    protected $casts = [
        'is_checked' => 'boolean',
        'checked_at' => 'datetime',
    ];

    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class);
    }
}
