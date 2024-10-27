@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="section-title">Подача заявки</h1>
    
    <form action="{{ route('applications.store') }}" method="POST" class="card">
        @csrf
        <input type="hidden" name="platform_id" value="{{ $platformId }}">
        
        <div class="card-body">
            <h3 class="mb-4">Информация о наставнике</h3>
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mentor_fio">ФИО наставника</label>
                        <input type="text" class="form-control" id="mentor_fio" name="mentor_fio" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mentor_email">Email</label>
                        <input type="email" class="form-control" id="mentor_email" name="mentor_email" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="mentor_phone">Телефон</label>
                        <input type="tel" class="form-control" id="mentor_phone" name="mentor_phone" required>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="mentor_educational_institution">Образовательная организация</label>
                        <input type="text" class="form-control" id="mentor_educational_org" name="mentor_educational_org" required>
                    </div>
                </div>
            </div>

            <h3 class="mb-4">Информация о конкурсанте</h3>
            <div class="form-group mb-4">
                <label for="participant_fio">ФИО конкурсанта</label>
                <input type="text" class="form-control" id="participant_fio" name="participant_fio" required>
            </div>

            <div class="form-group mb-4">
                <label>Тип конкурсанта</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_student" id="is_student_true" value="1">
                    <label class="form-check-label" for="is_student_true">Студент</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="is_student" id="is_student_false" value="0">
                    <label class="form-check-label" for="is_student_false">Школьник</label>
                </div>
            </div>
            <div id="studentFields" style="display: none;">
                @foreach($attributes as $attribute)
                    @if($attribute->type === 'student' || $attribute->type === 'all')
                    <div class="form-group mb-3">
                        <label for="student_attr_{{ $attribute->id }}">{{ $attribute->name }}</label>
                        <input type="text" class="form-control" id="student_attr_{{ $attribute->id }}" 
                               name="student_attributes[{{ $attribute->id }}]">
                    </div>
                    @endif
                @endforeach
            </div>
            
            <div id="schoolchildFields" style="display: none;">
                @foreach($attributes as $attribute)
                    @if($attribute->type === 'schoolchild' || $attribute->type === 'all')
                    <div class="form-group mb-3">
                        <label for="schoolchild_attr_{{ $attribute->id }}">{{ $attribute->name }}</label>
                        <input type="text" class="form-control" id="schoolchild_attr_{{ $attribute->id }}" 
                               name="schoolchild_attributes[{{ $attribute->id }}]">
                    </div>
                    @endif
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Отправить заявку</button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentRadio = document.getElementById('is_student_true');
    const schoolchildRadio = document.getElementById('is_student_false');
    const studentFields = document.getElementById('studentFields');
    const schoolchildFields = document.getElementById('schoolchildFields');

    function toggleFields() {
        if (studentRadio.checked) {
            studentFields.style.display = 'block';
            schoolchildFields.style.display = 'none';
        } else if (schoolchildRadio.checked) {
            studentFields.style.display = 'none';
            schoolchildFields.style.display = 'block';
        }
    }

    studentRadio.addEventListener('change', toggleFields);
    schoolchildRadio.addEventListener('change', toggleFields);
});
</script>
@endsection