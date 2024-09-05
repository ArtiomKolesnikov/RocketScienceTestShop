<?php

namespace App\Services;

use App\Interfaces\BitMapServiceInterface;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;

class RedisBitMapService implements BitMapServiceInterface {

    const REDIS_OPERATION_OR = 'or';
    const REDIS_OPERATION_AND = 'and';
    const REDIS_RESULT_CATALOG_NAME = 'resultCatalogName';
    const REDIS_FINAL_RESULT_CATALOG_NAME = 'finalResultCatalogName';

    private function createKey($categorySlug, $filterSlug)
    {
        $filterSlug = \Str::slug($filterSlug);
        $categorySlug = \Str::slug($categorySlug);
        return $categorySlug !== '' ? $categorySlug . '_' . $filterSlug : $filterSlug;
    }

    private function getProductIds(array $keys)
    {
        if(count($keys) === 0){
            return Product::all(['id'])->pluck(['id'])->unique()->toArray();
        }
        $allResultNames = collect();
        foreach($keys as $index => $categorySlugs){
            $nameResult = self::REDIS_RESULT_CATALOG_NAME . $index;
            Redis::bitOp(self::REDIS_OPERATION_OR, $nameResult, ...$categorySlugs);
            $allResultNames->push($nameResult);
        }
        
        Redis::bitOp(self::REDIS_OPERATION_AND, self::REDIS_FINAL_RESULT_CATALOG_NAME, ...$allResultNames->toArray());
        $hashBitMap = Redis::get(self::REDIS_FINAL_RESULT_CATALOG_NAME);
        $ids = $this->convertBitmapToIds($hashBitMap);
        return $ids;
    }

    private function convertBitmapToIds($hashBitMap, $lastPos = 0)
    {
        $result_key = $this->getBitmap($hashBitMap);
        $needle = "1";
        $positions = array();
        while (($lastPos = strpos($result_key, $needle, $lastPos))!== false){
            $positions[] = $lastPos;
            $lastPos = $lastPos + strlen($needle);
        }
        return $positions;
    }

    private function getBitmap($bitmap){
        $bytes = unpack('C*', $bitmap);
        $bin = join(array_map(function($byte){
            return sprintf("%08b", $byte);
        }, $bytes));
        return $bin;
    }

    public function set(array $filterSlugs, int $object_id, string $categorySlug = '', $value = 1)
    {
        if(array_count_values($filterSlugs) && $object_id){
            foreach($filterSlugs as $filterSlug){
                $key = $this->createKey($categorySlug, $filterSlug);
                Redis::setBit($key, $object_id, $value);
            }   
        }
    }

    public function get($keys)
    {
        return $this->getProductIds($keys);
    }
}