<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApiKey extends Model
{
    use HasFactory;

    public $timestamps = true;
    
    public static function getApiKey($key)
    {
        return self::where([
            'key'    => $key,
            'active' => 1
        ])->first();
    }
}
