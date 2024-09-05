<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatalogIndexRequest;
use App\Http\Resources\ProductResource;
use App\Services\CatalogService;
use App\Traits\ApiResponse;

class CatalogController extends Controller
{
    use ApiResponse;

    public function __construct(private CatalogService $catalogService) {}

    public function index(CatalogIndexRequest $request)
    {
        try{
            $products = $this->catalogService->getAll($request->except(['page']), $request->page);
            return $this->success(ProductResource::collection($products)->resolve());
        }catch (\Exception $e){
            return $this->error($e);
        }
    }
}
 