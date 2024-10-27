@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Вход в админ-панель</h4>
                </div>
                <div class="card-body">
                    <form id="adminLoginForm" action="{{ route('admin.dashboard') }}" method="GET">
                        <div class="form-group mb-3">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection