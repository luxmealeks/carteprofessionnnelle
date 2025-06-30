<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'matricule',
        'prenom',
        'nom',
        'cin',
        'email',
        'telephone',
        'photo',
        'statut_photo',
        'motif_rejet_photo',
        'fonction',
        'etablissement_id',
        'direction_id',
        'inspection_academique_id',
        'corps_id',
        'grade_id',
        // 'lot_id',
        'iden',
        'ia',
    ];

 /*    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class)->withDefault([
            'nom' => 'Non affecté',
            'id' => 0
        ]);
    } */
    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class);
    }


    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }

    public function inspectionAcademique()
    {
        return $this->belongsTo(InspectionAcademique::class);
    }

    public function corps()
    {
        return $this->belongsTo(Corps::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function lot()
    {
        return $this->belongsTo(Lot::class);
    }
    public function scopePending($query)
    {
        return $query->where('statut_photo', 'en_attente');
    }
    public function lots()
    {return $this->belongsToMany(Lot::class, 'agent_lot', 'agent_id', 'lot_id')
        ->withTimestamps();
    }

}
