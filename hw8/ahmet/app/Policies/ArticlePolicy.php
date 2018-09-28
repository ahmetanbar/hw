<?php

namespace App\Policies;

use App\User;
use App\Article;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArticlePolicy
{
    use HandlesAuthorization;


    public function EUD(User $user, Article $article)
    {
        return $user->id === $article->author_id;
    }



    public function __construct()
    {
        //
    }
}
