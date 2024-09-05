<?php

namespace App\Services;

use App\Interfaces\CatalogServiceInterface;
use App\Models\Category;
use App\Models\Filter;
use App\Models\Product;

class CatalogService implements CatalogServiceInterface {

    public function __construct(private RedisBitMapService $redisBitMapService) {}

    /**
     * Summary of parseUrlParams
     * @param array $params
     * @param mixed $filter
     * @return array
     * Предполагается, что фронт будет не на фрэймворке, чтоб дружило с СЕО и для упрощения, принимаем фронтовый uri
     * определяем ассоц массив параметров, для дальнейшей обработки
     */
    public function parseUrlParams(array $params, $filter = false)
    {
        $redisKeys = collect();
        $mainCategoriesSlugs = Category::slugs();
        foreach($params as $key => $param){
            $paramPrts = \Str::of($param)->explode(',');
            if($filter && count($paramPrts) > 1){
                $paramPrts = $paramPrts->filter(fn($part) => !$mainCategoriesSlugs->contains($part));
            }
            $paramPrts = $paramPrts->map(fn($item) => $key . '_' . $item);
            $redisKeys->push($paramPrts);
        }
        return $redisKeys->toArray();
    }

    /**
     * Summary of getAll
     * @param array $params
     * @return mixed
     * Возвращает каталог товаров + возможны фильтры
     */
    public function getAll(array $params = [], $page = 1)
    {
        $keys = $this->parseUrlParams($params);
        $productIds = $this->redisBitMapService->get($keys);
        return Product::withFilters()->whereIn('id', $productIds)->paginate((int)env('CATALOG_COUNT_PRODUCT'), ['*'], 'page', $page);
    }
  
}