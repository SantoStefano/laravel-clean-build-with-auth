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
            <h2 class="mb-4">Зарегистрированные участники</h2>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th colspan="5" class="text-center bg-light">Информация об участнике</th>
                            <th colspan="4" class="text-center bg-light">Информация о наставнике</th>
                        </tr>
                        <tr>
                            <th>ФИО участника</th>
                            <th>Категория</th>
                            <th>Образовательная организация</th>
                            <th>Дополнительная информация</th>
                            <th>Компетенция</th>
                            <th>ФИО наставника</th>
                            <th>Email</th>
                            <th>Телефон</th>
                            <th>Образовательная организация</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($platform->participants as $participant)
                        <tr>
                            <td>{{ $participant->name }}</td>
                            <td>{{ $participant->is_student ? 'Студент' : 'Школьник' }}</td>
                            <td>{{ $participant->attributes->where('dictionary.name', 'Образовательная организация')->first()->value ?? '-' }}</td>
                            <td>
                                @if($participant->is_student)
                                    Специальность: {{ $participant->attributes->where('dictionary.name', 'Специальность')->first()->value ?? '-' }}<br>
                                    Программа Профессионалы: {{ $participant->attributes->where('dictionary.name', 'Обучение по программе Профессионалы')->first()->value ?? '-' }}<br>
                                    Курс: {{ $participant->attributes->where('dictionary.name', 'Курс обучения')->first()->value ?? '-' }}
                                @else
                                    Класс: {{ $participant->attributes->where('dictionary.name', 'Класс обучения')->first()->value ?? '-' }}<br>
                                    Возраст: {{ $participant->attributes->where('dictionary.name', 'Возраст')->first()->value ?? '-' }}
                                @endif
                            </td>
                            <td>{{ $platform->competency->name }}</td>
                            <td>{{ $participant->mentor->name ?? 'Не указано' }}</td>
                            <td>
                                @if($participant->mentor)
                                <a href="mailto:{{ $participant->mentor->email }}">
                                    {{ $participant->mentor->email }}
                                </a>
                                @else
                                Не указано
                                @endif
                            </td>
                            <td>
                                @if($participant->mentor)
                                <a href="tel:{{ $participant->mentor->phone }}">
                                    {{ $participant->mentor->phone }}
                                </a>
                                @else
                                Не указано
                                @endif
                            </td>
                            <td>{{ $participant->mentor->educational_org ?? 'Не указано' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection