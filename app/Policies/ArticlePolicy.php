<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view analytics for the article.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAnalytics(User $user, Article $article)
    {
        // Allow if user is the author of the article
        if ($article->author_id === $user->id) {
            return true;
        }

        // Allow if user is an admin (you can customize this based on your user roles)
        if ($user->isAdmin()) {
            return true;
        }

        return false;
    }
}
