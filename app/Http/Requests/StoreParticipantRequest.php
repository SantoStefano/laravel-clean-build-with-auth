<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ParticipantAttributeList;

class StoreParticipantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'platform_id' => 'required|exists:platforms,id',
            'participant_fio' => 'required|string|max:255',
            'is_student' => 'required|boolean',
            'mentor_fio' => 'required|string|max:255',
            'mentor_email' => 'required|email',
            'mentor_phone' => 'required|string|max:20',
            'mentor_educational_org' => 'required|string|max:255',
        ];

        $participantType = $this->input('is_student') ? 'student' : 'schoolchild';
        $attributes = ParticipantAttributeList::where('participant_type', $participantType)
            ->orWhere('participant_type', 'all')
            ->get();

        foreach ($attributes as $attribute) {
            $key = $participantType . '_attributes.' . $attribute->id;
            
            switch ($attribute->type) {
                case 'file':
                    $rules[$key] = 'required|file|max:5120'; 
                    break;
                case 'checkbox':
                    $rules[$key] = 'nullable|in:Да';
                    break;
                case 'date':
                    $rules[$key] = 'required|date';
                    break;
                default:
                    $rules[$key] = 'required|string|max:255';
            }
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'email' => 'Поле :attribute должно быть действительным email адресом',
            'max' => 'Размер файла не должен превышать :max килобайт',
            'file' => 'Поле :attribute должно быть файлом',
            'date' => 'Поле :attribute должно быть действительной датой',
        ];
    }
}