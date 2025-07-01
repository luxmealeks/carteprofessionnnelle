<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agentlot extends Model
{
      protected $table = 'agent_lot';
    protected $fillable = [
        'id',
        'agent_id',
        'lot_id',
      
    ];

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }
  
    public function agent()
    {
        return $this->belongsTo(Agent::class);
      
    }

}