<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'user_id',
        'ip',
        'isp',
        'location',        
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'created_at' => "datetime:Y-m-d H:i:s",
    ];
}
