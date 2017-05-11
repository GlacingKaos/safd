<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajeAlumnoGrupo extends Model
{
    protected $table = 'mensaje_alumno_grupo';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
         'no_de_control','mensaje','fecha_hora','periodo','materia','grupo','estatus','asunto','adjunto'
    ];
}
