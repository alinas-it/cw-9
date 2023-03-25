<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\Tag;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(Request $request): Renderable
    {
        $news = News::with('tags', 'user', 'category')
            ->when(
                Auth::user()->cannot('publish-news'),
                fn ($query) => $query->where('published_at', '<=', now()),
            )
            ->when($request->tag, function ($query, $tag) {
                $query->whereHas('tags', fn ($query) => $query->where('id', $tag));
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category_id', $category);
            })
            ->orderByRaw('published_at is null desc')
            ->orderByDesc('published_at')
            ->paginate();

        $categories = Category::pluck('name', 'id');

        return view('home', compact('news', 'categories'));
    }
}
