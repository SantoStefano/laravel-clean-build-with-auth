@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="section-title">Выберите группу компетенций</h1>
    
    <div class="row g-4">
        @foreach($groups as $group)
        <div class="col-md-4">
            <a href="{{ route('competency-groups.show', $group->id) }}" class="text-decoration-none">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $group->name }}</h5>
                        <p class="card-text text-muted">
                            Количество компетенций: {{ $group->competencies->count() }}
                        </p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection