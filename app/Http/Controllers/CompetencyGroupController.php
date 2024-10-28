<?php

namespace App\Http\Controllers;

use App\Models\CompetencyGroup;
use Illuminate\Http\Request;

class CompetencyGroupController extends Controller
{
    public function index()
    {
        $groups = CompetencyGroup::all();
        return view('competency-groups.index', [
            'groups' => $groups
        ]);
    }

    public function show($id)
    {
        $group = CompetencyGroup::with('competencies')->findOrFail($id);
        return view('competency-groups.show', [
            'group' => $group
        ]);
    }
}