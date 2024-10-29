<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $fillable = ['competency_id', 'status'];

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }

    public function attributes()
    {
        return $this->hasMany(PlatformAttribute::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function marker()
    {
        return $this->hasOne(PlatformMarker::class);
    }
}