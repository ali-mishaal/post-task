<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Application;
class PostController extends Controller
{
    public function index(): \Inertia\Response
    {
        $posts = Post::with(['media', 'comments.user'])
            ->orderByDesc('id')
            ->get();

        return Inertia::render('Timeline', [
            'posts' => $posts
        ]);
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $post = auth()->user()
            ->posts()
            ->create($request->validated());

        if ($request->hasFile('image')) {
            $post->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->back()->with('success', 'Post created successfully.');
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        $post->update($request->validated());

        if ($request->hasFile('image')) {
            $post->clearMediaCollection('image');
            $post->addMediaFromRequest('image')
                ->toMediaCollection('image');
        }

        return redirect()->back()->with('success', 'Post created successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->back()->with('success', 'Post deleted successfully.');
    }
}
