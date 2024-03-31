<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Support\Collection;

class PostRepository implements PostRepositoryInterface
{
    public function getAllPosts(): Collection
    {
        return Post::with(['media', 'comments.user'])
            ->orderByDesc('id')
            ->get();
    }

    public function createPost($data): Post
    {
        return auth()->user()
            ->posts()
            ->create($data);
    }

    public function updatePost(Post $post, $data): Post
    {
        $post->update($data);

        return $post;
    }

    public function deletePost(Post $post): void
    {
        $post->delete();
    }
}
