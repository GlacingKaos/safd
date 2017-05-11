@extends('safd.template.main')

@section('title','Alumno')

@section('name')
    Instituto Tecnologico de Morelia
@endsection

@section('content')
    <div class="container">
        <h5>Subir Documento</h5>
        {!! Form::open(['route' => 'safd.alumno.documentos.set', 'method' => 'POST', 'files' => true]) !!}
        <div class="input-field">
            <select name="tipo" required class="select">
            <option value="0">Publico</option>
            </select>
            <label>Tipo</label>
        </div>
        <div class="file-field input-field">
            <div class="btn">
                <span>Archivo</span>
                <input type="file" name="file" required>
            </div>
                <div class="file-path-wrapper">
                <input class="file-path validate" type="text">
            </div>
        </div>
        <div class="input-field col s12">
            <textarea id="textarea1" class="materialize-textarea" name="descripcion"></textarea>
            <label for="textarea1">Descripción</label>
        </div>
        <button type="submit" class="btn">Subir Documento</button>
        {!! Form::close() !!}
    </div>
@endsection

@section('script')
<script type="text/javascript">
var token = "{{csrf_token()}}";
$(document).ready(function(){
    
});
</script>
@endsection