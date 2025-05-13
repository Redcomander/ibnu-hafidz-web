<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'excerpt',
        'thumbnail',
        'category_id',
        'author_id',
        'status',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the category that owns the article.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the author that owns the article.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the comments for the article.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    /**
     * Get the tags for the article.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get the views for the article.
     */
    public function views()
    {
        return $this->hasMany(ArticleView::class);
    }

    /**
     * Get the total view count for the article.
     */
    public function getViewsCountAttribute()
    {
        return $this->views()->count();
    }

    /**
     * Get the unique view count for the article.
     */
    public function getUniqueViewsCountAttribute()
    {
        return $this->views()->distinct('ip_address')->count('ip_address');
    }

    /**
     * Scope a query to only include published articles.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
