@extends('safd.template.main')

@section('title','Catalogo Preguntas')

@section('content')
<div class="container">
    <div class="row">
        <div class="col s6">
            {!! Form::open(['route' => 'safd.profesor.catalogo.preguntas.create', 'method' => 'POST']) !!}
            <h5>Agregar Preguntas</h5>
            <div class="input-field col s12">
                <select class="select" name="materia" required>
                    @foreach($grupos as $grupo)
                    <option value="{{$grupo->materia}}">{{$grupo->materia}}</option>
                    @endforeach
                </select>
                <label>Materia</label>
            </div>
            <div class="input-field col s12">
                <select class="select" name="unidad" required>
                    @for($i=1;$i<13;$i++)
                    <option value="Unidad {{$i}}">Unidad {{$i}}</option>
                    @endfor
                </select>
                <label>Unidad</label>
            </div>
            <div class="input-field col s12">
                <input placeholder="pregunta?" name="pregunta" type="text" class="validate" required>
                <label for="first_name">Pregunta</label>
            </div>
            <div class="input-field col s9">
                <input placeholder="Respuesta" name="res1" type="text" class="validate">
                <label for="first_name">Respuesta 1:</label>
            </div>
            <div class="input-field col s3">
                <input name="num1" type="number" value="0" min="0" class="validate">
            </div>
            <div class="input-field col s9">
                <input placeholder="Respuesta" name="res2" type="text" class="validate">
                <label for="first_name">Respuesta 2:</label>
            </div>
            <div class="input-field col s3">
                <input name="num2" type="number" value="0" min="0" class="validate">
            </div>
            <div class="input-field col s9">
                <input placeholder="Respuesta" name="res3" type="text" class="validate">
                <label for="first_name">Respuesta 3:</label>
            </div>
            <div class="input-field col s3">
                <input name="num3" type="number" value="0" min="0" class="validate">
            </div>
            <div class="input-field col s9">
                <input placeholder="Respuesta" name="res4" type="text" class="validate">
                <label for="first_name">Respuesta 4:</label>
            </div>
            <div class="input-field col s3">
                <input name="num4" type="number" value="0" min="0" class="validate">
            </div>
            <div class="input-field col s9">
                <input placeholder="Respuesta" name="res5" type="text" class="validate">
                <label for="first_name">Respuesta 5:</label>
            </div>
            <div class="input-field col s3">
                <input name="num5" type="number" value="0" min="0" class="validate">
            </div>
            <button class="btn" type="submit">Agregar</button>
            {!! Form::close() !!}
        </div>
        <div class="col s6">
            <div id="cat">
                <h5>Preguntas Agregadas</h5>
                <nav>
                    <div class="nav-wrapper red darken-4">
                        <a href="#!" class="brand-logo">Materia</a>
                        <ul class="right hide-on-med-and-down">
                            <!-- Dropdown Trigger -->
                            <?php $i=1; ?>
                            @foreach($grupos as $grupo)
                            <li><a class="dropdown-button" href="#!" data-activates="dropdown{{$i}}">{{$grupo->materia}} <i class="material-icons right">arrow_drop_down</i></a></li>
                            <?php $i++; ?>
                            @endforeach
                        </ul>
                        <?php $i2=1; ?>
                        @foreach($grupos as $grupo)
                        <ul id="dropdown{{$i2}}" class="dropdown-content">
                            @for($i=1;$i<13;$i++)
                                 <li class="unimat" data-unidad="Unidad {{$i}}" data-materia="{{$grupo->materia}}"><a href="#!">Unidad {{$i}}</a></li>
                            @endfor
                        </ul>
                        <?php $i2++; ?>
                        @endforeach
                    </div>
                </nav>
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Pregunta:</th>
                        </tr>
                    </thead>
                    
                    <tbody id="data-table"></tbody>
                </table>
            </div>
            <div id="edit" style="display:none;">
                {!! Form::open(['route' => 'safd.profesor.catalogo.preguntas.update', 'method' => 'POST', 'id' => 'update']) !!}
                    <h5>Preguntas Agregadas</h5>
                    <input type="hidden" name="idPregunta" id="idPregunta"/>
                    <input type="hidden" name="rfc" id="rfc"/>
                    <input type="hidden" name="materiaV" id="materiaV"/>
                    <input type="hidden" name="unidadV" id="unidadV"/>
                    <div class="input-field col s12">
                        <select class="select" name="materia" required id="materia">
                            @foreach($grupos as $grupo)
                            <option value="{{$grupo->materia}}">{{$grupo->materia}}</option>
                            @endforeach
                        </select>
                        <label>Materia</label>
                    </div>
                    <div class="input-field col s12">
                        <select class="select" name="unidad" required id="unidad">
                            @for($i=1;$i<13;$i++)
                            <option value="Unidad {{$i}}">Unidad {{$i}}</option>
                            @endfor
                        </select>
                        <label>Unidad</label>
                    </div>
                    <div class="input-field col s12">
                        <input placeholder="pregunta?" id="pregunta" name="pregunta" type="text" class="validate" required>
                        <label for="first_name">Pregunta</label>
                    </div>
                    <div class="input-field col s9">
                        <input id="pre1" name="pre1" type="hidden">
                        <input placeholder="Respuesta" id="res1" name="res1" type="text" class="validate">
                        <label for="first_name">Respuesta 1:</label>
                    </div>
                    <div class="input-field col s3">
                        <input id="num1" name="num1" type="number" value="0" min="0" class="validate">
                    </div>
                    <div class="input-field col s9">
                        <input id="pre2" name="pre2" type="hidden">
                        <input placeholder="Respuesta" id="res2" name="res2" type="text" class="validate">
                        <label for="first_name">Respuesta 2:</label>
                    </div>
                    <div class="input-field col s3">
                        <input id="num2" name="num2" type="number" value="0" min="0" class="validate">
                    </div>
                    <div class="input-field col s9">
                        <input id="pre3" name="pre3" type="hidden">
                        <input placeholder="Respuesta" id="res3" name="res3" type="text" class="validate">
                        <label for="first_name">Respuesta 3:</label>
                    </div>
                    <div class="input-field col s3">
                        <input id="num3" name="num3" type="number" value="0" min="0" class="validate">
                    </div>
                    <div class="input-field col s9">
                        <input id="pre4" name="pre4" type="hidden">
                        <input placeholder="Respuesta" id="res4" name="res4" type="text" class="validate">
                        <label for="first_name">Respuesta 4:</label>
                    </div>
                    <div class="input-field col s3">
                        <input id="num4" name="num4" type="number" value="0" min="0" class="validate">
                    </div>
                    <div class="input-field col s9">
                        <input id="pre5" name="pre5" type="hidden">
                        <input placeholder="Respuesta" id="res5" name="res5" type="text" class="validate">
                        <label for="first_name">Respuesta 5:</label>
                    </div>
                    <div class="input-field col s3">
                        <input id="num5" name="num5" type="number" value="0" min="0" class="validate">
                    </div>
                    <button class="btn return" type="button">Regresar</button> <button class="btn" type="submit">Modificar</button>
                {!! Form::close() !!}
            </div>
            <div id="exito" style="display:none;">
                <h5>Pregunta Actualizada Correctamente</h5>
                <button class="btn return" type="button">Regresar a la Tabla</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on("click",".pregunta",function(e){
            e.preventDefault();
            var rfc = $(this).data("rfc");
            var unidad = $(this).data("unidad");
            var materia = $(this).data("materia");
            var idPregunta = $(this).data("id-pregunta");
            var pregunta = $(this).data("pregunta");
            var token = "{{csrf_token()}}";
            var url = "{{route('safd.profesor.catalogo.pregunta')}}";
            $.ajax({
                type:'POST',
                url:url,
                data:{
                    _token:token,
                    unidad:unidad,
                    rfc:rfc,
                    materia:materia,
                    idPregunta:idPregunta,
                },
                success:function(response){
                    for(var i=0;i<response.length;i++){
                        var data=response[i];
                        if(i==0){
                            $("#pre1").val(data.id_res_pre);
                            $("#res1").val(data.respuesta);
                            $("#num1").val(data.valor);
                        }else if(i==1){
                            $("#pre2").val(data.id_res_pre);
                            $("#res2").val(data.respuesta);
                            $("#num2").val(data.valor);
                        }else if(i==2){
                            $("#pre3").val(data.id_res_pre);
                            $("#res3").val(data.respuesta);
                            $("#num3").val(data.valor);
                        }else if(i==3){
                            $("#pre4").val(data.id_res_pre);
                            $("#res4").val(data.respuesta);
                            $("#num4").val(data.valor);
                        }else if(i==4){
                            $("#pre5").val(data.id_res_pre);
                            $("#res5").val(data.respuesta);
                            $("#num5").val(data.valor);
                        }
                    }
                    $("#unidad").val(unidad);
                    $("#materia").val(materia);
                    $("#unidadV").val(unidad);
                    $("#materiaV").val(materia);
                    $('#unidad').material_select();
                    $('#materia').material_select();
                    $("#pregunta").val(pregunta);
                    $("#idPregunta").val(idPregunta);
                    $("#rfc").val(rfc);
                    $("#cat").hide();
                    $("#exito").hide();
                    $("#edit").show();
                }
        	}); 
        });
        $(document).on("submit","#update",function(e) {
            e.preventDefault();
            var token = "{{csrf_token()}}";
            var url = "{{route('safd.profesor.catalogo.preguntas.update')}}";
            var data = $(this).serialize();
            $.ajax({
                type:'POST',
                url:url,
                data:data,
                success:function(response){
                    if(response==true){
                        $("#cat").hide();
                        $("#edit").hide();
                        $("#data-table").html("");
                        $("#exito").show();
                    }
                }
        	}); 
        });
        $(document).on("click",".return",function(e){
            e.preventDefault();
            $("#cat").show();
            $("#edit").hide();
            $("#exito").hide();
        });
        $(".unimat").on("click",function(e){
            e.preventDefault();
            var unidad = $(this).data('unidad');
            var materia = $(this).data('materia');
            var token = "{{csrf_token()}}";
            var url = "{{route('safd.profesor.catalogo')}}";
            $.ajax({
                type:'POST',
                url:url,
                data:{
                    _token:token,
                    unidad:unidad,
                    materia:materia,
                },
                success:function(response){
                    $("#data-table").html(response);
                }
        	}); 
        });
    });
</script>
@endsection