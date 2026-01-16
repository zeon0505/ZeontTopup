<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MiniGameScore extends Model
{
    protected $fillable = ['user_id', 'score', 'day'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }}
