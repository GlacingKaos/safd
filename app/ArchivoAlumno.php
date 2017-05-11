<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchivoAlumnoController extends Model
{
    protected $table = 'archivo_alumno';
    protected $primaryKey = 'id_archivo_a';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'id_archivo_a', 'no_control_a', 'fecha_subida', 'materia', 'publico', 'dir', 'tarea', 'id_tarea_subida', 'tipo', 'nombre', 'periodo'
    ];
    
    protected $hidden = [];
}
