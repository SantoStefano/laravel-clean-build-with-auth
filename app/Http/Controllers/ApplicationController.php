<?php

namespace App\Http\Controllers;

use App\Mail\AdminApplicationNotification;
use App\Mail\MentorApplicationNotification;
use App\Models\File;
use App\Models\Participant;
use App\Models\Mentor;
use App\Models\ParticipantAttributeList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    public function create($platformId)
    {
        $attributes = ParticipantAttributeList::all();
        return view('applications.create', [
            'attributes' => $attributes,
            'platformId' => $platformId
        ]);
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

                    $attribute = ParticipantAttributeList::find($attributeId);
                    // dd($request->$attributeKey);
                    if ($attribute->type === 'file' && $request->hasFile("$attributeKey.{$attributeId}")) {
                        // dd($request->hasFile("$attributeKey.{$attributeId}"));
                        $file = $request->file("$attributeKey.{$attributeId}");
                        $path = $file->store('files', 'public');
                        
                        $fileModel = File::create([
                            'name' => $file->getClientOriginalName(),
                            'path' => $path,
                            'mime_type' => $file->getMimeType(),
                            'size' => $file->getSize(),
                        ]);
                        
                        $value = $fileModel->id;
                    }


                    $participant->attributes()->create([
                        'attribute_id' => $attributeId,
                        'value' => $value
                    ]);
                }
            }
        }

        try {
            Mail::to($mentor->email)->send(new MentorApplicationNotification($participant));
            Mail::to('admin@mail.su')->send(new AdminApplicationNotification($participant));
        } catch (\Exception $e) {
            Log::error('Ошибка при отправке email: ' . $e->getMessage());
        }

        return view('applications.success');
    }
}