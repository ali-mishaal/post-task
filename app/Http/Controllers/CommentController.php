<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Repositories\Contracts\CommentRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(private readonly CommentRepositoryInterface $commentRepository)
    {
    }

    public function store(CommentRequest $request): RedirectResponse
    {
        $comment = $this->commentRepository->createComment($request->validated());

        return redirect()->back()
            ->with([
                'success' => __('Comment created successfully.'),
                'data' => $comment,
            ]);
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        if (auth()->id() !== $request->post_user_id)
            return redirect()->back()->withErrors([
                'error' => __('you cannot authorized for this action')
            ]);

        $this->commentRepository->deleteComments($request->ids);

        return redirect()->back()->with('success', __('Comments deleted successfully.'));
    }
}
