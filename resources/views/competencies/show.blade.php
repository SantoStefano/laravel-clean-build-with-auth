@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-5">{{ $competency->name }}</h1>
    
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(!$competency->platforms->isEmpty())
            @foreach($competency->platforms as $platform)
            @if($platform->status)
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h3 class="mb-0">Площадка:</h3>
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
                <div class="card-footer bg-light">
                    <a href="{{ route('applications.create', $platform->id) }}" class="btn btn-primary btn-lg w-100">
                        Хочу участвовать
                    </a>
                </div>
            </div>
            @endif
            @endforeach
            @else
            <h5 class="text-center">Площадки для этой компетенции пока нет</h5>
            @endif
        </div>
    </div>
</div>
@endsection