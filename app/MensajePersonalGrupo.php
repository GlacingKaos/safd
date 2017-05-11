<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MensajePersonalGrupo extends Model
{
    protected $table = 'mensaje_personal_grupo';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
         'rfc','mensaje','fecha_hora','periodo','materia','grupo','estatus','asunto','adjunto'
    ];
}
