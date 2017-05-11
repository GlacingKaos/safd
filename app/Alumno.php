<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $table = 'alumnos';
    protected $primaryKey = 'no_de_control';
    public $incrementing = false;
    public $timestamps = false;
    
    protected $fillable = [
        'no_de_control', 'carrera', 'reticula', 'especialidad', 'nivel_escolar', 'semestre', 'clave_interna', 'estatus_alumno', 'plan_de_estudios', 'apellido_paterno', 'apellido_materno', 'nombre_alumno', 'curp_alumno', 'fecha_nacimiento', 'sexo', 'estado_civil', 'tipo_ingreso', 'periodo_ingreso_it', 'ultimo_periodo_inscrito', 'promedio_periodo_anterior', 'promedio_aritmetico_acumulado', 'creditos_aprobados', 'creditos_cursados', 'promedio_final_alcanzado', 'tipo_servicio_medico', 'clave_servicio_medico', 'escuela_procedencia', 'tipo_escuela', 'domicilio_escuela', 'entidad_procedencia', 'ciudad_procedencia', 'correo_electronico', 'foto', 'firma', 'periodos_revalidacion', 'indice_reprobacion_acumulado', 'becado_por', 'nip', 'tipo_alumno', 'nacionalidad', 'usuario', 'fecha_actualizacion', 'nombre_user', 'password', 'id_user'
    ];
    
    protected $hidden = [];
}
