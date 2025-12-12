<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Technology']);
        Category::create(['name' => 'Travel']);
        Category::create(['name' => 'Food']);
        Category::create(['name' => 'Education']);
        Category::create(['name' => 'Lifestyle']);
    }
}