<?php

namespace App\Http\Controllers;

use App\Models\Competency;
use Illuminate\Http\Request;

class CompetencyController extends Controller
{
    public function show($id)
    {
        $competency = Competency::with('platforms')->findOrFail($id);
        return view('competencies.show', [
            'competency' => $competency
        ]);
    }
}