<?php

namespace App\Repositories\Contracts;

use App\Models\Comment;

interface CommentRepositoryInterface
{
    public function createComment($data): Comment;

    public function deleteComments($ids): void;
}
