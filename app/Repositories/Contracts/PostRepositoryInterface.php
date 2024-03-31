<?php

namespace App\Repositories\Contracts;

use App\Models\Post;
use Illuminate\Support\Collection;

interface PostRepositoryInterface
{
    public function getAllPosts(): Collection;

    public function createPost($data): Post;

    public function updatePost(Post $post, $data): Post;

    public function deletePost(Post $post): void;
}
