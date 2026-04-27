<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lahan_id',
        'data_json',
        'generated_at',
        'is_archived',
    ];

    protected $casts = [
        'data_json' => 'array',
        'generated_at' => 'datetime',
        'is_archived' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }

    public function checklists()
    {
        return $this->hasMany(RecommendationChecklist::class);
    }
}
