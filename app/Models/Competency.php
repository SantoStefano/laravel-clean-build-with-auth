<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Competency extends Model
{
    protected $fillable = ['name'];

    public function groups()
    {
        return $this->belongsToMany(CompetencyGroup::class, 'competency_group_relations', 'competency_id', 'group_id');
    }

    public function platforms()
    {
        return $this->hasMany(Platform::class);
    }
}