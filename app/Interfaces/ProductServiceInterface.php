<?php

namespace App\Interfaces;

interface ProductServiceInterface {

    public function getBySlug(string $slug);
    
    public function store();

    public function update();
    
    public function delete();
}