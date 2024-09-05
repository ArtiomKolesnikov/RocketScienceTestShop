<?php

namespace App\Services;

use App\Interfaces\CatalogServiceInterface;
use App\Interfaces\ProductServiceInterface;
use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;

class ProductService implements ProductServiceInterface {


    public function getBySlug(string $slug): Product
    {
        return Product::withFilters()->where('slug', $slug)->first();
    }

    
    public function getById(string $id): Product
    {
        return Product::withFilters()->where('id', $id)->first();
    }


    public function store()
    {

    }

    public function update()
    {

    }
    
    public function delete()
    {

    }
    
  
}