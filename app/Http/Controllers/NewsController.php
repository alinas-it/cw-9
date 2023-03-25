<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    /**
     * @param $article
     * @return Factory|View|Application
     */
    public function show($article): Factory|View|Application
    {
        $article = News::withSum('grades', 'quality')
            ->withSum('grades', 'relevance')
            ->withSum('grades', 'satisfaction')
            ->when(!Auth::user()->is_admin, fn ($query) => $query->where('published_at', '>=', now()))
            ->where('id', $article)
            ->firstOrFail();

        $grades = [
            'quality' => 'Качественно',
            'relevance' => 'Актуально',
            'satisfaction' => 'Полезно'
        ];

        return view('news.show', compact('article', 'grades'));
    }

    /**
     * @return Factory|View|Application
     */
    public function create(): Factory|View|Application
    {
       return view('news.create');
    }
}
