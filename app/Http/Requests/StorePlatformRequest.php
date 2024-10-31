<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\PlatformAttributeList;

class StorePlatformRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        $rules = [
            'competency_id' => 'required|exists:competencies,id',
            'pattributes' => 'required|array',
        ];

        $attributes = PlatformAttributeList::all();

        foreach ($attributes as $attribute) {
            $key = 'pattributes.' . $attribute->id;
            
            switch ($attribute->type) {
                case 'file':
                    $rules[$key] = 'required|file|max:5120';
                    break;
                case 'checkbox':
                    $rules[$key] = 'nullable|boolean';
                    break;
                case 'date':
                    $rules[$key] = 'required|date|after_or_equal:today';
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
            'competency_id.required' => 'Поле компетенции обязательно для заполнения',
            'competency_id.exists' => 'Выбранная компетенция не существует',
            'pattributes.required' => 'Атрибуты площадки обязательны для заполнения',
            'pattributes.*.file' => 'Это поле должно быть файлом',
            'pattributes.*.max' => 'Размер файла не должен превышать :max килобайт',
            'pattributes.*.date' => 'Это поле должно быть действительной датой',
            'pattributes.*.after_or_equal' => 'Дата должна быть сегодняшней или будущей',
        ];
    }
}