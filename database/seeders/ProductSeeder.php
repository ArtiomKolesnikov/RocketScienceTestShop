<?php

namespace Database\Seeders;

use App\Models\Filter;
use App\Models\Product;
use App\Services\CatalogService;
use App\Services\RedisBitMapService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Redis;

class ProductSeeder extends Seeder
{
    public function __construct(private RedisBitMapService $redisBitMapService) {}

    private function setBitmap(array $filters, int $product_id)
    {
        foreach($filters as $filter){
            $this->redisBitMapService->set([$filter['slug']], $product_id, $filter['category']['slug']);
        }
    }

    public function run(): void
    {
        Redis::flushall();
        $filters = Filter::with('category')->get();
        collect([
            [
                'title' => 'Люстра Crystal lux ISABEL SP11 GOLD-TRANSPARENT',
                'slug' => \Str::slug('Люстра Crystal lux ISABEL SP11 GOLTRANSPARENT'),
                'price' => 61900,
                'count' => 5,
                'filters' => [1,4,7,10]
            ],
            [
                'title' => 'Люстра Crystal lux HOLLYWOOD SP12-6 CHROME',
                'slug' => \Str::slug('Люстра Crystal lux HOLLYWO SP12-6 CHROME'),
                'price' => 47200,
                'count' => 7,
                'filters' => [2,5,8,11]
            ],
            
            [
                'title' => 'Люстра Loft House P-1000-10 Лофт',
                'slug' => \Str::slug('Люстра Loft House P-1000-10 Лофт'),
                'price' => 34200,
                'count' => 7,
                'filters' => [3,6,9,12]
            ],
            [
                'title' => 'Люстра Eurosvet 30026/3 chrome',
                'slug' => \Str::slug('Люстра Eurosvet 30026/3 chrome'),
                'price' => 4320,
                'count' => 11,
                'filters' => [2,4,8,10]
            ],
            [
                'title' => 'Люстра Loft House P-1000-19 Лофт',
                'slug' => \Str::slug('Люстра Loft House P-1000-19 Лофт'),
                'price' => 52650,
                'count' => 32,
                'filters' => [1,4,7,10]
            ],


            [
                'title' => 'Люстра Crystal lux HOLLYWOOD SP12-6 GOLD',
                'slug' => \Str::slug('Люстра Crystal lux HOLLYWOOD SP12-6 GOLD'),
                'price' => 85900,
                'count' => 7,
                'filters' => [2,5,8,11]
            ],
            
            [
                'title' => 'Люстра BLS 20309 Модерн',
                'slug' => \Str::slug('Люстра BLS 20309 Модерн'),
                'price' => 16700,
                'count' => 7,
                'filters' => [3,6,9,12]
            ],
            [
                'title' => 'Люстра Vitaluce V3886-9/5PL Модерн',
                'slug' => \Str::slug('Люстра Vitaluce V3886-9/5PL Модерн'),
                'price' => 2487,
                'count' => 11,
                'filters' => [2,4,8,10]
            ],

        ])->each(function($productData)use($filters){
            $product = Product::create(collect($productData)->except(['filters'])->toArray());
            $actualFilters = $filters->whereIn('id', $productData['filters']);
            $product->filters()->sync($actualFilters->pluck('id')->toArray());
            // специально для оптимизации, минимум нагрузка на БД
            $this->setBitmap($actualFilters->toArray(), $product->id);
        });
        
    }
}
