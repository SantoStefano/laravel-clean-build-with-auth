@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="section-title">{{ $platform->competency->name }}</h1>
    
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Атрибуты площадки</h3>
                </div>
                <div class="card-body">
                    @foreach($platform->attributes as $attribute)
                    <div class="mb-4">
                        <h6 class="text-success fw-bold">{{ $attribute->dictionary->name }}:</h6>
                        @if($attribute->dictionary->type === 'file')
                            @php
                                $file = App\Models\File::find($attribute->value);
                            @endphp
                            @if($file)
                                <a href="{{ Storage::url($file->path) }}" download class="btn btn-outline-primary btn-sm">
                                    Скачать {{ $file->name }}
                                </a>
                            @else
                                <p class="text-muted">Файл не найден</p>
                            @endif
                        @elseif ($attribute->dictionary->type === 'date')
                            <p class="lead">{{ date('d.m.Y',strtotime($attribute->value)) }}</p>
                        @elseif ($attribute->dictionary->type === 'link')
                            <a href="{{ $attribute->value }}">{{ $attribute->value }}</a>
                        @else
                            <p class="lead">{{ $attribute->value }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <x-participants-table :participants="$participants" :export-route="route('admin.platform.export', ['platformId' => $platform->id])" />
        </div>
    </div>
@endsection