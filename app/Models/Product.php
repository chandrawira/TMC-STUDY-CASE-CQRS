<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use UUID;

    public $timestamps = false;
    public $incrementing = false;


    public function category()
    {
        return $this->belongsTo(Category::class,'foreign_key');
    }
}
