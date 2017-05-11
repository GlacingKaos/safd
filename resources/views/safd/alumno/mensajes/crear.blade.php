@extends('safd.template.main')

@section('title','Alumno')

@section('content')
<div class="container">
    <div class="row">
        <div class="col m12 s12">
          <h4 class="center">Enviar Mensaje</h4>
          <div>
            {!! Form::open(['route' => 'safd.alumno.mensajes.enviarMensajes', 'method' => 'POST', 'files' => true]) !!}
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
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    
    $("#tipoUsuario").change(function(e){
              if($(this).val()=="grupo"){
                var materia="";
              	$.ajax({
              		type:'GET',
              		url:"{{ route('safd.alumno.mensajes.getgrupos') }}",
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
    
  });    
</script>
@endsection