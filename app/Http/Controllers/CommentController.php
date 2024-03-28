<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request): RedirectResponse
    {
        $comment = auth()->user()->comments()->create($request->validated());
        session()->flash('new_comment_id', $comment->id);

        return redirect()->back()
            ->with([
                'success'=> 'Comment created successfully.',
                'data' => $comment,
            ]);
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        Comment::whereIn('id', $request->ids)->delete();

        return redirect()->back()->with('success', 'Comment created successfully.');
    }
}
