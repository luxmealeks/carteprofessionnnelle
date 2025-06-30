<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agent;


class InspectionAcademique extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'code'];

    public function etablissements()
{
    return $this->hasMany(Etablissement::class);
}
public function agents()
{
    return $this->hasMany(Agent::class);
}
}

