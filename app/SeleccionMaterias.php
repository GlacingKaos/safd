<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeleccionMaterias extends Model
{
    protected $table = 'seleccion_materias';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
         'periodo','no_de_control','materia','grupo','calificacion','tipo_evaluacion','repeticion','nopresento','status_seleccion','fecha_hora_seleccion'
    ];
}
