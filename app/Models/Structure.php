<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    protected $table = 'structure'; // Spécifie le nom de la table
    
    protected $fillable = ['nom'];
    
    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
