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
                <div class="card-body map-container">
                    <h5 class="card-title">Интерактивная карта</h5>
                    <img src="/images/map-placeholder.jpg" class="img-fluid" alt="Карта площадок">
                    <div id="markers-container"></div>
                    <div id="info-box" class="hidden"></div>
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

<style>
    .map-container {
  position: relative;
  display: inline-block;
}

#map-image {
  max-width: 100%;
  height: auto;
}

.marker {
  position: absolute;
  width: 20px;
  height: 20px;
  background-color: red;
  border-radius: 50%;
  cursor: pointer;
  transition: box-shadow 0.3s ease;
}

.marker:hover {
  box-shadow: 0 0 15px rgba(255, 0, 0, 0.7);
}

#info-box {
  position: absolute;
  background-color: white;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 10px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  max-width: 300px;
  z-index: 1000;
}

#info-box h3 {
  margin-top: 0;
  color: #333;
}

#info-box p {
  margin: 5px 0;
  color: #666;
}

#info-box.visible {
  display: block;
}
</style>
<script>
    const markersContainer = document.getElementById('markers-container');
    const infoBox = document.getElementById('info-box');
    
    // Функция для создания маркера
    function createMarker(x, y, info) {
      const marker = document.createElement('div');
      marker.className = 'marker';
      marker.style.left = x + 'px';
      marker.style.top = y + 'px';
      marker.dataset.info = info;
    
      marker.addEventListener('click', showInfo);
    
      markersContainer.appendChild(marker);
    }
    
    // Показать информацию при клике
    function showInfo(e) {
      const info = e.target.dataset.info;
      infoBox.textContent = info;
      infoBox.style.left = (e.pageX + 10) + 'px';
      infoBox.style.top = (e.pageY + 10) + 'px';
      infoBox.classList.add('visible');
    }
    
    // Скрыть информацию при клике вне маркера
    document.addEventListener('click', (e) => {
      if (!e.target.classList.contains('marker')) {
        infoBox.classList.remove('visible');
      }
    });
    
    // Загрузка маркеров из базы данных
    @foreach($platforms as $platform)
      @if($platform->marker)
        createMarker(
          {{ $platform->marker->x }}, 
          {{ $platform->marker->y }}, 
          `
          <h3>{{ $platform->competency->name }}</h3>
          <p>Статус: {{ $platform->status ? 'Активна' : 'Неактивна' }}</p>
          @foreach($platform->attributes as $attribute)
            <p>{{ $attribute->dictionary->name }}: {{ $attribute->value }}</p>
          @endforeach
          `
        );
      @endif
    @endforeach
    </script>
@endsection