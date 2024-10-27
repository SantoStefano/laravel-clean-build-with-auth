<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = ['platform_id', 'name', 'is_student'];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function attributes()
    {
        return $this->hasMany(ParticipantAttribute::class);
    }

    public function mentor()
    {
        return $this->hasOne(Mentor::class);
    }
}
