@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="section-title">{{ $group->name }}</h1>
    
    <div class="row g-4">
        @foreach($group->competencies as $competency)
        <div class="col-md-6">
            <a href="{{ route('competencies.show', $competency->id) }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $competency->name }}</h5>
                        <p class="card-text text-muted">
                            Нажмите, чтобы посмотреть доступные площадки
                        </p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection