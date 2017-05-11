<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';
    protected $primaryKey = 'rfc';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'rfc', 'clave_centro_seit', 'clave_area', 'curp_empleado', 'no_tarjeta', 'apellidos_empleado', 'nombre_empleado', 'horas_nombramiento', 'nombramiento', 'clases', 'ingreso_rama', 'inicio_gobierno', 'inicio_sep', 'inicio_plantel', 'domicilio_empleado', 'colonia_empleado', 'codigo_postal_empleado', 'localidad', 'telefono_empleado', 'sexo_empleado', 'estado_civil', 'fecha_nacimiento', 'lugar_nacimiento', 'institucion_egreso', 'nivel_estudios', 'grado_maximo_estudios', 'estudios', 'fecha_termino_estudios', 'fecha_titulacion', 'cedula_profesional', 'especializacion', 'idiomas_domina', 'status_empleado', 'foto', 'firma', 'correo_electronico', 'padre', 'madre', 'conyuge', 'hijos', 'num_acta', 'num_libro', 'num_foja', 'num_ano', 'num_cartilla_smn' ,'ano_clase' ,'pigmentacion' ,'pelo' ,'frente' ,'cejas' ,'ojos' ,'nariz' ,'boca' ,'estaturamts' ,'pesokg' ,'senas_visibles' ,'pais' ,'pasaporte' ,'fm' ,'inicio_vigencia' ,'termino_vigencia' ,'entrada_salida' ,'observaciones_empleado' ,'area_academica' ,'tipo_personal' ,'tipo_control' ,'rfc2' ,'nombre_user' ,'password' ,'admin' ,'id_user'
    ];
    
    protected $hidden = [];
}
