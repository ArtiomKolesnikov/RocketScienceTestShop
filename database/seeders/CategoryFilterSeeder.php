<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Filter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryFilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryId = Category::create([
            'title' => 'Цвет',
            'slug' => \Str::slug('Цвет'),
        ])->id;

        Filter::insert([
            [
                'title' => 'Белый',
                'slug' => \Str::slug('Белый'),
                'category_id' => $categoryId,
            ],
            
            [
                'title' => 'Чёрный',
                'slug' => \Str::slug('Чёрный'),
                'category_id' => $categoryId,
            ],
            [
                'title' => 'Зелёный',
                'slug' => \Str::slug('Зелёный'),
                'category_id' => $categoryId,
            ]
        ]);
        
        $categoryId = Category::create([
            'title' => 'Бренд',
            'slug' => \Str::slug('Бренд'),
        ])->id;

        Filter::insert([
            [
                'title' => 'Crystal lux',
                'slug' => \Str::slug('Crystal lux'),
                'category_id' => $categoryId,
            ],
            
            [
                'title' => 'Loft House',
                'slug' => \Str::slug('Loft House'),
                'category_id' => $categoryId,
            ],
            [
                'title' => 'Eurosvet',
                'slug' => \Str::slug('Eurosvet'),
                'category_id' => $categoryId,
            ]
        ]);

        $categoryId = Category::create([
            'title' => 'Тип патрона',
            'slug' => \Str::slug('Тип патрона'),
        ])->id;

        Filter::insert([
            [
                'title' => 'E27',
                'slug' => \Str::slug('E27'),
                'category_id' => $categoryId,
            ],
            
            [
                'title' => 'E32',
                'slug' => \Str::slug('E32'),
                'category_id' => $categoryId,
            ],
            [
                'title' => 'E50',
                'slug' => \Str::slug('E50'),
                'category_id' => $categoryId,
            ]
        ]);

        $categoryId = Category::create([
            'title' => 'Материал арматуры',
            'slug' => \Str::slug('Материал арматуры'),
        ])->id;

        Filter::insert([
            [
                'title' => 'Металл',
                'slug' => \Str::slug('Металл'),
                'category_id' => $categoryId,
            ],
            
            [
                'title' => 'Стекло',
                'slug' => \Str::slug('Стекло'),
                'category_id' => $categoryId,
            ],
            [
                'title' => 'Пластмасс',
                'slug' => \Str::slug('Пластмасс'),
                'category_id' => $categoryId,
            ]
        ]);
    }
}
