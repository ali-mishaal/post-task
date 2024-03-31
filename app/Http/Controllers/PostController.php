<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
class PostController extends Controller
{
    public function __construct(private readonly PostRepositoryInterface $postRepository)
    {
    }

    public function index(): \Inertia\Response
    {
        $posts = $this->postRepository->getAllPosts();

        return Inertia::render('Timeline', [
            'posts' => $posts
        ]);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $post = $this->postRepository->createPost($request->validated());

        if ($request->hasFile('image')) {
            $post->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->back()->with('success', __('Post created successfully.'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->postRepository->updatePost($post, $request->validated());

        if ($request->hasFile('image')) {
            $post->clearMediaCollection('image');
            $post->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }


        return redirect()->back()->with('success', __('Post updated successfully.'));
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->postRepository->deletePost($post);

        return redirect()->back()->with('success', __('Post deleted successfully.'));
    }
}
