<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ParticipantsExport;
use App\Models\Platform;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function participants()
    {
        $participants = Participant::with(['mentor', 'attributes.dictionary'])->get();
        return view('admin.participants', compact('participants'));
    }

    public function platformsIndex()
    {
        $platforms = Platform::with(['competency', 'attributes.dictionary'])
            ->withCount('participants')
            ->get();
        return view('admin.platforms.index', compact('platforms'));
    }

    public function platformShow($id)
    {
        $platform = Platform::with(['competency', 'attributes.dictionary', 'participants.attributes.dictionary', 'participants.mentor'])
            ->findOrFail($id);
        return view('admin.platforms.show', compact('platform'));
    }

    public function export()
    {
        return Excel::download(new ParticipantsExport, 'Все участники.xlsx');
    }
}