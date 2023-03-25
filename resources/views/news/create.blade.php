@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <h1>Create a News Article</h1>
            <form method="POST" action="{{ route('news.store') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="category_id">Категория</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                        @foreach($categories as $id => $category)
                            <option value="{{ $id }}">{{ $category }}</option>
                        @endforeach
                    </select>
                    @error ('category_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="title">Заголовок</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                           id="title" name="title" value="{{ old('title') }}">
                    @error ('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="title">Контент</label>
                    <textarea class="form-control @error('body') is-invalid @enderror" id="body"
                              name="body" rows="5">{{ old('body') }}</textarea>
                    @error ('body')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="tags">Теги</label>
                    <select class="form-select @error('tags') is-invalid @enderror" name="tags[]" id="tags" multiple>
                        @foreach($tags as $id => $tag)
                            <option value="{{ $id }}">{{ $tag }}</option>
                        @endforeach
                    </select>
                    @error ('tags')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                @if (Auth::user()->is_admin)
                    <div class="form-group mb-4">
                        <label for="published_at">Дата публикации</label>
                        <input type="date" class="form-control @error('published_at') is-invalid @enderror"
                               id="published_at" name="published_at" value="{{ old('published_at') }}">
                        @error ('published_at')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                @endif

                <button type="submit" class="btn btn-primary">Создать</button>
            </form>
        </div>
    </div>
@endsection
