<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $news = $user->news()
            ->select('id')
            ->withSum('grades', 'quality')
            ->withSum('grades', 'relevance')
            ->get();

        $quality = $news->sum('grades_sum_quality');
        $relevance = $news->sum('grades_sum_relevance');

        $rating = round(($news->count() + $quality + $relevance) / 3, 2);

        return view('profile.show', compact('user', 'rating'));
    }
}
