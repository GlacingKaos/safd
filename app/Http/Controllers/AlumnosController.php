<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Alumno;
use App\Personal;
use App\MensajeAlumnoAlumno;
use App\MensajeAlumnoPersonal;
use App\MensajeAlumnoGrupo;
use App\MensajePersonalAlumno;
use App\MensajePersonalPersonal;
use App\MensajePersonalGrupo;

use App\PeriodosEscolares;
use App\SeleccionMaterias;

class AlumnosController extends Controller
{
    public function documentos(){
        return view('safd.alumno.documentos.documentos');
    }
    
    public function documentosSubir(){
        return view('safd.alumno.documentos.subir');
    }
    
    public function getDocumentPublicos(Request $request){
        $no_de_control =Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
        $documentos = DB::table('archivo_alumno')
            ->select('id_archivo_a','fecha_subida','dir','nombre')
            ->where('no_control_a','=',$no_de_control)
            ->where('publico','=',1)
            ->get();
        return response()->json($documentos);
    }
    
    public function getDocumentTodos(Request $request){
        $no_de_control =Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
        $documentos = DB::table('archivo_alumno')
            ->select('id_archivo_a','fecha_subida','dir','nombre')
            ->where('no_control_a','=',$no_de_control)
            ->where('tarea','=',0)
            ->orderBy('fecha_subida','DESC')
            ->get();
        return response()->json($documentos);
    }
    
    public function getDocumentTareas(Request $request){
        $no_de_control =Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
        $temp=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
        $tareas = DB::table('tareas_p')
            ->select('id_tarea','materia','dir','nombre','resumen','fecha_limite','nombre_a','grupo')
            ->where('periodo','=',$temp)
            ->orderBy('fecha_limite','DESC')
            ->get();
        return response()->json($tareas);
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
    public function Mensajesrec(){
        $ncontrol =Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
        $per=PeriodosEscolares::orderBy('periodo', 'desc')->distinct()->first()->periodo;
        $materias=SeleccionMaterias::where('no_de_control','=',$ncontrol)->where('periodo','=',$per)->get();
        return view('safd.alumno.mensajes.recibidos')->with('materias',$materias);
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
                $ncontrol=Alumno::where('nombre_user','=',$Request->etiqueta)->first();
                if(!$ncontrol){
                    return redirect()->route('safd.alumno.mensajes.crearmensajes');
                }
                $ncontrol = $ncontrol->no_de_control;
                
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
                
                $rfc_e=Personal::where('nombre_user','=',$Request->etiqueta)->first();
                if(!$rfc_e){
                    return redirect()->route('safd.alumno.mensajes.crearmensajes');
                }
                $rfc_e = $rfc_e->rfc;
                
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
                if(!$materias){
                    return redirect()->route('safd.alumno.mensajes.crearmensajes');
                }
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
    public function mostrarmalumnos(){
        $ncontrol = Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
        $mensajes=MensajeAlumnoAlumno::where('no_de_control_e','=',$ncontrol)->get();
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
        $ncontrol = Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
        $mensajes=MensajePersonalAlumno::where('no_de_control_e','=',$ncontrol)->get();
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
    public function detallesmensajes(Request $Request){
        $final="";
        if(\Auth::user()->type=="1"){//Alumno
            if($Request->tabla=="alumno"){
                $temp=MensajePersonalAlumno::where('fecha_hora','=',$Request->fecha)->first();
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
            if($Request->tabla=="personal"){
                $temp=MensajePersonalAlumno::where('fecha_hora','=',$Request->fecha)->first();
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
                if(MensajeAlumnolGrupo::where('fecha_hora','=',$Request->fecha)->first()){
                $temp=MensajeAlumnoGrupo::where('fecha_hora','=',$Request->fecha)->first();
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
                    $temp=MensajePersonalGrupo::where('fecha_hora','=',$Request->fecha)->first();
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
    public function mostrarmmaterias(Request $Request){
        //$rfc = Personal::where('id_user',\Auth::user()->id)->first()->rfc;
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
        if(\Auth::user()->type=="1"){//profesor
            $ncontrol = Alumno::where('id_user',\Auth::user()->id)->first()->no_de_control;
            $mensajes=MensajeAlumnoAlumno::where('no_de_control','=',$ncontrol)->get();
            $mensajes2=MensajeAlumnoPersonal::where('no_de_control','=',$ncontrol)->get();
            $mensajes3=MensajeAlumnoGrupo::where('no_de_control','=',$ncontrol)->get();
            $final="<table><thead>
              <tr>
                  <th>De</th>
                  <th>Asunto</th>
                  <th>Fecha</th>
              </tr>
            </thead><tbody>";
            foreach($mensajes as $mensaje){
                $nombre=Alumno::find($ncontrol)->nombre_user;
                $final=$final."<tr>";
                $final=$final."<td>$nombre</td>";
                $final=$final."<td><a data-fecha='$mensaje->fecha_hora' data-tabla='personal' href='#' class='detallese'>$mensaje->asunto</a></td>";
                $final=$final."<td>$mensaje->fecha_hora</td>";
                $final=$final."<tr>";
            }
            foreach($mensajes2 as $mensaje){
                $nombre=Alumno::find($ncontrol)->nombre_user;
                $final=$final."<tr>";
                $final=$final."<td>$nombre</td>";
                $final=$final."<td><a data-fecha='$mensaje->fecha_hora' data-tabla='alumno' href='#' class='detallese'>$mensaje->asunto</a></td>";
                $final=$final."<td>$mensaje->fecha_hora</td>";
                $final=$final."<tr>";
            }
            foreach($mensajes3 as $mensaje){
                $nombre=Alumno::find($ncontrol)->nombre_user;
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
}