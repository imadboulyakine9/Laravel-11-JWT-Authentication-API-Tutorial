<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'author_id', // Change this line
        'theme_id',
        'image_url',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id'); // Change this line
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }
}
