<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['description', 'properties'];

    public function causer()
    {
        return $this->morphTo();
    }
    
}
