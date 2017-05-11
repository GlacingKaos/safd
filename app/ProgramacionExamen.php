<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramacionExamen extends Model
{
    protected $table = 'programacion_examen';
    protected $primaryKey = 'id_pro_exa';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'id_pro_exa', 'periodo', 'materia', 'grupo', 'rfc_p', 'fecha_ini', 'fecha_fin', 'descripcion', 'activo', 'cantidad_preguntas', 'duracion_hr', 'duracion_min', '	duracion_seg', 'unidad'
    ];
    
    protected $hidden = [];
}
