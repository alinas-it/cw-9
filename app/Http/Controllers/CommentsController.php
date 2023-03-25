<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function store(CommentRequest $request, News $article): RedirectResponse
    {
       $data = $request->validated();
       $article->comments()->create([
           ...$data,
           ...['user_id' => Auth::id()]
       ]);

       return redirect()->back();
    }
}
