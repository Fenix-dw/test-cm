<?php

namespace App\Policies;


use App\Models\Comment;
use App\Models\User;

final class CommentPolicy
{

    public function create(User $user) : bool
    {
        return (bool) $user;
    }

    public function update(User $user, Comment $comment) : bool
    {
        return $user->id === $comment->user_id;
    }

    public function delete(User $user, Comment $comment) : bool
    {
        return $user->id === $comment->user_id;
    }
}
