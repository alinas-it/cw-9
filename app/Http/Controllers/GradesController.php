<?php

namespace App\Http\Controllers;

use App\Http\Requests\GradeRequest;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class GradesController extends Controller
{
    /**
     * @param GradeRequest $request
     * @param News $article
     * @return RedirectResponse
     */
    public function store(GradeRequest $request, News $article): RedirectResponse
    {
        $data = $request->validated();

        $grade = $article->grades()
            ->where('user_id', Auth::id())
            ->where('news_id', $article->id)
            ->firstOrNew([
                'user_id' => Auth::id(),
                'news_id' => $article->id
            ]);

        $grade->{$data['category']} = $data['grade'];
        $grade->save();

        return redirect()->back();
    }
}
