<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filter extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeSlugs($query)
    {
        return self::all()->pluck('slug');
    }

}
