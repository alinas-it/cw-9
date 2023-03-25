<?php

namespace App\Http\Controllers;

use App\Models\News;
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
    public function index(): Renderable
    {
        $news = News::with('tags', 'user')
            ->when(!Auth::user()->is_admin, fn ($query) => $query->where('published_at', '>=', now()))
            ->paginate();

        return view('home', compact('news'));
    }
}
