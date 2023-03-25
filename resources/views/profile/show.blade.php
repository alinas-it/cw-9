@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Личный кабинет</h1>

    <div>
        <div class="d-flex align-items-center">
            <h5 class="me-2">Имя</h5>
            <span>{{ $user->name }}</span>
        </div>
        <div class="d-flex align-items-center">
            <h5 class="me-2">Email</h5>
            <span>{{ $user->email }}</span>
        </div>
        <div class="d-flex align-items-center">
            <h5 class="me-2">Рейтинг</h5>
            <span>{{ $rating }}</span>
        </div>
    </div>
@endsection
