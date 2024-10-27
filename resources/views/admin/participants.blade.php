@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Список участников</h5>
                        <a href="{{ route('admin.participants.export') }}" class="btn btn-success">
                            Скачать Excel
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="text-center bg-light">Информация об участнике</th>
                                        <th colspan="4" class="text-center bg-light">Информация о наставнике</th>
                                    </tr>
                                    <tr>
                                        <th>ФИО участника</th>
                                        <th>Категория</th>
                                        <th>Компетенция</th>
                                        <th>Атрибуты участника</th>
                                        <th>ФИО наставника</th>
                                        <th>Email</th>
                                        <th>Телефон</th>
                                        <th>Образовательная организация</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($participants as $participant)
                                    <tr>
                                        <td>{{ $participant->name }}</td>
                                        <td>{{ $participant->is_student ? 'Студент' : 'Школьник' }}</td>
                                        <td>{{ $participant->platform->competency->name ?? 'Не указано' }}</td>
                                        <td>
                                            @foreach($participant->attributes as $attribute)
                                                <strong>{{ $attribute->dictionary->name }}:</strong> {{ $attribute->value }}<br>
                                            @endforeach
                                        </td>
                                        <td>{{ $participant->mentor->name ?? 'Не указано' }}</td>
                                        <td>
                                            @if($participant->mentor)
                                                <a href="mailto:{{ $participant->mentor->email }}">{{ $participant->mentor->email }}</a>
                                            @else
                                                Не указано
                                            @endif
                                        </td>
                                        <td>
                                            @if($participant->mentor)
                                                <a href="tel:{{ $participant->mentor->phone }}">{{ $participant->mentor->phone }}</a>
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
        </div>
    </div>
@endsection