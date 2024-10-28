@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-5">
        <div class="col-md-8">
            <h1 class="section-title">Добро пожаловать на Всероссийское Чемпионатное Движение по профессиональному мастерству</h1>
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
            <h2 class="section-title">Чемпионат «Профессионалы» — это:</h2>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Эксперты</h5>
                    <p class="card-text">Лучшие профессионалы оценят конкурсантов, проведут мастер-классы и помогут построить карьерный трек.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">3 этапа</h5>
                    <p class="card-text">Пройди региональный этап, межрегиональный и прими участие в финале чемпионата. Докажи, что ты лучший!</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">267 компетенций</h5>
                    <p class="card-text">Строительство, сфера услуг, информационные технологии, образование — принять участие сможет каждый профессионал.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection