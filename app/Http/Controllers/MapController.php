<?php

namespace App\Http\Controllers;

use App\Models\Platform;
use App\Models\PlatformMarker;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index()
    {
        $platforms = Platform::with('marker')->get();
        return view('admin.map', [
            'platforms' => $platforms
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'markers' => 'required|array',
            'markers.*.id' => 'required|exists:platforms,id',
            'markers.*.x' => 'required|numeric',
            'markers.*.y' => 'required|numeric',
        ]);

        foreach ($data['markers'] as $marker) {
            PlatformMarker::updateOrCreate(
                ['platform_id' => $marker['id']],
                ['x' => $marker['x'], 'y' => $marker['y']]
            );
        }

        return response()->json(['message' => 'Маркеры успешно обновлены']);
    }
}
