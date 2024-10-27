<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $fillable = ['participant_id', 'name', 'email', 'phone', 'educational_org'];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}