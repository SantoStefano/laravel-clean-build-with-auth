@extends('layouts.app')

@section('content')
<div class="map-page-container">
    <div class="map-container">
        <canvas id="map-canvas"></canvas>
        <div id="info-box" class="hidden"></div>
    </div>
    <div class="platforms-list">
        <h2>Площадки</h2>
        <div class="platforms-grid" id="platforms-grid">
            @foreach($platforms as $platform)
                <div class="platform-item" data-id="{{ $platform->id }}" draggable="true">
                    {{ $platform->competency->name }}
                </div>
            @endforeach
        </div>
    </div>
</div>

<button id="save-markers">Сохранить расположение маркеров</button>
<a href="{{route('admin.map.delete')}}" class="btn btn-danger mt-3">Удалить все маркеры</a>
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

    #save-markers {
        display: block;
        /* margin: 20px auto; */
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

<script>
const canvas = document.getElementById('map-canvas');
const ctx = canvas.getContext('2d');
const platformsGrid = document.getElementById('platforms-grid');
const platformItems = document.querySelectorAll('.platform-item');
const saveButton = document.getElementById('save-markers');
const infoBox = document.getElementById('info-box');

const mapImage = new Image();
mapImage.src = '/images/map-placeholder.jpg';

let markers = [];
let deletedMarkers = [];
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

canvas.addEventListener('mousedown', handleMouseDown);
canvas.addEventListener('mousemove', drag);
canvas.addEventListener('mouseup', stopDragging);
canvas.addEventListener('contextmenu', handleRightClick);

function handleMouseDown(e) {
    if (e.button === 0) { 
        startDragging(e);
    }
}

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

function handleRightClick(e) {
    e.preventDefault();
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    const markerIndex = markers.findIndex(marker => 
        Math.sqrt((x - marker.x) ** 2 + (y - marker.y) ** 2) < 10
    );

    if (markerIndex !== -1) {
        const removedMarker = markers.splice(markerIndex, 1)[0];
        deletedMarkers.push(removedMarker.id);
        drawMap();
        addPlatformToList(removedMarker.id, removedMarker.info);
    }
}

function addPlatformToList(id, info) {
    const platformItem = document.createElement('div');
    platformItem.className = 'platform-item';
    platformItem.setAttribute('data-id', id);
    platformItem.setAttribute('draggable', 'true');
    platformItem.textContent = info;
    platformItem.addEventListener('dragstart', (e) => {
        e.dataTransfer.setData('text/plain', e.target.dataset.id);
    });
    platformsGrid.appendChild(platformItem);
}

function removePlatformFromList(id) {
    const platformItem = document.querySelector(`.platform-item[data-id="${id}"]`);
    if (platformItem) {
        platformItem.remove();
    }
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
    
    if (platformItem) {
        const existingMarkerIndex = markers.findIndex(marker => marker.id === id);
        if (existingMarkerIndex !== -1) {
            markers[existingMarkerIndex].x = x;
            markers[existingMarkerIndex].y = y;
        } else {
            createMarker(x, y, id, platformItem.textContent);
        }
        removePlatformFromList(id);
        drawMap();
    }
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
        body: JSON.stringify({ 
            markers: markersData,
            deletedMarkers: deletedMarkers,
        })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        deletedMarkers = [];
    })
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
            removePlatformFromList({{ $platform->id }});
        @endif
    @endforeach
}

canvas.addEventListener('click', function(e) {
    const rect = canvas.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;
    
    const clickedMarker = markers.find(marker => 
        Math.sqrt((x - marker.x) ** 2 + (y - marker.y) ** 2) < 14
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
   
    let left = marker.x 
    let top = marker.y
    
    infoBox.style.left = left + 'px';
    infoBox.style.top = top + 'px';
    infoBox.classList.remove('hidden');
    infoBox.classList.add('visible');
}

</script>

@endsection