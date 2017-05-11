@extends('safd.template.main')

@section('title','Alumno')

@section('name')
{{ $nombre }}
@endsection

@section('content')
    <div class="container">
        <div class="text-left">
            <h5>Informacion de Profesores<h5>
                
            <!-- Dropdown Trigger -->
            <a class='dropdown-button btn' href='#' data-activates='materias'>Materias</a>
            <!-- Dropdown Structure -->
            <ul id='materias' class='dropdown-content'>
                @foreach($materias as $materia)
                    <li><a class="materia" href="#!" data-grupo="{{ $materia->grupo }}" data-materia="{{ $materia->materia }}">{{ $materia->materia }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="row" id="info"></div>
    </div>
@endsection

@section('script')
<script type="text/javascript">
var token = "{{csrf_token()}}";
$(document).ready(function(){
    $(".materia").on("click",function(e){
        e.preventDefault();
        var grupo = $(this).data("grupo");
        var materia = $(this).data("materia");
        var url = "{{ route('safd.alumno.index.info') }}";
        $.ajax({
            type:'POST',
            url:url,
            data:{
                _token:token,
                grupo:grupo,
                materia:materia,
            },
            success:function(response){
                var content="<hr/>";
                content+="<div class='col s6'>";
                content+="<img src='/imagenes/"+response.foto+"' style='height:200px;'>";
                content+="<h5>Nombre: "+response.nombre+"</h5>";
                content+="<h5>Correo: "+response.correo+"</h5>";
                content+="<h5>Teléfono: "+response.telefono+"</h5>";
                content+="</div>";
                content+="<div class='col s6'>";
                content+="<h5>Curriculum:</h5>";
                content+="<div>"+response.curriculum+"</div>";
                content+="</div>";
                $('#info').html(content);
            }
        });
    });
});
</script>
@endsection