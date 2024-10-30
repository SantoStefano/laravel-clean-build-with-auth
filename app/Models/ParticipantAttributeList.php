<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantAttributeList extends Model
{
    protected $table = 'participant_attribute_lists';
    protected $fillable = ['name', 'participant_type', 'type'];
}