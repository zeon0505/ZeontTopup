<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApiCredential extends Model
{
    use HasUuids;
    protected $fillable = [
        'provider_name',
        'api_key',
        'api_secret',
        'endpoint',
        'config',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
