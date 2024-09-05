<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductDeleteRequest;
use App\Http\Requests\ProductShowRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use App\Traits\ApiResponse;

class ProductController extends Controller
{
    use ApiResponse;
 
    public function __construct(private ProductService $productService) {}

    public function show(ProductShowRequest $request)
    {
        try{
            return $this->success(ProductResource::make($this->productService->getBySlug($request->slug))->resolve());
        }catch (\Exception $e){
            return $this->error($e);
        }
    }

    /**
     * Summary of store
     * @param \App\Http\Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     * Требует реализации
     */
    public function store(ProductStoreRequest $request)
    {
        try{
            return $this->success([]);
        }catch (\Exception $e){
            return $this->error($e);
        }
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\ProductUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     * Требует реализации
     */
    public function update(ProductUpdateRequest $request)
    {
        try{
            return $this->success([]);
        }catch (\Exception $e){
            return $this->error($e);
        }
    }

    /**
     * Summary of delete
     * @param \App\Http\Requests\ProductDeleteRequest $request
     * @return \Illuminate\Http\JsonResponse
     * Требует реализации
     */
    public function delete(ProductDeleteRequest $request)
    {
        try{
            return $this->success([]);
        }catch (\Exception $e){
            return $this->error($e);
        }
    }
}
