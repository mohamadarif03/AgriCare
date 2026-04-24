<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatSession extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'lahan_id', 'judul'];

    public function histories()
    {
        return $this->hasMany(ChatHistory::class);
    }

    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }
}
