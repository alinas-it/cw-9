<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Grade;
use App\Models\News;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        User::factory(1)->create([
            'email' => 'admin@gmail.com',
            'is_admin' => true,
        ]);

        Category::factory(10)->create();
        $tags = Tag::factory(20)->create();

        News::factory(50)
            ->create()
            ->each(fn ($item) => $item->tags()->sync($tags->random(3)->pluck('id')));

        Comment::factory(200)->create();
        Grade::factory(200)->create();
    }
}
