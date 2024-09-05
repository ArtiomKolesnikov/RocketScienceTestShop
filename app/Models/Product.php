<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends BaseModel
{
    use HasFactory;

    public function filters()
    {
        return $this->belongsToMany(Filter::class);
    }

    
    public function scopeWithFilters()
    {
        return $this->with('filters.category');
    }


}
