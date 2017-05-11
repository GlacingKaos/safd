<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajeAlumnoPersonal extends Model
{
    protected $table = 'mensaje_alumno_personal';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
         'no_de_control','mensaje','fecha_hora','rfc_e','estatus','asunto','adjunto'
    ];
}
