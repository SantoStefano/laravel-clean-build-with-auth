@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card text-center">
        <div class="card-body">
            <h2 class="card-title text-success mb-4">Спасибо, ваша заявка успешно отправлена!</h2>
            <p class="card-text">
                Мы получили вашу заявку и свяжемся с вами в ближайшее время для подтверждения участия 
                и предоставления дополнительной информации.
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-4">Вернуться на главную</a>
        </div>
    </div>
</div>
@endsection