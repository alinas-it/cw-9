<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsRequest;
use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
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
            ->when(Auth::user()->cannot('publish-news'), function ($query) {
                $query->where('published_at', '>=', now())
                    ->with(['comments' => function ($query) {
                        $query->where('is_approved', true);
                    }]);
            })
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
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('name', 'id');

        return view('news.create', compact('categories', 'tags'));
    }

    /**
     * @param NewsRequest $request
     * @return Redirector|Application|RedirectResponse
     */
    public function store(NewsRequest $request): Redirector|Application|RedirectResponse
    {
        $data = $request->validated();

        $article = News::create([
            ...$request->validated(),
            ...['user_id' => Auth::id()]
        ]);

        $article->tags()->sync($data['tags']);

        return redirect(route('home'));
    }

    public function publish(Request $request, News $article): RedirectResponse
    {
        $data = $request->validate([
            'published_at' => 'required|date|after:today'
        ]);

        $article->update($data);

        return redirect()->back();
    }
}
