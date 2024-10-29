<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatformMarker extends Model
{
    protected $fillable = ['platform_id', 'x', 'y'];

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }
}
