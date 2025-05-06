<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_id',
        'google_id',
        'ip_address',
    ];

    /**
     * Get the comment that owns the like.
     */
    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
