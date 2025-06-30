<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'inspection_academique_id'];

    // Relation vers Inspection Académique
    public function inspectionAcademique()
    {
        return $this->belongsTo(InspectionAcademique::class, 'inspection_academique_id');
    }

    // Relation many-to-many avec Agent
    public function agents()
    {
        return $this->belongsToMany(Agent::class, 'agent_lot', 'lot_id', 'agent_id')
        ->withTimestamps();
    }

}
