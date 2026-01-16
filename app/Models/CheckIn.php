<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class CheckIn extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'points_awarded',
        'streak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
