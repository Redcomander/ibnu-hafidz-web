<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleView extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_id',
        'user_id',
        'ip_address',
        'user_agent',
        'referrer',
    ];

    /**
     * Get the article that was viewed.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the user that viewed the article.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
