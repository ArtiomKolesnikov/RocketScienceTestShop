<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('catalog', [CatalogController::class, 'index']);
Route::resource('product', ProductController::class);
