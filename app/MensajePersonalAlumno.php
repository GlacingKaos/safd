<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajePersonalAlumno extends Model
{
     protected $table = 'mensaje_personal_alumno';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
         'rfc','mensaje','fecha_hora','no_de_control_e','estatus','asunto','adjunto',
    ];
    
     protected $hidden = [];
}
