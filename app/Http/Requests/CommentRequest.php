<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'post_id' => 'required|exists:posts,id',
            'comment' => 'required|string|max:255',
        ];
    }
}
