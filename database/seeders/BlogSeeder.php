<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class BlogSeeder extends Seeder
{
    public function run()
    {
        
        $blogs = [
            [
                'title' => 'Introduction to Laravel',
                'content' => 'Laravel is a PHP framework for building web applications...',
                'category_id' => 1,
                'image' => 'sample1.jpg',
            ],
        
    
            [
                'title' => 'Productivity Tips for Developers',
                'content' => 'Increase your productivity with these tips...',
                'category_id' => 1,
                'image' => 'sample1.jpg',
            ],
           
        ];

        foreach ($blogs as $data) {
            $path = Storage::disk('public')->putFile(
                'blogs',
                new File(database_path('seeders/test_images/'.$data['image']))
            );

            $blog = Blog::create([
                'title' => $data['title'],
                'content' => $data['content'],
                'image' => $path,
            ]);

            $blog->categories()->attach($data['category_id']);
        }
    }
}