<?php

namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Contracts\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function createComment($data): Comment
    {
        return auth()->user()->comments()->create($data);
    }

    public function deleteComments($ids): void
    {
        Comment::whereIn('id', $ids)->delete();
    }
}
