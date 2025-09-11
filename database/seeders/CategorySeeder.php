<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Technology',
                'slug' => 'technology',
                'description' => 'Posts about technology, programming, and software development.'
            ],
            [
                'name' => 'Laravel',
                'slug' => 'laravel',
                'description' => 'All things Laravel PHP framework.'
            ],
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Web development tutorials and guides.'
            ],
            [
                'name' => 'Tutorial',
                'slug' => 'tutorial',
                'description' => 'Step-by-step tutorials and how-to guides.'
            ],
            [
                'name' => 'News',
                'slug' => 'news',
                'description' => 'Latest news and updates in the tech world.'
            ]
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
