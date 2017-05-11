@extends('safd.template.main')

@section('title','Consultar Examen')

@section('content')

            <div class="container">
                 {!! Form::open(['route' => 'safd.profesor.enviarDatosConsultaExamen', 'method' => 'POST', 'id'=>'enviarDatosConsultaExamen'])  !!}
                        <h4>CONSULTAR</h4> 
                        <div class="row">
                            <div class="input-field">
                            <select class="select" name="selectOpcion" id="selectOpcion">
                              <option value="" selected>Escoge</option>
                              <option value="1">Pasados</option>
                              <option value="2">Inactivos</option>
                              <option value="3">Todos</option>
                            </select>
                            <label>Opcion</label>
                          </div>
                          <div class="input-field">
                            <select class="select" name="selectMateria" id="selectMateria">
                               @foreach($grupos as $grupo)
                              <option value="{{$grupo->materia}}">{{$grupo->materia}}</option>
                            @endforeach
                            </select>
                            <label>Materia</label>
                          </div>
                          <div class="container" id="capaTarea" style="display:none;">
                            <div class="row">
                              <div class="input-field">
                                <select class="select" name="selectGrupo" id="selectGrupo">
                            @foreach($materias as $materia)
                                      <option value="{{$materia->grupo}}">{{$materia->grupo}}</option>
                                @endforeach
                                </select>
                                <label>Grupos</label>
                              </div>
                            </div>
                            </div>
                        </div>
                    <button class="btn" name="btnConsultar" type="submit">Consultar</button>
                      {!! Form::close() !!}
                </div>
                
                <div class="container" name="capa">
                        <h4>CONSULTAR ALUMNOS</h4> 
                        <div class="row">
                         <table>
                        <thead>
                          <tr>
                              <th>No</th>
                              <th>Unidad</th>
                              <th>Fecha Inicio</th>
                              <th>Fecha Fin</th>
                          </tr>
                        </thead>
                
                        <tbody id="info">
                        
                         
                          
                        </tbody>
                       
                      </table>
                        </div>
                </div>
     @endsection
@section('script')
<script type="text/javascript">
     $(".btnConsultar").on("click",function(){
		  $("#capa").show();
    });
     $("#selectMateria").change(function(){
            if($(this).val()!=""){
              	$("#capaTarea").show();
            }
     });
     $(document).on("submit","#enviarDatosConsultaExamen",function(e) {
            e.preventDefault();
            var token = "{{csrf_token()}}";
            var url = "{{route('safd.profesor.enviarDatosConsultaExamen')}}";
            var data = $(this).serialize();
            $.ajax({
                type:'POST',
                url:url,
                data:data,
                success:function(response){
                     var content="";
                 for(i=0;i<response[0].length;i++){
                     response[0][i].id_pro_exa;
                     response[0][i].unidad;
                     response[0][i].fecha_ini;
                     response[0][i].fecha_fin;
                        content+="<tr>";
                        content+="<td>"+response[0][i].id_pro_exa+"</td>";
                        content+="<td>"+response[0][i].unidad+"</td>";
                        content+="<td>"+response[0][i].fecha_ini+"</td>";
                        content+="<td>"+response[0][i].fecha_fin+"</td>";
                        content+="</tr>";
                 }
                  for(i=0;i<response[1].length;i++){
                     response[1][i].id_pro_exa;
                     response[1][i].unidad;
                     response[1][i].fecha_ini;
                     response[1][i].fecha_fin;
                        content+="<tr>";
                        content+="<td>"+response[1][i].id_pro_exa+"</td>";
                        content+="<td>"+response[1][i].unidad+"</td>";
                        content+="<td>"+response[1][i].fecha_ini+"</td>";
                        content+="<td>"+response[1][i].fecha_fin+"</td>";
                        content+="</tr>";
                }
                  $('#info').html(content);
                
            }
        	}); 
        });
</script>
@endsection