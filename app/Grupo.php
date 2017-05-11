<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    protected $table = 'grupos';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
         'periodo','materia','grupo','estatus_grupo','capacidad_grupo','alumnos_inscritos','folio_acta','paralelo_de','exclusivo_carrera','exclusivo_reticula','rfc','seleccionado_en_bloque'
    ];
    
     protected $hidden = [];
}
