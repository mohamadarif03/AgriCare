<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatHistory extends Model
{
    protected $fillable = ['user_id', 'lahan_id', 'pertanyaan', 'jawaban', 'chat_session_id'];

    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
