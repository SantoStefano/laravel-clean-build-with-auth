<?php

namespace App\Http\Controllers;

use App\Models\Competency;
use App\Models\File;
use App\Models\Platform;
use App\Models\PlatformAttributeList;
use Illuminate\Http\Request;

class PlatformController extends Controller
{
    public function show($id)
    {
        $platform = Platform::with(['attributes.dictionary', 'competency'])->findOrFail($id);
        return view('platforms.show', compact('platform'));
    }

    public function create()
    {
        $attributes = PlatformAttributeList::all();
        $competencies = Competency::all();
        return view('admin.platforms.create', compact('attributes', 'competencies'));
    }

    public function store(Request $request)
{
    $platform = Platform::create([
        'competency_id' => $request->competency_id,
        'status' => true
    ]);

    foreach ($request->pattributes as $attributeId => $value) {
        $attribute = PlatformAttributeList::find($attributeId);
        
        if ($attribute->type === 'file' && $request->hasFile("pattributes.{$attributeId}")) {
            $file = $request->file("pattributes.{$attributeId}");
            $path = $file->store('files', 'public');
            
            $fileModel = File::create([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
            
            $value = $fileModel->id;
        }

        $platform->attributes()->create([
            'attribute_id' => $attributeId,
            'value' => $value
        ]);
    }

    return redirect()->back()->with('success', 'Площадка успешно создана');
}
}