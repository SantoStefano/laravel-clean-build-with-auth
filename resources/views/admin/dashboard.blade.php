@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="section-title">Панель администратора</h1>
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Быстрые действия</h5>
                    <a href="{{ route('admin.platforms.create') }}" class="btn btn-primary">
                        Добавить новую площадку
                    </a>
                    <a href="{{ route('admin.participants') }}" class="btn btn-primary">
                        Все зарегистрированные участники
                    </a>
                    <a href="{{ route('admin.platforms.index') }}" class="btn btn-primary">
                        Все площадки
                    </a>
                    <a href="{{ route('admin.map') }}" class="btn btn-primary">
                        Карта
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection