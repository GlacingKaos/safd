@extends('safd.template.main')

@section('title','Sistema')

@section('content')

<div class="container">
      <h4>PROGRAMAR EXAMENES</h4> 
        <div class="row">
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
          <div class="input-field">
                <select class="select" name="selectUnidad" id="selectUnidad">
                 <option value="unidad1">Unidad 1</option>
                 <option value="unidad2">Unidad 2</option>
                 <option value="unidad3">Unidad 3</option>
                 <option value="unidad4">Unidad 4</option>
                 <option value="unidad5">Unidad 5</option>
                 <option value="unidad6">Unidad 6</option>
                 <option value="unidad7">Unidad 7</option>
                 <option value="unidad8">Unidad 8</option>
                 <option value="unidad9">Unidad 9</option>
                 <option value="unidad10">Unidad 10</option>
                 <option value="unidad11">Unidad 11</option>
                 <option value="unidad12">Unidad 12</option>
                 </select>
                <label>Materia</label>
              </div>
              <div class="input-field">
                    <textarea class="materialize-textarea"  name="descripcion" id="descripcion"/></textarea>
                    <label for="descripcion">Descripcion</label>
                </div>
                <label for="cantidadP">Cantidad Preguntas</label>
                <input id="cantidadP" name="cantidadP" type="number" class="validate" style="width:40px;" min=0 max=23><br>
                <label for="fechaIn">Fecha Inicio</label>
                <input id="fechaIn" name="fechaIni" type="date" class="validate"  style="width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input id="horas" name="horasI" type="number" placeholder="HH" class="validate" style="width:40px;" min=0 max=23>
                <input id="minutos" name="minutosI" type="number" placeholder="MM" class="validate" style="width:40px;" min=0 max=60>
                <input id="segundos" name="segundosI" type="number" placeholder="SS" class="validate" style="width:40px;" min=0 max=60><br>
                <label for="fechaFin">Fecha Fin</label>
                <input id="fechaFin" name="fechaFin" type="date" class="validate"  style="width:200px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input id="horasF" name="horas" type="number" placeholder="HH" class="validate" style="width:40px;" min=0 max=23>
                <input id="minutosF" name="minutos" type="number" placeholder="MM" class="validate" style="width:40px;" min=0 max=60>
                <input id="segundosF" name="segundos" type="number" placeholder="SS" class="validate" style="width:40px;" min=0 max=60><br>
                <label for="duracion">Duracion</label>
                <input id="horasD" name="horas" type="number" placeholder="HH" class="validate" style="width:40px;" min=0 max=23>
                <input id="minutosD" name="minutos" type="number" placeholder="MM" class="validate" style="width:40px;" min=0 max=60>
                <input id="segundosD" name="segundos" type="number" placeholder="SS" class="validate" style="width:40px;" min=0 max=60><br>
                <input class="with-gap" name="activar" type="radio" id="activar" unchecked />
                <label for="activar">Activar</label>
         </div>
    </div>
    <div class="container">
      <h4>Selecionar Alumnos</h4> 
        <div class="row">
               <table>
                <thead>
                  <tr>
                      <th>Name</th>
                      <th>Item Name</th>
                      <th>Item Price</th>
                  </tr>
                </thead>
        
                <tbody>
                  <tr>
                    <td>Jonathan</td>
                    <td>Lollipop</td>
                    <td>$7.00</td>
                  </tr>
                </tbody>
              </table>
         </div>
    </div>
@endsection
@section('script')
<script type="text/javascript">
     $("#selectMateria").change(function(){
            if($(this).val()!=""){
              	$("#capaTarea").show();
            }
     });
</script>
@endsection