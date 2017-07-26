@extends('safd.template.main')

@section('title','Mensajes')

@section('content')
        <div class="row">
            <div class="col m6">
              <h4 class="center">Enviar Mensaje</h4>
              <div>
                {!! Form::open(['route' => 'safd.profesor.mensajes.enviarMensajes', 'method' => 'POST', 'files' => true]) !!}
                    <div class="input-field">
                      <select class="select" id="tipoUsuario" name="tipoUsuario" required>
                        <option value="" disabled selected>Selecciona una opcion</option>
                        <option value="alumno">Alumnos</option>
                        <option value="personal">Maestros</option>
                        <option value="grupo">Grupos</option>
                      </select>
                      <label>Para usuario:</label>
                    </div>
                    <div class="input-field" id="cambio">
                      <input  id="etiqueta" name="etiqueta" type="text" class="validate" required>
                      <label for="etiqueta">Para:</label>
                    </div>
                    <div class="input-field" id="cambio1">
                    </div>
                    
                    <div class="input-field">
                      <input  id="asunto" name="asunto" type="text" class="validate" required>
                      <label for="asunto">Asunto:</label>
                    </div>
                    <div class="file-field input-field">
                      <div class="btn">
                        <span>File</span>
                        <input type="file" id="file" name="file">
                      </div>
                      <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" >
                      </div>
                    </div>
                    <div class="input-field">
                      <textarea id="area" name="area" class="materialize-textarea" data-length="120" required></textarea>
                      <label for="area">Mensaje:</label>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="center">
                      <input class="btn" type="submit" value="Enviar"/>
                    </div>
                {!! Form::close() !!}
                    
              </div>
            </div>
            <div class="col m6">
              <div class="card">
                <div class="card-tabs">
                  <ul class="tabs tabs-fixed-width">
                    <li class="tab"><a class="active" href="#Mrecibidos">Mensajes Recibidos</a></li>
                    <li class="tab"><a href="#Menviados" id="me">Mensajes Enviados</a></li>
                  </ul>
                </div>
                <div class="card-content grey lighten-4">
                  <div id="Mrecibidos">
                    <ul id="materias" class="dropdown-content">
                       @foreach($materias as $materia)
                        <li><a class="materias" data-tabla="materia" data-materia="{{ $materia->materia }}" href="#!">{{ $materia->materia }}</a></li>
                      @endforeach
                    </ul>
                    <nav class='red darken-4'>
                      <div class="nav-wrapper">
                        <ul id="nav-mobile" class="left hide-on-med-and-down">
                          <li><a href="#" id="alu">Alumno</a></li>
                          <li><a href="#" id="mae">Maestro</a></li>
                          <li><a class="dropdown-button" data-activates="materias" href="#" id="mat">Materia<i class="material-icons right">arrow_drop_down</i></a></li>
                        </ul>
                      </div>
                    </nav>  
                    <div id="mostrarmensajes">
                      
                    </div>
                  </div>
                  <div id="Menviados">
                    <div id="mostrarmensajesenv">
                      
                    </div>
                    
                  
                  </div>
                </div>
              </div>
            </div>
        </div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
            var token = "{{csrf_token()}}";
            $("#tipoUsuario").change(function(e){
              if($(this).val()=="grupo"){
                var materia="";
              	$.ajax({
              		type:'GET',
              		url:"{{ route('safd.profesor.mensajes.getgrupos') }}",
              		data: materia,
              		success:function(response){
              		  $('#etiqueta').attr('disabled','true');
              		  $('#cambio').hide();
              		  $("#cambio1").html(response);
              			$("#cambio1").show();
              			$('.select1').material_select();
              		}
              	}); 
              }
              else{
                $("cambio1").hide();
                $("cambio").show();
              }
            });
            $('#alu').click(function(){
               var materia="";
              	$.ajax({
              		type:'GET',
              		url:"{{ route('safd.profesor.mensajes.mostrarmalumnos') }}",
              		data: materia,
              		success:function(response){
              		  $('#mostrarmensajes').html(response);
              		}
              	}); 
            });
            $('#mae').click(function(){
              var materia="";
              	$.ajax({
              		type:'GET',
              		url:"{{ route('safd.profesor.mensajes.mostrarmmaestros') }}",
              		data: materia,
              		success:function(response){
              		  $('#mostrarmensajes').html(response);
              		}
              	});  
            });
            
           $(document).on('click','.detalles',function(e){
             e.preventDefault();
             var fecha1=$(this).data('fecha');
             var tabla1=$(this).data('tabla');
              	$.ajax({
              		type:'POST',
              		url:"{{ route('safd.profesor.mensajes.detallesmensajes') }}",
              		data: 
                    {   fecha: fecha1,
                        tabla: tabla1,
                        _token:token
                    },
              		success:function(response){
              		  $('#mostrarmensajes').html(response);
              		}
              	});
           });
           $(document).on('click','.materias',function(e){
             e.preventDefault();
             var materia1=$(this).data('materia');
              	$.ajax({
              		type:'POST',
              		url:"{{ route('safd.profesor.mensajes.mostrarmmaterias') }}",
              		data: 
                    {   materia: materia1,
                        _token:token
                    },
              		success:function(response){
              		  $('#mostrarmensajes').html(response);
              		}
              	});
           });
           $(document).on('click','#me',function(e){
             e.preventDefault();
             var materia1="";
              	$.ajax({
              		type:'GET',
              		url:"{{ route('safd.profesor.mensajes.mostrarenviados') }}",
              		data: 
                    {   materia: materia1,
                        _token:token
                    },
              		success:function(response){
              		  $('#mostrarmensajesenv').html(response);
              		}
              	});
           });
           $(document).on('click','.detallese',function(e){
             e.preventDefault();
             var fecha1=$(this).data('fecha');
             var tabla1=$(this).data('tabla');
              	$.ajax({
              		type:'POST',
              		url:"{{ route('safd.profesor.mensajes.detallesmensajes') }}",
              		data: 
                    {   fecha: fecha1,
                        tabla: tabla1,
                        _token:token
                    }, 
              		success:function(response){
              		  $('#mostrarmensajesenv').html(response);
              		}
              	});
           });
           
           
          });
</script>
@endsection