<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use HasFactory;
    protected $table = 'structure'; // Ajoutez cette ligne
    protected $fillable = ['nom', 'type'];
}
