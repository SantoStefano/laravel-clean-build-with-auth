<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Список участников</h5>
        <a href="{{ $exportRoute }}" class="btn btn-success">
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
                                @if ($attribute->dictionary->type === 'file')
                                    @php
                                    $file = App\Models\File::find($attribute->value);
                                    @endphp
                                    @if($file)
                                     <strong>{{ $attribute->dictionary->name }}:<a href="{{ Storage::url($file->path) }}" download class="btn btn-outline-primary btn-sm">
                                            Скачать {{ $file->name }}
                                        </a>  
                                    @endif
                                @else
                                <strong>{{ $attribute->dictionary->name }}:</strong> {{ $attribute->value }}<br>
                                @endif
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
            {{ $participants->links() }}
        </div>
    </div>
</div>