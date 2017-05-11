<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubirTareaProfesor extends Model
{
    protected $table = 'tareas_p';
    public $incrementing = false;
    protected $primaryKey = 'id_tarea';
    public $timestamps = false;
    
    protected $fillable = [
         '	id_tarea','rfc_p','fecha_limite','materia','dir','nombre','resumen','periodo','	grupo','fecha_subida','	nombre_a'
    ];
    
     protected $hidden = [];
}
