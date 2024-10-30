<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformAttributeList extends Model
{
    protected $table = 'platform_attribute_lists';
    protected $fillable = ['name','type'];
}