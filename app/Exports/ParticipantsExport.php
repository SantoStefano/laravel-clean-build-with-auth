<?php

namespace App\Exports;

use App\Models\Participant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;



class ParticipantsExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        $participants = Participant::with(['mentor', 'attributes.dictionary', 'platform.competency'])->get();
        
        return $participants->map(function ($participant) {
            return [
                'ФИО участника' => $participant->name,
                'Категория' => $participant->is_student ? 'Студент' : 'Школьник',
                'Образовательная организация участника' => $participant->attributes->where('dictionary.name', 'Образовательная организация')->first()->value ?? '-',
                'Атрибуты участника' => $this->getAttributesString($participant),
                'Компетенция' => $participant->platform->competency->name ?? 'Не указано',
                'ФИО наставника' => $participant->mentor->name ?? 'Не указано',
                'Email наставника' => $participant->mentor->email ?? 'Не указано',
                'Телефон наставника' => $participant->mentor->phone ?? 'Не указано',
                'Образовательная организация наставника' => $participant->mentor->educational_org ?? 'Не указано',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ФИО участника',
            'Категория',
            'Образовательная организация участника',
            'Атрибуты участника',
            'Компетенция',
            'ФИО наставника',
            'Email наставника',
            'Телефон наставника',
            'Образовательная организация наставника',
        ];
    }

    private function getAttributesString($participant)
    {
        return $participant->attributes
            ->reject(function ($attribute) {
                return $attribute->dictionary->name === 'Образовательная организация';
            })
            ->map(function ($attribute) {
                return $attribute->dictionary->name . ': ' . $attribute->value;
            })
            ->implode("\n");
    }
}