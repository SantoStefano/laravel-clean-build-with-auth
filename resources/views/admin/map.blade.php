@extends('layouts.app')

@section('content')
<div class="map-page-container">
    <div class="map-container">
        <img src="/images/map-placeholder.jpg" alt="Карта Иркутской области" id="map-image"/>
        <div id="markers-container"></div>
    </div>
    <div class="platforms-list">
        <h2>Площадки</h2>
        <div class="platforms-grid">
            @foreach($platforms as $platform)
                <div class="platform-item" draggable="true" data-id="{{ $platform->id }}">
                    {{ $platform->competency->name }}
                </div>
            @endforeach
        </div>
    </div>
</div>

<button id="save-markers">Сохранить расположение маркеров</button>

<script>
const mapImage = document.getElementById('map-image');
const markersContainer = document.getElementById('markers-container');

let isDragging = false;
let selectedMarker = null;
let offsetX, offsetY;

function createMarker(x, y, info, id) {
  const marker = document.createElement('div');
  marker.className = 'marker';
  marker.style.left = x + 'px';
  marker.style.top = y + 'px';
  marker.dataset.info = info;
  marker.dataset.id = id;

  marker.addEventListener('mousedown', startDragging);

  markersContainer.appendChild(marker);
}

// Начало перетаскивания
function startDragging(e) {
  isDragging = true;
  selectedMarker = e.target;
  offsetX = e.clientX - selectedMarker.offsetLeft;
  offsetY = e.clientY - selectedMarker.offsetTop;
  e.preventDefault();
}

// Перетаскивание
document.addEventListener('mousemove', (e) => {
  if (isDragging && selectedMarker) {
    const x = e.clientX - offsetX;
    const y = e.clientY - offsetY;
    selectedMarker.style.left = x + 'px';
    selectedMarker.style.top = y + 'px';
  }
});

// Конец перетаскивания
document.addEventListener('mouseup', () => {
  isDragging = false;
  selectedMarker = null;
});

// Добавьте код для перетаскивания элементов из списка на карту
const platformItems = document.querySelectorAll('.platform-item');
platformItems.forEach(item => {
  item.addEventListener('dragstart', (e) => {
    e.dataTransfer.setData('text/plain', e.target.dataset.id);
  });
});

mapImage.addEventListener('dragover', (e) => e.preventDefault());
mapImage.addEventListener('drop', (e) => {
  e.preventDefault();
  const id = e.dataTransfer.getData('text');
  const rect = mapImage.getBoundingClientRect();
  const x = e.clientX - rect.left;
  const y = e.clientY - rect.top;
  const platformItem = document.querySelector(`.platform-item[data-id="${id}"]`);
  
  // Проверяем, существует ли уже маркер для этой платформы
  const existingMarker = document.querySelector(`.marker[data-id="${id}"]`);
  if (existingMarker) {
    existingMarker.style.left = x + 'px';
    existingMarker.style.top = y + 'px';
  } else {
    createMarker(x, y, platformItem.textContent, id);
  }
});

// Добавьте код для сохранения маркеров
document.getElementById('save-markers').addEventListener('click', () => {
  const markers = document.querySelectorAll('.marker');
  const markersData = Array.from(markers).map(marker => ({
    id: marker.dataset.id,
    x: parseFloat(marker.style.left),
    y: parseFloat(marker.style.top)
  }));

  fetch('{{ route("admin.map.update") }}', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({ markers: markersData })
  })
  .then(response => response.json())
  .then(data => alert(data.message))
  .catch(error => console.error('Error:', error));
});

// Инициализация маркеров для платформ, у которых уже есть сохраненные координаты
@foreach($platforms as $platform)
  @if($platform->marker)
    createMarker({{ $platform->marker->x }}, {{ $platform->marker->y }}, '{{ $platform->competency->name }}', {{ $platform->id }});
  @endif
@endforeach
</script>

<style>
    .map-page-container {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        height: calc(100vh - 100px); 
    }
    
    .platforms-list {
        flex: 0 0 300px;
        overflow-y: auto;
        padding-right: 10px;
    }
    
    .platforms-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    
    .platform-item {
        cursor: move;
        padding: 10px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 3px;
        text-align: center;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
    
    .map-container {
        flex: 1;
        position: relative;
        height: 100%;
        overflow: hidden;
    }
    
    #map-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }
    
    #markers-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }
    
    .marker {
        position: absolute;
        width: 20px;
        height: 20px;
        background-color: red;
        border-radius: 50%;
        cursor: pointer;
        transition: box-shadow 0.3s ease;
        pointer-events: auto;
    }
    
    .marker:hover {
        box-shadow: 0 0 15px rgba(255, 0, 0, 0.7);
    }
    
    #save-markers {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
    
    #save-markers:hover {
        background-color: #45a049;
    }
    
    
    .platforms-list::-webkit-scrollbar {
        width: 8px;
    }
    
    .platforms-list::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    
    .platforms-list::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }
    
    .platforms-list::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
    </style>
</style>
@endsection