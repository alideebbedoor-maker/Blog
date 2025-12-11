<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Blog;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class, 'blog_category');
    }
}