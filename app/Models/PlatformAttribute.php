<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformAttribute extends Model
{
    protected $fillable = ['platform_id', 'attribute_id', 'value'];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function dictionary()
    {
        return $this->belongsTo(PlatformAttributeList::class, 'attribute_id');
    }
}