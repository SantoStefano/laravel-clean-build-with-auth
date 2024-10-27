<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetencyGroup extends Model
{
    protected $fillable = ['name'];

    public function competencies()
    {
        return $this->belongsToMany(Competency::class, 'competency_group_relations', 'group_id', 'competency_id');
    }
}