<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajeAlumnoAlumno extends Model
{
    protected $table = 'mensaje_alumno_alumno';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
         'no_de_control','mensaje','fecha_hora','no_de_control_e','estatus','asunto','adjunto'
    ];
}
