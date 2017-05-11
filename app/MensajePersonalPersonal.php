<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajePersonalPersonal extends Model
{
    protected $table = 'mensaje_personal_personal';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
         'rfc','mensaje','fecha_hora','rfc_e','estatus','asunto','adjunto'
    ];
}
