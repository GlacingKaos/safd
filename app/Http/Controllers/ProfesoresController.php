<?php

namespace App\Http\Controllers;
use App\PersonalInf;
use App\Personal;
use App\Alumno;
use App\Grupo;
use App\ArchivoProfesor;
use App\PeriodosEscolares;
use App\MensajePersonalAlumno;
use App\MensajePersonalPersonal;
use App\MensajePersonalGrupo;
use App\MensajeAlumnoGrupo;
use App\MensajeAlumnoPersonal;
use App\ProgramacionExamen;
use App\SubirTareaProfesor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfesoresController extends Controller
{
    public function index(){
        $datos =PersonalInf::find(Personal::where('id_user',\Auth::user()->id)->first()->rfc);
        return view('safd.profesor.index')->with('datos',$datos);
    }
    public function enviarDocumento(){
        $docsPublico = DB::table('archivo_personal')->where('publico', '=', 0)->get();
        $docsPrivado = DB::table('archivo_personal')->where('publico', '=', 1)->get();
        $tareasSubidas = SubirTareaProfesor::orderBy('id_tarea','ASC')->get();
        $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
        $temp=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
        $grupos = DB::table('grupos')
            ->select('materia')
            ->where('periodo','=',$temp)
            ->where('rfc','=',$rfc)
            ->distinct()
            ->get();
        return view('safd.profesor.documentos.documentos')->with('temp',$docsPublico)->with('temp2',$docsPrivado)->with('grupos',$grupos)->with('temp3',$tareasSubidas);
    }
    public function indexMensajes(){
        $rfc =Personal::where('id_user',\Auth::user()->id)->first()->rfc;
        $per=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
        $materias=Grupo::where('rfc','=',$rfc)->where('periodo','=',$per)->where('estatus_grupo','=',NULL)->get();
        return view('safd.profesor.mensajes.IndexMensajes')->with('materias',$materias);
    }
    
    public function guardarInformacionP(Request $Request){
        if($Request->file('file')){
            $rfc =Personal::where('id_user',\Auth::user()->id)->first()->rfc;
            $temp = PersonalInf::find($rfc);
            $file = $Request->file('file');
            $name = 'safd_'. time() . '.' .$file->getClientOriginalExtension();
            $path = public_path() . '/imagenes/';
            $file->move($path,$name);
            $temp->foto =$name;
            $temp->nombre =  $Request->nombre;
            $temp->correo = $Request->correo;
            $temp->telefono = $Request->telefono;
            $temp->curriculum = $Request->curriculum;
            $temp->dir=$path;
            $temp->save();
        }
        else{
            $rfc =Personal::where('id_user',\Auth::user()->id)->first()->rfc;
            $temp = PersonalInf::find($rfc);
            $temp->nombre =  $Request->nombre;
            $temp->correo = $Request->correo;
            $temp->telefono = $Request->telefono;
            $temp->curriculum = $Request->curriculum;
            $temp->save();
        }
        return redirect()->route('safd.profesor.index');
    }
    
    public function subirDocumentoProfesor(Request $Request){
       // dd($Request->all());
        if($Request->selectTipo=='1'){//PUBLICO
             $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
             $temp = new ArchivoProfesor();
             $temp->id_archivo_p = NULL;
             $temp->rfc_p = $rfc;
             $ldate = date('Y-m-d H:i:s');
             $temp->fecha_subida = $ldate;
             $temp->materia = "";
             $temp->publico = 0;
             $file = $Request->file('file');
             $name = 'safd_'. time() . '.' .$file->getClientOriginalExtension();
             $path = public_path() . '/documentos/';
             $file->move($path,$name);
             $temp->dir = $path;
             $temp->tipo = "";
             $temp->nombre = $name;
             $temp->periodo = "2017";
             $temp->descripcion = $Request->curriculum;
             $temp->save();
            return redirect()->route('safd.profesor.documentos.documentos');
        }elseif($Request->selectTipo=='2'){//PRIVADO
            $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
             $temp = new ArchivoProfesor();
             $temp->id_archivo_p = NULL;
             $temp->rfc_p = $rfc;
             $ldate = date('Y-m-d H:i:s');
             $temp->fecha_subida = $ldate;
             $temp->materia = "";
             $temp->publico = 1;
             $file = $Request->file('file');
             $name = 'safd_'. time() . '.' .$file->getClientOriginalExtension();
             $path = public_path() . '/documentos/';
             $file->move($path,$name);
             $temp->dir = $path;
             $temp->tipo = "";
             $temp->nombre = $name;
             $temp->periodo = "2017";
             $temp->descripcion = $Request->curriculum;
             $temp->save();
            return redirect()->route('safd.profesor.documentos.documentos');
        }elseif ($Request->selectTipo=='3') {
            $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
            $periodo=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
            $materia = $Request->selectMateria;
            $grupos = DB::table('grupos')
                ->select('grupo')
                ->where('periodo','=',$periodo)
                ->where('materia','=',$materia)
                ->where('rfc','=',$rfc)
                ->distinct()
                ->first();
             $temp = new SubirTareaProfesor();
             
                 $newId=1;
            $archivo = DB::table('tareas_p')
                ->select('id_tarea')
                ->orderBy('id_tarea','DESC')
                ->first();
            if($archivo){
                $newId=((int)$archivo->id_tarea)+1;
            }
             
             $temp->id_tarea = $newId;
             $temp->rfc_p = $rfc;
             $lhora = date('H:i:s');
            // $temp -> fecha_limite = $Request->fechaLimite .'.'.'02:23:50';
            $temp->fecha_limite = "2012-04-26" .'.'. $lhora;
             $temp-> materia = $Request->selectMateria;
             $file = $Request->file('file');
             $name = 'safd_'. time() . '.' .$file->getClientOriginalExtension();
             $path = public_path() . '/documentos/';
             $file->move($path,$name);
             $temp->dir = $path;
             $temp->nombre = $Request->nombreMateria;
             $temp->resumen = $Request->curriculum;
              $temp->periodo = $periodo;
             $temp->grupo = $grupos->grupo;
             $ldate = date('Y-m-d H:i:s');
             $temp->fecha_subida = $ldate;
             $temp->nombre_a = $name;
             $temp->save();
            return redirect()->route('safd.profesor.documentos.documentos');
        
        }
    }
    
    
    public function catalogoPreguntasCreate(Request $request){
        $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
        $unidad = $request->unidad;
        $materia = $request->materia;
        $pregunta = $request->pregunta;
        $grupo = DB::table('catalogo_preguntas')
            ->select('id_pregunta')
            ->where('unidad',$unidad)
            ->where('materia',$materia)
            ->where('rfc_p',$rfc)
            ->orderBy('id_pregunta','DESC')
            ->first();
        if($grupo!=null || $grupo!=""){
            $idNew = ((int)$grupo->id_pregunta)+1;
        }else{
            $idNew = 1;
        }
        $preguntaAdd = DB::table('catalogo_preguntas')->insert(
            ['id_pregunta' => $idNew, 'materia' => $materia, 'rfc_p' => $rfc, 'pregunta' => $pregunta, 'imagen' => null, 'descripcion' => null, 'unidad' => $unidad]
        );
        if($preguntaAdd){
            $idPregunta = DB::table('catalogo_preguntas')
            ->select('no_reg_preg')
            ->where('id_pregunta',$idNew)
            ->where('unidad',$unidad)
            ->where('materia',$materia)
            ->where('rfc_p',$rfc)
            ->first()->no_reg_preg;
            
            if($request->res1 !="" && $request->num1 != ""){
                $res = DB::table('respuestas_preguntas')
                    ->select('id_res_pre')
                    ->where('cat_unidad',$unidad)
                    ->where('cat_materia',$materia)
                    ->where('cat_rfc',$rfc)
                    ->where('cat_pregunta',$idNew)
                    ->orderBy('id_res_pre','DESC')
                    ->first();
                if($res!=null || $res!=""){
                    $idNew2 = ((int)$res->id_res_pre)+1;
                }else{
                    $idNew2 = 0;
                }
                $preguntaAdd = DB::table('respuestas_preguntas')->insert(
                    ['id_res_pre' => $idNew2,'cat_pregunta' => $idNew, 'cat_materia' => $materia, 'cat_rfc' => $rfc, 'valor' => $request->num1, 'respuesta' => $request->res1, 'cat_unidad' => $unidad]
                );
            }
            if($request->res2 && $request->num2){
                $res = DB::table('respuestas_preguntas')
                    ->select('id_res_pre')
                    ->where('cat_unidad',$unidad)
                    ->where('cat_materia',$materia)
                    ->where('cat_rfc',$rfc)
                    ->where('cat_pregunta',$idNew)
                    ->orderBy('id_res_pre','DESC')
                    ->first();
                if($res!=null || $res!=""){
                    $idNew2 = ((int)$res->id_res_pre)+1;
                }else{
                    $idNew2 = 0;
                }
                $preguntaAdd = DB::table('respuestas_preguntas')->insert(
                    ['id_res_pre' => $idNew2,'cat_pregunta' => $idNew, 'cat_materia' => $materia, 'cat_rfc' => $rfc, 'valor' => $request->num2, 'respuesta' => $request->res2, 'cat_unidad' => $unidad]
                );
            }
            if($request->res3 !="" && $request->num3 != ""){
                $res = DB::table('respuestas_preguntas')
                    ->select('id_res_pre')
                    ->where('cat_unidad',$unidad)
                    ->where('cat_materia',$materia)
                    ->where('cat_rfc',$rfc)
                    ->where('cat_pregunta',$idNew)
                    ->orderBy('id_res_pre','DESC')
                    ->first();
                if($res!=null || $res!=""){
                    $idNew2 = ((int)$res->id_res_pre)+1;
                }else{
                    $idNew2 = 0;
                }
                $preguntaAdd = DB::table('respuestas_preguntas')->insert(
                    ['id_res_pre' => $idNew2,'cat_pregunta' => $idNew, 'cat_materia' => $materia, 'cat_rfc' => $rfc, 'valor' => $request->num3, 'respuesta' => $request->res3, 'cat_unidad' => $unidad]
                );
            }
            if($request->res4 !="" && $request->num4 != ""){
                $res = DB::table('respuestas_preguntas')
                    ->select('id_res_pre')
                    ->where('cat_unidad',$unidad)
                    ->where('cat_materia',$materia)
                    ->where('cat_rfc',$rfc)
                    ->where('cat_pregunta',$idNew)
                    ->orderBy('id_res_pre','DESC')
                    ->first();
                if($res!=null || $res!=""){
                    $idNew2 = ((int)$res->id_res_pre)+1;
                }else{
                    $idNew2 = 0;
                }
                $preguntaAdd = DB::table('respuestas_preguntas')->insert(
                    ['id_res_pre' => $idNew2,'cat_pregunta' => $idNew, 'cat_materia' => $materia, 'cat_rfc' => $rfc, 'valor' => $request->num4, 'respuesta' => $request->res4, 'cat_unidad' => $unidad]
                );
            }
            if($request->res5 !="" && $request->num5 != ""){
                $res = DB::table('respuestas_preguntas')
                    ->select('id_res_pre')
                    ->where('cat_unidad',$unidad)
                    ->where('cat_materia',$materia)
                    ->where('cat_rfc',$rfc)
                    ->where('cat_pregunta',$idNew)
                    ->orderBy('id_res_pre','DESC')
                    ->first();
                if($res!=null || $res!=""){
                    $idNew2 = ((int)$res->id_res_pre)+1;
                }else{
                    $idNew2 = 0;
                }
                $preguntaAdd = DB::table('respuestas_preguntas')->insert(
                    ['id_res_pre' => $idNew2,'cat_pregunta' => $idNew, 'cat_materia' => $materia, 'cat_rfc' => $rfc, 'valor' => $request->num5, 'respuesta' => $request->res5, 'cat_unidad' => $unidad]
                );
            }
        }
        return redirect()->route('safd.profesor.catalogo.preguntas');
    }
    
    public function catalogoPreguntasUpdate(Request $request){
        $idPregunta = $request->idPregunta;
        $rfc = $request->rfc;
        $materiaV = $request->materiaV;
        $unidadV = $request->unidadV;
        $materia = $request->materia;
        $unidad = $request->unidad;
        $pregunta = $request->pregunta;
        $pre1 = $request->pre1;
        $res1 = $request->res1;
        $num1 = $request->num1;
        $pre2 = $request->pre2;
        $res2 = $request->res2;
        $num2 = $request->num2;
        $pre3 = $request->pre3;
        $res3 = $request->res3;
        $num3 = $request->num3;
        $pre4 = $request->pre4;
        $res4 = $request->res4;
        $num4 = $request->num4;
        $pre5 = $request->pre5;
        $res5 = $request->res5;
        $num5 = $request->num5;
        $grupo = DB::table('catalogo_preguntas')
            ->where('id_pregunta',$idPregunta)
            ->where('unidad',$unidadV)
            ->where('materia',$materiaV)
            ->where('rfc_p',$rfc)
            ->update(['unidad' => $unidad, 'materia' => $materia, 'pregunta' => $pregunta]);
        
        if($res1 && $num1 && $pre1){
            $res = DB::table('respuestas_preguntas')
            ->where('id_res_pre',$pre1)
            ->where('cat_pregunta',$idPregunta)
            ->where('cat_materia',$materiaV)
            ->where('cat_unidad',$unidadV)
            ->where('cat_rfc',$rfc)
            ->update(['cat_materia' => $materia, 'cat_unidad' => $unidad, 'respuesta' => $res1, 'valor' => $num1]);
        }elseif($res1 && $num1 && !$pre1){
            $res = DB::table('respuestas_preguntas')
                ->select('id_res_pre')
                ->where('cat_unidad',$unidad)
                ->where('cat_materia',$materia)
                ->where('cat_rfc',$rfc)
                ->where('cat_pregunta',$idPregunta)
                ->orderBy('id_res_pre','DESC')
                ->first();
            if($res!=null || $res!=""){
                $idNew2 = ((int)$res->id_res_pre)+1;
            }else{
                $idNew2 = 0;
            }
            $preguntaAdd = DB::table('respuestas_preguntas')->insert(
                ['id_res_pre' => $idNew2,'cat_pregunta' => $idPregunta, 'cat_materia' => $materia, 'cat_rfc' => $rfc, 'valor' => $num1, 'respuesta' => $res1, 'cat_unidad' => $unidad]
            );
        }elseif(!($res1 && $num1) && $pre1){
            $res = DB::table('respuestas_preguntas')
            ->where('id_res_pre',$pre1)
            ->where('cat_pregunta',$idPregunta)
            ->where('cat_materia',$materiaV)
            ->where('cat_unidad',$unidadV)
            ->where('cat_rfc',$rfc)
            ->delete();
        }
        
        if($res2 && $num2 && $pre2){
            $res = DB::table('respuestas_preguntas')
            ->where('id_res_pre',$pre2)
            ->where('cat_pregunta',$idPregunta)
            ->where('cat_materia',$materiaV)
            ->where('cat_unidad',$unidadV)
            ->where('cat_rfc',$rfc)
            ->update(['cat_materia' => $materia, 'cat_unidad' => $unidad, 'respuesta' => $res2, 'valor' => $num2]);
        }elseif($res2 && $num2 && !$pre2){
            $res = DB::table('respuestas_preguntas')
                ->select('id_res_pre')
                ->where('cat_unidad',$unidad)
                ->where('cat_materia',$materia)
                ->where('cat_rfc',$rfc)
                ->where('cat_pregunta',$idPregunta)
                ->orderBy('id_res_pre','DESC')
                ->first();
            if($res!=null || $res!=""){
                $idNew2 = ((int)$res->id_res_pre)+1;
            }else{
                $idNew2 = 0;
            }
            $preguntaAdd = DB::table('respuestas_preguntas')->insert(
                ['id_res_pre' => $idNew2,'cat_pregunta' => $idPregunta, 'cat_materia' => $materia, 'cat_rfc' => $rfc, 'valor' => $num2, 'respuesta' => $res2, 'cat_unidad' => $unidad]
            );
        }elseif(!($res2 && $num2) && $pre2){
            $res = DB::table('respuestas_preguntas')
            ->where('id_res_pre',$pre2)
            ->where('cat_pregunta',$idPregunta)
            ->where('cat_materia',$materiaV)
            ->where('cat_unidad',$unidadV)
            ->where('cat_rfc',$rfc)
            ->delete();
        }
        
        if($res3 && $num3 && $pre3){
            $res = DB::table('respuestas_preguntas')
            ->where('id_res_pre',$pre3)
            ->where('cat_pregunta',$idPregunta)
            ->where('cat_materia',$materiaV)
            ->where('cat_unidad',$unidadV)
            ->where('cat_rfc',$rfc)
            ->update(['cat_materia' => $materia, 'cat_unidad' => $unidad, 'respuesta' => $res3, 'valor' => $num3]);
        }elseif($res3 && $num3 && !$pre3){
            $res = DB::table('respuestas_preguntas')
                ->select('id_res_pre')
                ->where('cat_unidad',$unidad)
                ->where('cat_materia',$materia)
                ->where('cat_rfc',$rfc)
                ->where('cat_pregunta',$idPregunta)
                ->orderBy('id_res_pre','DESC')
                ->first();
            if($res!=null || $res!=""){
                $idNew2 = ((int)$res->id_res_pre)+1;
            }else{
                $idNew2 = 0;
            }
            $preguntaAdd = DB::table('respuestas_preguntas')->insert(
                ['id_res_pre' => $idNew2,'cat_pregunta' => $idPregunta, 'cat_materia' => $materia, 'cat_rfc' => $rfc, 'valor' => $num3, 'respuesta' => $res3, 'cat_unidad' => $unidad]
            );
        }elseif(!($res3 && $num3) && $pre3){
            $res = DB::table('respuestas_preguntas')
            ->where('id_res_pre',$pre3)
            ->where('cat_pregunta',$idPregunta)
            ->where('cat_materia',$materiaV)
            ->where('cat_unidad',$unidadV)
            ->where('cat_rfc',$rfc)
            ->delete();
        }
        
        if($res4 && $num4 && $pre4){
            $res = DB::table('respuestas_preguntas')
            ->where('id_res_pre',$pre4)
            ->where('cat_pregunta',$idPregunta)
            ->where('cat_materia',$materiaV)
            ->where('cat_unidad',$unidadV)
            ->where('cat_rfc',$rfc)
            ->update(['cat_materia' => $materia, 'cat_unidad' => $unidad, 'respuesta' => $res4, 'valor' => $num4]);
        }elseif($res4 && $num4 && !$pre4){
            $res = DB::table('respuestas_preguntas')
                ->select('id_res_pre')
                ->where('cat_unidad',$unidad)
                ->where('cat_materia',$materia)
                ->where('cat_rfc',$rfc)
                ->where('cat_pregunta',$idPregunta)
                ->orderBy('id_res_pre','DESC')
                ->first();
            if($res!=null || $res!=""){
                $idNew2 = ((int)$res->id_res_pre)+1;
            }else{
                $idNew2 = 0;
            }
            $preguntaAdd = DB::table('respuestas_preguntas')->insert(
                ['id_res_pre' => $idNew2,'cat_pregunta' => $idPregunta, 'cat_materia' => $materia, 'cat_rfc' => $rfc, 'valor' => $num4, 'respuesta' => $res4, 'cat_unidad' => $unidad]
            );
        }elseif(!($res4 && $num4) && $pre4){
            $res = DB::table('respuestas_preguntas')
            ->where('id_res_pre',$pre4)
            ->where('cat_pregunta',$idPregunta)
            ->where('cat_materia',$materiaV)
            ->where('cat_unidad',$unidadV)
            ->where('cat_rfc',$rfc)
            ->delete();
        }
        
        if($res5 && $num5 && $pre5){
            $res = DB::table('respuestas_preguntas')
            ->where('id_res_pre',$pre5)
            ->where('cat_pregunta',$idPregunta)
            ->where('cat_materia',$materiaV)
            ->where('cat_unidad',$unidadV)
            ->where('cat_rfc',$rfc)
            ->update(['cat_materia' => $materia, 'cat_unidad' => $unidad, 'respuesta' => $res5, 'valor' => $num5]);
        }elseif($res5 && $num5 && !$pre5){
            $res = DB::table('respuestas_preguntas')
                ->select('id_res_pre')
                ->where('cat_unidad',$unidad)
                ->where('cat_materia',$materia)
                ->where('cat_rfc',$rfc)
                ->where('cat_pregunta',$idPregunta)
                ->orderBy('id_res_pre','DESC')
                ->first();
            if($res!=null || $res!=""){
                $idNew2 = ((int)$res->id_res_pre)+1;
            }else{
                $idNew2 = 0;
            }
            $preguntaAdd = DB::table('respuestas_preguntas')->insert(
                ['id_res_pre' => $idNew2,'cat_pregunta' => $idPregunta, 'cat_materia' => $materia, 'cat_rfc' => $rfc, 'valor' => $num5, 'respuesta' => $res5, 'cat_unidad' => $unidad]
            );
        }elseif(!($res5 && $num5) && $pre5){
            $res = DB::table('respuestas_preguntas')
            ->where('id_res_pre',$pre5)
            ->where('cat_pregunta',$idPregunta)
            ->where('cat_materia',$materiaV)
            ->where('cat_unidad',$unidadV)
            ->where('cat_rfc',$rfc)
            ->delete();
        }
        return response()->json(true);
    }
    
    public function catalogoPreguntaGet(Request $request){
        //dd($request->all());
        $unidad = $request->unidad;
        $rfc = $request->rfc;
        $materia = $request->materia;
        $idPregunta = $request->idPregunta;
        $res = DB::table('respuestas_preguntas')
            ->where('cat_unidad',$unidad)
            ->where('cat_materia',$materia)
            ->where('cat_rfc',$rfc)
            ->where('cat_pregunta',$idPregunta)
            ->orderBy('id_res_pre','ASC')
            ->get();
        return response()->json($res);
    }
    
    public function catalogoPreguntasGet(Request $request){
        $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
        $unidad = $request->unidad;
        $materia = $request->materia;
        $grupos = DB::table('catalogo_preguntas')
            ->select('id_pregunta','pregunta')
            ->where('unidad',$unidad)
            ->where('materia',$materia)
            ->where('rfc_p',$rfc)
            ->get();
        $table="";
        foreach($grupos as $grupo){
            $table.='
            <tr>
                <td>'.$grupo->id_pregunta.'</td>
                <td><a class="pregunta" href="#!" data-rfc="'.$rfc.'" data-unidad="'.$unidad.'" data-materia="'.$materia.'" data-id-pregunta="'.$grupo->id_pregunta.'" data-pregunta="'.$grupo->pregunta.'">'.$grupo->pregunta.'</a></td>
            </tr>
            ';
        }
        return $table;
    }
    
    public function catalogoPreguntas(){
        //SELECT DISTINCT materia FROM grupos WHERE periodo='$periodo_actual' and rfc='$control_rfc'
        $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
        $temp=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
        $grupos = DB::table('grupos')
            ->select('materia')
            ->where('periodo','=',$temp)
            ->where('rfc','=',$rfc)
            ->distinct()
            ->get();
        return view('safd.examenes.catalogo.index')->with('grupos',$grupos);
    }
    
    public function getgrupos(){
        $final="";
        $temp=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
        if(\Auth::user()->type=="0"){
            $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
            $grupos = DB::table('grupos')
            ->select('grupo')
            ->where('periodo','=',$temp)
            ->where('rfc','=',$rfc)
            ->distinct()
            ->get();
            $final="<select class='select1' id='etiqueta' name='etiqueta'>";
            foreach($grupos as $grupo){
                $final=$final."<option value='$grupo->grupo'>$grupo->grupo</option>";
            }
            $final=$final."</select><label for='etiqueta'>Para:</label>";
        
        }
        else if(\Auth::user()->type=="1"){
            $control = Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
            $grupos = DB::table('seleccion_materias')
            ->select('grupo')
            ->where('periodo','=',$temp)
            ->where('no_de_control','=',$control)
            ->distinct()
            ->get();
            $final="<select class='select1' id='etiqueta2' name='etiqueta2'>";
            foreach($grupos as $grupo){
                $final=$final."<option value='$grupo->grupo'>$grupo->grupo</option>";
            }
            $final=$final."</select><label for='etiqueta2'>Para:</label>";
        }
        return $final;
    }
    public function enviarMensajes(Request $Request){
        
        if(\Auth::user()->type=="0"){//profesor
            if($Request->tipoUsuario=="alumno"){
                $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
                $alumno = Alumno::where('nombre_user','=',$Request->etiqueta)->first();
                if(!$alumno){
                    return redirect()->route('safd.profesor.mensajes.IndexMensajes');
                }
                $ncontrol = $alumno->no_de_control;
                
                $temp= new MensajePersonalAlumno();
                $temp->rfc = $rfc;
                $temp->mensaje = $Request->area;
                $temp->fecha_hora = date('Y-m-d H:i:s'); 
                $temp->no_de_control_e = $ncontrol;
                $temp->estatus = "0";
                $temp->asunto = $Request->asunto;
                if($Request->file('file')){
                    $file = $Request->file('file');
                    $name = 'Asafd_'. time() . '.' .$file->getClientOriginalExtension();
                    $path = public_path() . '/Adjuntos/AdjuntosProfesores/';
                    $file->move($path,$name);
                    $temp->adjunto =$name;   
                }
                else{
                    $temp->adjunto =null;
                }
                $temp->save();
                return redirect()->route('safd.profesor.mensajes.IndexMensajes');
            }
            if($Request->tipoUsuario=="personal"){
                $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
                $rfc_e=Personal::where('nombre_user','=',$Request->etiqueta)->first();
                if(!$rfc_e){
                    return redirect()->route('safd.profesor.mensajes.IndexMensajes');
                }
                $rfc_e = $rfc_e->rfc;
                
                $temp= new MensajePersonalPersonal();
                $temp->rfc = $rfc;
                $temp->mensaje = $Request->area;
                $temp->fecha_hora = date('Y-m-d H:i:s'); 
                $temp->rfc_e = $rfc_e;
                $temp->estatus = "0";
                $temp->asunto = $Request->asunto;
                if($Request->file('file')){
                    $file = $Request->file('file');
                    $name = 'Psafd_'. time() . '.' .$file->getClientOriginalExtension();
                    $path = public_path() . '/Adjuntos/AdjuntosProfesores/';
                    $file->move($path,$name);
                    $temp->adjunto =$name;   
                }
                else{
                    $temp->adjunto =null;
                }
                $temp->save();
                return redirect()->route('safd.profesor.mensajes.IndexMensajes');
            }
            if($Request->tipoUsuario=="grupo"){
                $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
                $per=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
                $materias=Grupo::where('grupo','=',$Request->etiqueta)->where('rfc','=',$rfc)->where('periodo','=',$per)->distinct()->get();
                
                if(!$materias){
                    return redirect()->route('safd.profesor.mensajes.IndexMensajes');
                }
                
                foreach($materias as $materia){
                    $temp=new MensajePersonalGrupo();
                    $temp->rfc = $rfc;
                    $temp->mensaje = $Request->area;
                    $temp->fecha_hora = date('Y-m-d H:i:s'); 
                    $temp->periodo = $per;
                    $temp->materia =$materia->materia;
                    $temp->grupo = $Request->etiqueta;
                    $temp->estatus=0;
                    $temp->asunto =$Request->asunto;
                    if($Request->file('file')){
                        $file = $Request->file('file');
                        $name = 'Gsafd_'. time() . '.' .$file->getClientOriginalExtension();
                        $path = public_path() . '/Adjuntos/AdjuntosProfesores/';
                        $file->move($path,$name);
                        $temp->adjunto =$name;   
                    }
                    else{
                        $temp->adjunto =null;
                    }
                    $temp->save();
                }
                return redirect()->route('safd.profesor.mensajes.IndexMensajes');
                
            }
        }
        
    }
    
    public function mostrarmalumnos(){
        $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
        $mensajes=MensajeAlumnoPersonal::where('rfc_e','=',$rfc)->get();
        $final="<table><thead>
          <tr>
              <th>De</th>
              <th>Asunto</th>
              <th>Fecha</th>
          </tr>
        </thead><tbody>";
        foreach($mensajes as $mensaje){
            $nombre=Alumno::find($mensaje->no_de_control)->nombre_user;
            $final=$final."<tr>";
            $final=$final."<td>$nombre</td>";
            $final=$final."<td><a data-fecha='$mensaje->fecha_hora' data-tabla='alumno' href='#' class='detalles'>$mensaje->asunto</a></td>";
            $final=$final."<td>$mensaje->fecha_hora</td>";
            $final=$final."<tr>";
        }
        $final=$final."</tbody></table>";
        return $final;
    }
    public function mostrarmmaestros(){
        $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
        $mensajes=MensajePersonalPersonal::where('rfc_e','=',$rfc)->get();
        $final="<table><thead>
          <tr>
              <th>De</th>
              <th>Asunto</th>
              <th>Fecha</th>
          </tr>
        </thead><tbody>";
        foreach($mensajes as $mensaje){
            $nombre=Personal::find($mensaje->rfc)->nombre_user;
            $final=$final."<tr>";
            $final=$final."<td>$nombre</td>";
            $final=$final."<td><a data-fecha='$mensaje->fecha_hora' data-tabla='personal' href='#' class='detalles'>$mensaje->asunto</a></td>";
            $final=$final."<td>$mensaje->fecha_hora</td>";
            $final=$final."<tr>";
        }
        $final=$final."</tbody></table>";
        return $final;
    }
    
    public function mostrarmmaterias(Request $Request){
        $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
        $mensajes=MensajePersonalGrupo::where('materia','=',$Request->materia)->get();
        $mensajes2=MensajeAlumnoGrupo::where('materia','=',$Request->materia)->get();
        $final="<table><thead>
          <tr>
              <th>De</th>
              <th>Asunto</th>
              <th>Fecha</th>
          </tr>
        </thead><tbody>";
        foreach($mensajes as $mensaje){
            $nombre=Personal::find($mensaje->rfc)->nombre_user;
            $final=$final."<tr>";
            $final=$final."<td>$nombre</td>";
            $final=$final."<td><a data-fecha='$mensaje->fecha_hora' data-tabla='grupos' href='#' class='detalles'>$mensaje->asunto</a></td>";
            $final=$final."<td>$mensaje->fecha_hora</td>";
            $final=$final."<tr>";
        }
        foreach($mensajes2 as $mensaje){
            $nombre=Alumno::find($mensaje->no_de_control)->nombre_user;
            $final=$final."<tr>";
            $final=$final."<td>$nombre</td>";
            $final=$final."<td><a data-fecha='$mensaje->fecha_hora' data-tabla='grupos' href='#' class='detalles'>$mensaje->asunto</a></td>";
            $final=$final."<td>$mensaje->fecha_hora</td>";
            $final=$final."<tr>";
        }
        $final=$final."</tbody></table>";
        return $final;
    }
    public function mostrarenviados(){
        if(\Auth::user()->type=="0"){//profesor
            $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
            $mensajes=MensajePersonalPersonal::where('rfc','=',$rfc)->get();
            $mensajes2=MensajePersonalAlumno::where('rfc','=',$rfc)->get();
            $mensajes3=MensajePersonalGrupo::where('rfc','=',$rfc)->get();
            $final="<table><thead>
              <tr>
                  <th>De</th>
                  <th>Asunto</th>
                  <th>Fecha</th>
              </tr>
            </thead><tbody>";
            foreach($mensajes as $mensaje){
                $nombre=Personal::find($rfc)->nombre_user;
                $final=$final."<tr>";
                $final=$final."<td>$nombre</td>";
                $final=$final."<td><a data-fecha='$mensaje->fecha_hora' data-tabla='personal' href='#' class='detallese'>$mensaje->asunto</a></td>";
                $final=$final."<td>$mensaje->fecha_hora</td>";
                $final=$final."<tr>";
            }
            foreach($mensajes2 as $mensaje){
                $nombre=Personal::find($rfc)->nombre_user;
                $final=$final."<tr>";
                $final=$final."<td>$nombre</td>";
                $final=$final."<td><a data-fecha='$mensaje->fecha_hora' data-tabla='alumno' href='#' class='detallese'>$mensaje->asunto</a></td>";
                $final=$final."<td>$mensaje->fecha_hora</td>";
                $final=$final."<tr>";
            }
            foreach($mensajes3 as $mensaje){
                $nombre=Personal::find($rfc)->nombre_user;
                $final=$final."<tr>";
                $final=$final."<td>$nombre</td>";
                $final=$final."<td><a data-fecha='$mensaje->fecha_hora' data-tabla='grupos' href='#' class='detallese'>$mensaje->asunto</a></td>";
                $final=$final."<td>$mensaje->fecha_hora</td>";
                $final=$final."<tr>";
            }
            $final=$final."</tbody></table>";
        
        }
        return $final;
        
    }
    
    public function detallesmensajes(Request $Request){
        $final="";
        if(\Auth::user()->type=="0"){//Profesor
            if($Request->tabla=="alumno"){
                $temp=MensajeAlumnoPersonal::where('fecha_hora','=',$Request->fecha)->first();
                $nombre=Alumno::find($temp->no_de_control)->nombre_user;
                $final=$final."<div class='row'>
                                <div class='col s12 m12'>
                                  <div class='card blue-grey darken-1'>
                                    <div class='card-action'>
                                      <p>De:  $nombre  </p>
                                      <p>Archivo Adjunto: $temp->adjunto</p>
                                      <p>Fecha: $temp->fecha_hora</p>
                                    </div>
                                    <div class='card-content white-text'>
                                      <span class='card-title'>Asunto: $temp->asunto</span>
                                      <p>$temp->mensaje</p>
                                    </div>
                                  </div>
                                </div>
                              </div>";
                              
            }
            if($Request->tabla=="personal"){
                $temp=MensajePersonalPersonal::where('fecha_hora','=',$Request->fecha)->first();
                $nombre=Personal::find($temp->rfc)->nombre_user;
                $final=$final."<div class='row'>
                                <div class='col s12 m12'>
                                  <div class='card blue-grey darken-1'>
                                    <div class='card-action'>
                                      <p>De:  $nombre  </p>
                                      <p>Archivo Adjunto: $temp->adjunto</p>
                                      <p>Fecha: $temp->fecha_hora</p>
                                    </div>
                                    <div class='card-content white-text'>
                                      <span class='card-title'>Asunto: $temp->asunto</span>
                                      <p>$temp->mensaje</p>
                                    </div>
                                  </div>
                                </div>
                              </div>";
            }
            if($Request->tabla=="grupos"){
                if(MensajePersonalGrupo::where('fecha_hora','=',$Request->fecha)->first()){
                $temp=MensajePersonalGrupo::where('fecha_hora','=',$Request->fecha)->first();
                $nombre=Personal::find($temp->rfc)->nombre_user;
                $final=$final."<div class='row'>
                                <div class='col s12 m12'>
                                  <div class='card blue-grey darken-1'>
                                    <div class='card-action'>
                                      <p>De:  $nombre  </p>
                                      <p>Archivo Adjunto: $temp->adjunto</p>
                                      <p>Fecha: $temp->fecha_hora</p>
                                    </div>
                                    <div class='card-content white-text'>
                                      <span class='card-title'>Asunto: $temp->asunto</span>
                                      <p>$temp->mensaje</p>
                                    </div>
                                  </div>
                                </div>
                              </div>";
                }
                else{
                    $temp=MensajeAlumnoGrupo::where('fecha_hora','=',$Request->fecha)->first();
                    $nombre=Alumno::find($temp->no_de_control)->nombre_user;
                    $final=$final."<div class='row'>
                                    <div class='col s12 m12'>
                                      <div class='card blue-grey darken-1'>
                                        <div class='card-action'>
                                          <p>De:  $nombre  </p>
                                          <p>Archivo Adjunto: $temp->adjunto</p>
                                          <p>Fecha: $temp->fecha_hora</p>
                                        </div>
                                        <div class='card-content white-text'>
                                          <span class='card-title'>Asunto: $temp->asunto</span>
                                          <p>$temp->mensaje</p>
                                        </div>
                                      </div>
                                    </div>
                                  </div>";
                }
            }
        }
        return $final;
    }
    
    
    public function consultarExamenes(Request $Request){
        $materia = $Request->selectMateria;
        $grupo =  $Request->selectGrupo;
        $examen = DB::table('programacion_examen')->where('activo', '1')->where('materia',$materia)->where('grupo',$grupo)->get();
        $examen2 = DB::table('programacion_examen')->where('activo', '0')->where('materia',$materia)->where('grupo',$grupo)->get();
        $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
            $per=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
            $grupos = DB::table('grupos')
            ->select('materia')
            ->where('periodo','=',$per)
            ->where('rfc','=',$rfc)
            ->distinct()
            ->get();
            $materias = DB::table('grupos')
            ->select('grupo')
            ->where('periodo','=',$per) 
            ->where('rfc','=',$rfc)
            ->distinct()
            ->get();
              return response()->json([$examen,$examen2]);
        
        
    }
    
     public function datosConsultaExamenes(Request $Request){
            $materia = $Request->selectMateria;
            $grupo =  $Request->selectGrupo;
           $examen = DB::table('programacion_examen')->where('activo', '1')->where('materia',$materia)->where('grupo',$grupo)->get();
            $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
            $per=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
            $grupos = DB::table('grupos')
            ->select('materia')
            ->where('periodo','=',$per)
            ->where('rfc','=',$rfc)
            ->distinct()
            ->get();
            $materias = DB::table('grupos')
            ->select('grupo')
            ->where('periodo','=',$per)
            ->where('rfc','=',$rfc)
            ->distinct()
            ->get();
            return view('safd.examenes.consultar.consultarExamenes')->with('grupos',$grupos)->with('materias',$materias)->with('examen',$examen);
          
     }
     
     public function programarExamen(){
        $rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
            $per=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
            $grupos = DB::table('grupos')
            ->select('materia')
            ->where('periodo','=',$per)
            ->where('rfc','=',$rfc)
            ->distinct()
            ->get();
            $materias = DB::table('grupos')
            ->select('grupo')
            ->where('periodo','=',$per)
            ->where('rfc','=',$rfc)
            ->distinct()
            ->get();
         return view('safd.examenes.programar.programarExamen')->with('grupos',$grupos)->with('materias',$materias);
     }
}
