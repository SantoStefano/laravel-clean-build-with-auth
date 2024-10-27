<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantAttribute extends Model
{
    protected $fillable = ['participant_id', 'attribute_id', 'value'];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function dictionary()
    {
        return $this->belongsTo(ParticipantAttributeList::class, 'attribute_id');
    }
}