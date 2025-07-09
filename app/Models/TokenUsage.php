<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenUsage extends Model
{
    use HasFactory;
    protected $table = 'token_usage';
    protected $fillable = [
        'jti',
        'expires_at',
        'used_at',
    ];
    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
    ];
    public $timestamps = true;
}
