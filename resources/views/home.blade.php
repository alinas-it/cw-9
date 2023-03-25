@extends('layouts.app')

@section('content')
    <div class="row">
        @foreach($news as $article)
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h2 class="card-title">{{ $article->title }}</h2>
                        <p class="card-text">{{ Str::limit($article->body, 200) }}</p>
                        <div class="mt-2 mb-4">
                            @foreach($article->tags as $tag)
                            <span class="badge bg-secondary">#{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        <a href="{{ route('news.show', compact('article')) }}" class="btn btn-primary">Read More</a>
                    </div>
                    <div class="card-footer text-muted">
                        {{ $article->user->name }} опубликовал {{ $article->published_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{ $news->links() }}
@endsection
