@extends('safd.template.main')

@section('title','Mis Documentos')

@section('name')
    Instituto Tecnologico de Morelia
@endsection

@section('content')
<div class="container">
    <h5>Mis Documentos</h5>
    <div class="row">
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s3 red-text"><a href="#test1" id="publicos">Públicos</a></li>
                <li class="tab col s3 red-text"><a href="#test2" id="carpetas">Carpetas de Evidencias</a></li>
                <li class="tab col s3 red-text"><a href="#test3" id="todos">Todos</a></li>
                <li class="tab col s3 red-text"><a href="#test4" id="tareas">Tareas Activas</a></li>
            </ul>
        </div>
        <div id="test1" class="col s12">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody id="publicos-tabla"></tbody>
            </table>
        </div>
        <div id="test2" class="col s12"></div>
        <div id="test3" class="col s12">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody id="todos-tabla"></tbody>
            </table>
        </div>
        <div id="test4" class="col s12">
            <table>
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Descripcion</th>
                        <th>Ver</th>
                        <th>Fecha Limite</th>
                    </tr>
                </thead>
                <tbody id="tareas-tabla"></tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
var token = "{{csrf_token()}}";
var urlPublic = "{{route('safd.alumno.documentos.publicos')}}";
var urlTodos = "{{route('safd.alumno.documentos.todos')}}";
var urlTareas = "{{ route('safd.alumno.documentos.tareas') }}";
$(document).ready(function(){
    $('ul.tabs').tabs();
    $("#publicos").on('click',function(e){
        $.ajax({
            type:'POST',
            url:urlPublic,
            data:{
                _token:token,
            },
            success:function(response){
                var tabla="";
                for(var i=0;i<response.length;i++){
                    tabla+="<tr>";
                    tabla+="<td>"+response[i].id_archivo_a+"</td>";
                    tabla+="<td>"+response[i].nombre+"</td>";
                    tabla+="<td>"+response[i].fecha_subida+"</td>";
                    tabla+="</tr>";
                }
                $("#publicos-tabla").html(tabla);
            }
        });
    });
    $("#todos").on('click',function(e){
        $.ajax({
            type:'POST',
            url:urlTodos,
            data:{
                _token:token,
            },
            success:function(response){
                var tabla="";
                for(var i=0;i<response.length;i++){
                    tabla+="<tr>";
                    tabla+="<td>"+response[i].id_archivo_a+"</td>";
                    tabla+="<td>"+response[i].nombre+"</td>";
                    tabla+="<td>"+response[i].fecha_subida+"</td>";
                    tabla+="</tr>";
                }
                $("#todos-tabla").html(tabla);
            }
        });
    });
    $("#tareas").on('click',function(e){
        $.ajax({
            type:'POST',
            url:urlTareas,
            data:{
                _token:token,
            },
            success:function(response){
                var tabla="";
                for(var i=0;i<response.length;i++){
                    tabla+="<tr>";
                    tabla+="<td>"+response[i].materia+"</td>";
                    tabla+="<td>"+response[i].resumen+"</td>";
                    tabla+="<td>"+response[i].nombre_a+"</td>";
                    tabla+="<td>"+response[i].fecha_limite+"</td>";
                    tabla+="</tr>";
                }
                $("#tareas-tabla").html(tabla);
            }
        });
    });
});
</script>
@endsection