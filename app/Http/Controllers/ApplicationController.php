<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Mentor;
use App\Models\ParticipantAttributeList;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function create($platformId)
    {
        $attributes = ParticipantAttributeList::all();
        return view('applications.create', compact('attributes', 'platformId'));
    }

    public function store(Request $request)
    {
        // Создаем участника
        $participant = Participant::create([
            'platform_id' => $request->platform_id,
            'name' => $request->participant_fio,
            'is_student' => $request->is_student
        ]);

        // Создаем наставника
        $mentor = Mentor::create([
            'participant_id' => $participant->id,
            'name' => $request->mentor_fio,
            'email' => $request->mentor_email,
            'phone' => $request->mentor_phone,
            'educational_org' => $request->mentor_educational_org,
        ]);

        // Сохраняем атрибуты участника
        $attributeKey = $request->is_student ? 'student_attributes' : 'schoolchild_attributes';
        if ($request->has($attributeKey)) {
            foreach ($request->$attributeKey as $attributeId => $value) {
                if (!empty($value)) { 
                    $participant->attributes()->create([
                        'attribute_id' => $attributeId,
                        'value' => $value
                    ]);
                }
            }
        }

        return view('applications.success');
    }
}