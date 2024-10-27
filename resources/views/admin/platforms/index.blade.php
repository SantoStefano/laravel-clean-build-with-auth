@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="section-title">Все площадки</h1>
    <div class="row">
        @foreach($platforms as $platform)
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $platform->competency->name }}</h5>
                    <p class="card-text">Участников: {{ $platform->participants_count }}</p>
                    <a href="{{ route('admin.platforms.show', $platform->id) }}" class="btn btn-primary">Подробнее</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection