@extends('safd.template.main')

@section('title','Sistema')

@section('content')
       <div class="container">
            <h4>SUBIR DOCUMENTOS</h4> 
            {!! Form::open(['route' => 'safd.profesor.subirDocumento', 'method' => 'POST', 'files' => true]) !!}
            <div class="row">
                <div class="input-field">
                <select class="select" name="selectTipo" id="selectTipo">
                  <option value="" selected>Escoge</option>
                  <option value="1">Publico</option>
                  <option value="2">Privado</option>
                  <option value="3">Tarea</option>
                </select>
                <label>Tipo</label>
              </div>
            <div class="container" id="capaTarea" style="display:none;">
                <div class="row">
                     <label for="Nombre">Nombre</label>
                    <input id="nombreMateria" name="nombreMateria" type="text" class="validate">
                </div>
                    <div class="input-field">
                    <select class="select" name="selectMateria" id="selectMateria">
                      @foreach($grupos as $grupo)
                          <option value="{{$grupo->materia}}">{{$grupo->materia}}</option>
                      @endforeach
                    </select>
                    <label>Materia</label>
                  </div>
                   <label for="fechaLimite">Fecha Limite</label>
                    <input id="fechaLimite" name="fechaLimite" type="date" class="validate">
                     <label for="horaLimite">Hora Limite</label>
                    <input id="horas" name="horas" type="number" class="validate" style="width:40px;" min=0 max=23>
                    <input id="minutos" name="minutos" type="number" class="validate" style="width:40px;" min=0 max=60>
                    <input id="segundos" name="segundos" type="number" class="validate" style="width:40px;" min=0 max=60>
            </div>
                <div class="input-field">
                    <textarea class="materialize-textarea"  name="curriculum" id="curriculum"/></textarea>
                    <label for="curriculum">Descripcion</label>
                </div>
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Archivo</span>
                    <input type="file" name="file">
                  </div>
                  <div class="file-path-wrapper">
                    <input class="file-path validate" type="text">
                  </div>
                </div>
            </div>
            <button class="btn" type="submit">Subir Documento</button>
            {!! Form::close() !!}
        </div>
    
    <div class="container">
      <h4>MIS DOCUMENTOS</h4> 
        <div class="row">
            <!-- Dropdown Structure -->
            <ul id="dropdown1" class="dropdown-content">
              <li><a class="btn-publicos" href="{{ route('safd.profesor.documentos.documentos') }}" name="btn-publicos">Publicos</a></li>
              <li><a href="#!">Privado</a></li>
              <li class="divider"></li>
              <li><a href="#!">three</a></li>
            </ul>
            <nav>
              <div class="nav-wrapper">
                <a href="#!" class="brand-logo"></a>
                <ul class="center hide-on-med-and-down">
                  <li><a  class="btn-publicos" href="#" name="btn-publicos">Publicos</a></li>
                  <li><a class="btn-privados" href="#" name="btn-privados">Privados</a></li>
                  <!-- Dropdown Trigger -->
                  <li><a class="dropdown-button" href="#!" data-activates="dropdown1">Carpeta Evidencias<i class="material-icons right">arrow_drop_down</i></a></li>
                  <li><a class="btn-publicos" href="#" name="btn-publicos">Todos</a></li>
                  <li><a class="btn-tareas"  href="#" name="btn-tareas">Tareas Subidas</a></li>
                </ul>
              </div>
            </nav>
        </div>
    </div>
    
     <div class="container" id="capa" style="display:none;">
        <div class="row">
            <table>
        <thead>
          <tr>
              <th>Descripcion</th>
              <th>Archivo</th>
              <th>Fecha de Subida</th>
          </tr>
        </thead>

        <tbody>
            
          @foreach($temp as $t)
          <tr>
            <td>{{ $t->descripcion }}</td>
            <td>{{ $t->dir }}</td>
            <td>{{ $t->fecha_subida }}</td>
          </tr>
          @endforeach 
          
        </tbody>
      </table>
     
        </div>
    </div>
    <div class="container" id="capa1" style="display:none;">
        <div class="row">
            <table>
        <thead>
          <tr>
              <th>Descripcion</th>
              <th>Archivo</th>
              <th>Fecha de Subida</th>
          </tr>
        </thead>

        <tbody>
            
          @foreach($temp2 as $t)
          <tr>
            <td>{{ $t->descripcion }}</td>
            <td>{{ $t->dir }}</td>
            <td>{{ $t->fecha_subida }}</td>
          </tr>
          @endforeach 
          
        </tbody>
      </table>
     
        </div>
    </div>
    <div class="container" id="capa2" style="display:none;">
        <div class="row">
            <table>
        <thead>
          <tr>
              <th>Nombre de la Tarea</th>
              <th>Fecha de Subida</th>
          </tr>
        </thead>

        <tbody>
            
          @foreach($temp3 as $t)
          <tr>
            <td>{{ $t->nombre }}</td>
            <td>{{ $t->fecha_subida }}</td>
          </tr>
          @endforeach 
          
        </tbody>
      </table>
     
        </div>
    </div>
    
@endsection

@section('script')
<script type="text/javascript">
    $(".btn-publicos").on("click",function(){
		  $("#capa").show();
		   $("#capa1").hide();
		   $("#capa2").hide();
    });
    $(".btn-privados").on("click",function(){
		  $("#capa1").show();
		   $("#capa").hide();
		   $("#capa2").hide();
    });
    $(".btn-tareas").on("click",function(){
         $("#capa2").show();
		  $("#capa1").hide();
		   $("#capa").hide();
    });
     $("#selectTipo").change(function(){
            if($(this).val()=="3"){
              	$("#capaTarea").show();
            }
     });
     
</script>
@endsection