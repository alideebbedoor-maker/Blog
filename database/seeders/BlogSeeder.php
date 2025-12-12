<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use App\Models\Category;

class BlogSeeder extends Seeder
{
    public function run()
    {
        // Blogs demo data
        $blogs = [
            [
                'title' => 'Introduction to Laravel Framework',
                'content' => 'Laravel is a powerful PHP framework used to build modern web applications...',
                'image' => 'blogs/sample1.jpg'
            ],
            [
                'title' => 'Top 10 Travel Destinations in 2025',
                'content' => 'If you love exploring new cities, here are the top places to visit in 2025...',
                'image' => 'blogs/sample2.jpg'
            ],
            [
                'title' => 'Healthy Food Recipes for Beginners',
                'content' => 'Here are some healthy food recipes you can try at home...',
                'image' => 'blogs/sample3.jpg'
            ],
            [
                'title' => 'How to Stay Motivated as a Developer',
                'content' => 'Motivation is essential for growth in software development...',
                'image' => 'blogs/sample4.jpg'
            ],
            [
                'title' => 'Best Productivity Tips for Students',
                'content' => 'Here are some effective tips to boost your productivity...',
                'image' => 'blogs/sample5.jpg'
            ],
        ];

        foreach ($blogs as $index => $data) {
            $blog = Blog::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'image' => $data['image']
            ]);

            // attach category automatically
            $categoryId = ($index % 5) + 1; // assigns categories 1 → 5
            $blog->categories()->attach($categoryId);
        }
    }
}