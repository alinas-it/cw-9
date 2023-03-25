@extends('layouts.app')

@section('content')
    @auth
        <a href="{{ route('news.create') }}" class="btn btn-secondary mb-4">Создать новость</a>
    @endauth

    <div class="row align-items-start">
        <div class="col-md-8">
            @foreach($news as $article)
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">{{ $article->title }}</h2>
                        <span><i>{{ $article->category->name }}</i></span>
                        <p class="card-text">{{ Str::limit($article->body, 200) }}</p>
                        <div class="mt-2 mb-4">
                            @foreach($article->tags as $tag)
                                <a href="{{ route('home', ['tag' => $tag->id]) }}" class="badge bg-secondary">#{{ $tag->name }}</a>
                            @endforeach
                        </div>
                        <a href="{{ route('news.show', compact('article')) }}" class="btn btn-primary">Read More</a>
                    </div>
                    <div class="card-footer text-muted d-flex">
                        @if($article->published_at)
                            {{ $article->user->name }} опубликовал {{ $article->published_at->diffForHumans() }}
                        @else
                            Новость не опубликована
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-4">
            <h2 class="mb-2">Категории</h2>
            <ul>
                @foreach($categories as $id => $category)
                    <li><a href="{{ route('home', ['category' => $id]) }}">{{ $category }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    {{ $news->links() }}
@endsection
