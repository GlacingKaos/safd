@extends('safd.template.main')

@section('title','Bandeja')

@section('content')
<div class="container">
    <div class="row">
    <div class="col m12 s12">
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
</div>
@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    var token = "{{csrf_token()}}";
    
     $('#alu').click(function(){
               var materia="";
              	$.ajax({
              		type:'GET',
              		url:"{{ route('safd.alumno.mensajes.mostrarmalumnos') }}",
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
              		url:"{{ route('safd.alumno.mensajes.mostrarmmaestros') }}",
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
              		url:"{{ route('safd.alumno.mensajes.detallesmensajes') }}",
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
              		url:"{{ route('safd.alumno.mensajes.mostrarmmaterias') }}",
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
              		url:"{{ route('safd.alumno.mensajes.mostrarenviados') }}",
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
              		url:"{{ route('safd.alumno.mensajes.detallesmensajes') }}",
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