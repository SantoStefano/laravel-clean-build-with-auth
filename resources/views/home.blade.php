@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-md-8">
            <h1 class="section-title">Добро пожаловать в Чемпионатное движение</h1>
            <p class="lead">
                Чемпионатное движение представляет собой соревновательные мероприятия, направленные на демонстрацию 
                компетенций конкурсантами и работу по формированию прототипов «продуктов» в определенной экономической области.
            </p>
            <a href="{{ route('competency-groups.index') }}" class="btn btn-primary btn-lg mt-3">
                Подать заявку
            </a>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Интерактивная карта</h5>
                    <img src="/images/map-placeholder.jpg" class="img-fluid" alt="Карта площадок">
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <h2 class="section-title">Преимущества участия</h2>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Профессиональный рост</h5>
                    <p class="card-text">Возможность продемонстрировать свои навыки и получить оценку экспертов.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Networking</h5>
                    <p class="card-text">Знакомство с профессионалами отрасли и потенциальными работодателями.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Опыт</h5>
                    <p class="card-text">Бесценный соревновательный опыт и работа с современным оборудованием.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection