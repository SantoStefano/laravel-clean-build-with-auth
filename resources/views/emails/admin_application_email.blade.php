<p>Здравствуйте, администратор!</p>
<p>Новая заявка на участие была создана для участника {{ $participant->name }}.</p>
<p>Детали заявки:</p>
<ul>
    <li>Компетенция: {{ $participant->platform->competency->name }}</li>
    <li>Категория: {{ $participant->is_student ? 'Студент' : 'Школьник' }}</li>
    <li>Наставник: {{ $participant->mentor->name }}</li>
</ul>