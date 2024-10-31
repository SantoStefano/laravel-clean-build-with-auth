@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="section-title">Добавление новой площадки</h1>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.platforms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group mb-3">
                    <label for="competency_id">Компетенция</label>
                    <select class="form-control" id="competency_id" name="competency_id" required>
                        @foreach($competencies as $competency)
                            <option value="{{ $competency->id }}">{{ $competency->name }}</option>
                        @endforeach
                    </select>
                </div>

                @foreach($attributes as $attribute)
                <div class="form-group mb-3">
                    <label for="attr_{{ $attribute->id }}">{{ $attribute->name }}</label>
                    @if($attribute->type === 'file')
                        <input type="file" class="form-control" id="attr_{{ $attribute->id }}" 
                               name="pattributes[{{ $attribute->id }}]" required>
                    @elseif ($attribute->type === 'date')
                        <input type="date" class="form-control" id="attr_{{ $attribute->id }}" 
                                name="pattributes[{{ $attribute->id }}]" required>
                    @else
                        <input type="text" class="form-control" id="attr_{{ $attribute->id }}" 
                               name="pattributes[{{ $attribute->id }}]" required>
                    @endif
                </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Добавить площадку</button>
            </form>
        </div>
    </div>
</div>
@endsection