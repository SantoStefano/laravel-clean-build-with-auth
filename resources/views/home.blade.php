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
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Интерактивная карта площадок</h5>
                        <div class="map-preview-container">
                            <canvas id="map-preview-canvas"></canvas>
                        </div>
                        <button id="open-map-modal" class="btn btn-primary mt-3">Открыть карту</button>
                    </div>
                </div>
            </div>
            
            <!-- Модальное окно -->
            <div id="map-modal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div class="map-container">
                        <canvas id="map-canvas"></canvas>
                    </div>
                    <div id="info-box" class="hidden"></div>
                </div>
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
    .modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 60%; 
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.map-container {
  position: relative;
  display: inline-block;
}

#map-image {
  max-width: 100%;
  height: auto;
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

#info-box.hidden {
  display: none;
}

.map-preview-container {
    width: 100%;
    height: 350px;
    overflow: hidden;
    margin-bottom: 10px;
}

#map-preview-canvas {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
<script>
const modal = document.getElementById('map-modal');
const openModalBtn = document.getElementById('open-map-modal');
const closeModalBtn = document.querySelector('.close');
const canvas = document.getElementById('map-canvas');
const ctx = canvas.getContext('2d');
const infoBox = document.getElementById('info-box');

const mapImage = new Image();
mapImage.src = '/images/map-placeholder.jpg';

let markers = [];

mapImage.onload = function() {
    canvas.width = mapImage.width;
    canvas.height = mapImage.height;
    loadMarkers();
};

function drawMap() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.drawImage(mapImage, 0, 0, canvas.width, canvas.height);
    drawMarkers();
}

function drawMarkers() {
    markers.forEach(marker => {
        ctx.beginPath();
        ctx.arc(marker.x, marker.y, 5, 0, 2 * Math.PI);
        ctx.fillStyle = 'red';
        ctx.fill();
    });
}

function createMarker(x, y, info) {
    markers.push({ x, y, info });
    drawMap();
}

canvas.addEventListener('click', function(e) {
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    const clickedMarker = markers.find(marker => 
        Math.sqrt((x - marker.x) ** 2 + (y - marker.y) ** 2) < 10
    );

    if (clickedMarker) {
        showInfo(clickedMarker, e);
    } else {
        infoBox.classList.add('hidden');
        infoBox.classList.remove('visible');
    }
});

function showInfo(marker, e) {
    infoBox.innerHTML = marker.info;
    const rect = canvas.getBoundingClientRect();
    const modalRect = modal.getBoundingClientRect();
    
    let left = marker.x - modalRect.left;
    let top = marker.y  - modalRect.top;
    
    // Проверка, чтобы инфобокс не выходил за пределы экрана
    if (left + infoBox.offsetWidth > window.innerWidth) {
        left = window.innerWidth - infoBox.offsetWidth - 20;
    }
    if (top + infoBox.offsetHeight > window.innerHeight) {
        top = window.innerHeight - infoBox.offsetHeight - 20;
    }
    
    infoBox.style.left = left + 'px';
    infoBox.style.top = top + 'px';
    infoBox.classList.remove('hidden');
    infoBox.classList.add('visible');
}

openModalBtn.onclick = function() {
    modal.style.display = "block";
}

closeModalBtn.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}


function loadMarkers() {
    markers = []; 
    
    @foreach($platforms as $platform)
        @if($platform->marker)
            createMarker(
                {{ $platform->marker->x }}, 
                {{ $platform->marker->y }}, 
                `
                <h3>{{ $platform->competency->name }}</h3>
                <p>Статус: {{ $platform->status ? 'Активна' : 'Неактивна' }}</p>
                @foreach($platform->attributes as $attribute)
                    @if( $attribute->dictionary->type === 'file')
                        @continue;
                    @else
                    <p>{{ $attribute->dictionary->name }}: {{ $attribute->value }}</p>
                    @endif
                @endforeach
                <a href="{{ route('competencies.show', $platform->competency->id) }}" class="btn btn-primary btn-lg w-100">
                        Перейти на площадку
                    </a>
                `
            );
        @endif
    @endforeach
    
    drawMap();
    drawPreviewMap();
}

window.addEventListener('resize', function() {
    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;
    drawMap();
    drawPreviewMap();
});

const previewCanvas = document.getElementById('map-preview-canvas');
const previewCtx = previewCanvas.getContext('2d');

function drawPreviewMap() {
    previewCanvas.width = previewCanvas.offsetWidth;
    previewCanvas.height = previewCanvas.offsetHeight;
    
    const scale = Math.min(previewCanvas.width / mapImage.width, previewCanvas.height / mapImage.height);
    const scaledWidth = mapImage.width * scale;
    const scaledHeight = mapImage.height * scale;
    
    const offsetX = (previewCanvas.width - scaledWidth) / 2;
    const offsetY = (previewCanvas.height - scaledHeight) / 2;
    
    previewCtx.drawImage(mapImage, offsetX, offsetY, scaledWidth, scaledHeight);
    
    markers.forEach(marker => {
        const x = marker.x * scale + offsetX;
        const y = marker.y * scale + offsetY;
        previewCtx.beginPath();
        previewCtx.arc(x, y, 3, 0, 2 * Math.PI);
        previewCtx.fillStyle = 'red';
        previewCtx.fill();
    });

    document.addEventListener('DOMContentLoaded', function() {
        loadMarkers()
    });
}

    </script>
@endsection