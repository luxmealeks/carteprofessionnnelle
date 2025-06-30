<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
         'inspection_academique_id',
        'ief_id'

    ];

    public function inspectionAcademique()
{
    return $this->belongsTo(InspectionAcademique::class);
}
public function ief()
{
    return $this->belongsTo(\App\Models\Ief::class, 'ief_id');

}
/* public function ia()
{
    return $this->belongsTo(InspectionAcademique::class, 'ia_id');
    // return $this->belongsTo(\App\Models\InspectionAcademique::class, 'ia_id');


} */


}
