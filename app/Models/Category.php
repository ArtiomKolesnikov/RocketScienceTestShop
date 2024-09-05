<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    public function scopeSlugs($query)
    {
        return self::all()->pluck('slug');
    }
}
