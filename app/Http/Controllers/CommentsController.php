<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    /**
     * @param CommentRequest $request
     * @param News $article
     * @return RedirectResponse
     */
    public function store(CommentRequest $request, News $article): RedirectResponse
    {
       $data = $request->validated();
       $article->comments()->create([
           ...$data,
           ...['user_id' => Auth::id()]
       ]);

       return redirect()->back();
    }

    /**
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function publish(Comment $comment): RedirectResponse
    {
        $comment->update(['is_approved' => true]);

        return redirect()->back();
    }
}
