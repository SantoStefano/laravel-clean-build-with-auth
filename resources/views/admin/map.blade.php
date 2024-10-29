@extends('layouts.app')

@section('content')
<div class="map-page-container">
    <div class="map-container">
        <canvas id="map-canvas"></canvas>
    </div>
    <div class="platforms-list">
        <h2>Площадки</h2>
        <div class="platforms-grid">
            @foreach($platforms as $platform)
                <div class="platform-item" data-id="{{ $platform->id }}" draggable="true">
                    {{ $platform->competency->name }}
                </div>
            @endforeach
        </div>
    </div>
</div>


<button id="save-markers">Сохранить расположение маркеров</button>

<script>
const canvas = document.getElementById('map-canvas');
const ctx = canvas.getContext('2d');
const platformItems = document.querySelectorAll('.platform-item');
const saveButton = document.getElementById('save-markers');

const mapImage = new Image();
mapImage.src = '/images/map-placeholder.jpg';

let markers = [];
let isDragging = false;
let selectedMarker = null;

mapImage.onload = function() {
    canvas.width = mapImage.width;
    canvas.height = mapImage.height;
    loadMarkers();
    drawMap();
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

function createMarker(x, y, id, info) {
    markers.push({ x, y, id, info });
    drawMap();
}

canvas.addEventListener('mousedown', startDragging);
canvas.addEventListener('mousemove', drag);
canvas.addEventListener('mouseup', stopDragging);

function startDragging(e) {
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    selectedMarker = markers.find(marker => 
        Math.sqrt((x - marker.x) ** 2 + (y - marker.y) ** 2) < 10
    );

    if (selectedMarker) {
        isDragging = true;
    }
}

function drag(e) {
    if (isDragging && selectedMarker) {
        const rect = canvas.getBoundingClientRect();
        selectedMarker.x = e.clientX - rect.left;
        selectedMarker.y = e.clientY - rect.top;
        drawMap();
    }
}

function stopDragging() {
    isDragging = false;
    selectedMarker = null;
}

platformItems.forEach(item => {
    item.addEventListener('dragstart', (e) => {
        e.dataTransfer.setData('text/plain', e.target.dataset.id);
    });
});

canvas.addEventListener('dragover', (e) => e.preventDefault());
canvas.addEventListener('drop', (e) => {
    e.preventDefault();
    const id = e.dataTransfer.getData('text');
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    const platformItem = document.querySelector(`.platform-item[data-id="${id}"]`);
    
    const existingMarkerIndex = markers.findIndex(marker => marker.id === id);
    if (existingMarkerIndex !== -1) {
        markers[existingMarkerIndex].x = x;
        markers[existingMarkerIndex].y = y;
    } else {
        createMarker(x, y, id, platformItem.textContent);
    }
    drawMap();
});

saveButton.addEventListener('click', () => {
    const markersData = markers.map(marker => ({
        id: marker.id,
        x: marker.x,
        y: marker.y
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

function loadMarkers() {
    @foreach($platforms as $platform)
        @if($platform->marker)
            createMarker(
                {{ $platform->marker->x }},
                {{ $platform->marker->y }},
                {{ $platform->id }},
                '{{ $platform->competency->name }}'
            );
        @endif
    @endforeach
}

</script>

<style>
    .map-page-container {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        /* height: calc(100vh - 100px);  */
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