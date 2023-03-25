@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="card-title"> {{ $article->title }} </h1>
                    <div class="text-muted mb-2">Опубликовано {{ $article->published_at }}</div>
                    <div class="text-muted mb-2">Создано {{ $article->created_at }}</div>
                    <div class="text-muted mb-2">Автор:
                        <a href="{{ route('profile.show', ['user' => $article->user]) }}">
                            {{ $article->user->name }}
                        </a>
                    </div>
                    <p class="card-text">
                        {{ $article->body }}
                    </p>
                    <div class="mt-4">
                        @foreach($article->tags as $tag)
                            <span class="badge bg-primary">#{{ $tag->name }}</span>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    @foreach ($grades as $grade => $label)
                        <div class="d-flex align-items-center">
                            <span>{{ $label }}: </span>
                            <div class="d-flex ms-2 me-1">
                                <form method="POST" action="{{ route('grades.store', compact('article')) }}" class="me-1">
                                    @csrf
                                    <input type="hidden" name="category" value="{{ $grade }}">
                                    <input type="hidden" name="grade" value="1">
                                    <button type="submit" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-hand-thumbs-up"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('grades.store', compact('article')) }}" class="me-1">
                                    @csrf
                                    <input type="hidden" name="category" value="{{ $grade }}">
                                    <input type="hidden" name="grade" value="-1">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-hand-thumbs-down"></i>
                                    </button>
                                </form>
                            </div>
                            @if ($gradeValue = $article->{"grades_sum_{$grade}"})
                                <span class="badge {{ $gradeValue== -1 ? 'text-bg-danger' : 'text-bg-success' }}">
                                    {{ $gradeValue }}
                                </span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            @if(!$article->published_at && Auth::user()->can('publish-news'))
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Публикация</h3>
                        <form method="POST" action="{{ route('news.publish', compact('article')) }}">
                            @csrf
                            <div class="row mb-4">
                                <label for="inputEmail3" class="col-sm-2 col-form-label">Дата</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control @error('published_at') is-invalid @enderror"
                                           id="published_at" name="published_at" value="{{ old('published_at') }}">
                                    @error ('published_at')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Опубликовать</button>
                        </form>
                    </div>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title mb-4">Комментарии</h3>
                    <ul class="list-unstyled">
                        @foreach($article->comments as $comment)
                        <li class="media mb-3">
                            <div class="media-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="mt-0 mb-1">{{ $comment->user->name }}</h5>
                                    @if(!$comment->is_approved)
                                        <form method="POST" action="{{ route('comments.publish', compact('comment')) }}" class="mb-2">
                                            @csrf
                                            <button type="submit" class="btn btn-secondary btn-sm">Опубликовать</button>
                                        </form>
                                    @endif
                                </div>
                                {{ $comment->body }}
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Оставьте комментарий</h3>
                    <form action="{{ route('comments.store', compact('article')) }}" method="post">
                        @csrf
                        <div class="form-group mb-4">
                            <label for="commentInput">Комментарий</label>
                            <textarea class="form-control" id="commentInput" rows="3" name="body"></textarea>
                        </div>
                        @error('body')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                        @enderror
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
