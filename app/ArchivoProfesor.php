<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchivoProfesor extends Model
{
    protected $table = 'archivo_personal';
    protected $primaryKey = 'id_archivo_p';
    public $timestamps = false;
    
    protected $fillable = [
        'id_archivo_p', 'rfc_p', 'fecha_subida', 'materia', 'publico', 'dir', 'tipo', 'nombre', 'periodo','descripcion'
    ];
    
    protected $hidden = [];
}
