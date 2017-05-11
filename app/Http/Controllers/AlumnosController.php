<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Alumno;
use App\Personal;
use App\MensajeAlumnoAlumno;
use App\MensajeAlumnoPersonal;
use App\PeriodosEscolares;
use App\SeleccionMaterias;
use App\MensajeAlumnoGrupo;

class AlumnosController extends Controller
{
    public function documentos(){
        return view('safd.alumno.documentos.documentos');
    }
    
    public function documentosSubir(){
        return view('safd.alumno.documentos.subir');
    }
    
    
    public function documentosSet(Request $request){
        $no_de_control =Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
        $temp=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
        $file = $request->file('file');
        $name = 'safd_'. time() . '.' .$file->getClientOriginalExtension();
        $path = public_path() . '/documentos/';
        $file->move($path,$name);
        
        $newId=1;
        $archivo = DB::table('archivo_alumno')
            ->select('id_archivo_a')
            ->orderBy('id_archivo_a','DESC')
            ->first();
        if($archivo){
            $newId=((int)$archivo->id_archivo_a)+1;
        }
        
        $preguntaAdd = DB::table('archivo_alumno')->insert(
            ['id_archivo_a' => $newId,'no_control_a' => $no_de_control, 'fecha_subida' => date('Y-m-d H:i:s'), 'publico' => $request->tipo, 'id_tarea_subida' => -1, 'nombre' => $name, 'periodo' => $temp]
        );
        return redirect()->route('safd.alumno.documentos.subir');
    }
    
    public function index(){
        $nombre = Alumno::where('id_user',\Auth::user()->id)->first()->nombre_alumno;
        $no_de_control =Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
        $temp=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
        $materias = DB::table('seleccion_materias')
            ->select('materia','grupo')
            ->where('periodo','=',$temp)
            ->where('no_de_control','=',$no_de_control)
            ->distinct()
            ->get();
        return view('safd.alumno.index')->with('materias',$materias)->with('nombre',$nombre);
    }
    
    public function profesorInfo(Request $request){
        $grupo = $request->grupo;
        $materia = $request->materia;
        $per=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
        $materias = DB::table('grupos')
            ->select('rfc')
            ->where('periodo','=',$per)
            ->where('materia','=',$materia)
            ->where('grupo','=',$grupo)
            ->first();
        $rfc = $materias->rfc;
        $persona = DB::table('personal_info')
            ->where('rfc_p','=',$rfc)
            ->first();
        return response()->json($persona);
    }
    
    public function crearmensajes(){
            return view('safd.alumno.mensajes.crear');
    }
    public function getgrupos(){
        $final="";
        $temp=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
    
            $control = Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
            $grupos = DB::table('seleccion_materias')
            ->select('grupo')
            ->where('periodo','=',$temp)
            ->where('no_de_control','=',$control)
            ->distinct()
            ->get();
            $final="<select class='select1' id='etiqueta' name='etiqueta'>";
            foreach($grupos as $grupo){
                $final=$final."<option value='$grupo->grupo'>$grupo->grupo</option>";
            }
            $final=$final."</select><label for='etiqueta'>Para:</label>";
        
        return $final;
    }
    
    public function enviarMensajes(Request $Request){
        if(\Auth::user()->type=="1"){//Alumno
            if($Request->tipoUsuario=="alumno"){
                $ncontrolp= Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
                $ncontrol=Alumno::where('nombre_user','=',$Request->etiqueta)->first()->no_de_control;
                $temp= new MensajeAlumnoAlumno();
                $temp->no_de_control = $ncontrolp;
                $temp->mensaje = $Request->area;
                $temp->fecha_hora = date('Y-m-d H:i:s'); 
                $temp->no_de_control_e = $ncontrol;
                $temp->estatus = "0";
                $temp->asunto = $Request->asunto;
                if($Request->file('file')){
                    $file = $Request->file('file');
                    $name = 'Asafd_'. time() . '.' .$file->getClientOriginalExtension();
                    $path = public_path() . '/Adjuntos/AdjuntosAlumnos/';
                    $file->move($path,$name);
                    $temp->adjunto =$name;   
                }
                else{
                    $temp->adjunto =null;
                }
                $temp->save();
                return redirect()->route('safd.alumno.mensajes.crearmensajes');
            }
            if($Request->tipoUsuario=="personal"){
                $ncontrol = Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
                $rfc_e=Personal::where('nombre_user','=',$Request->etiqueta)->first()->rfc;
                $temp= new MensajeAlumnoPersonal();
                $temp->no_de_control = $ncontrol;
                $temp->mensaje = $Request->area;
                $temp->fecha_hora = date('Y-m-d H:i:s'); 
                $temp->rfc_e = $rfc_e;
                $temp->estatus = "0";
                $temp->asunto = $Request->asunto;
                if($Request->file('file')){
                    $file = $Request->file('file');
                    $name = 'Psafd_'. time() . '.' .$file->getClientOriginalExtension();
                    $path = public_path() . '/Adjuntos/AdjuntosAlumnos/';
                    $file->move($path,$name);
                    $temp->adjunto =$name;   
                }
                else{
                    $temp->adjunto =null;
                }
                $temp->save();
                return redirect()->route('safd.alumno.mensajes.crearmensajes');
            }
            if($Request->tipoUsuario=="grupo"){
                $ncontrol = Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
                $per=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
                $materias=SeleccionMaterias::where('grupo','=',$Request->etiqueta)->where('no_de_control','=',$ncontrol)->where('periodo','=',$per)->distinct()->get();
                foreach($materias as $materia){
                    $temp=new MensajeAlumnoGrupo();
                    $temp->no_de_control = $ncontrol;
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
                        $path = public_path() . '/Adjuntos/AdjuntosAlumnos/';
                        $file->move($path,$name);
                        $temp->adjunto =$name;   
                    }
                    else{
                        $temp->adjunto =null;
                    }
                    $temp->save();
                }
                return redirect()->route('safd.alumno.mensajes.crearmensajes');
                
            }
        }
        
    }
    
    public function Mensajesrec(){
        return view('');
    }
}