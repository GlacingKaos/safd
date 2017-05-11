@extends('safd.template.main')

@section('title','Sistema')

@section('content')
    <div class="container">
        <div class="row center">
            <h3>Informacion personal<h3>
        </div>
        <div class="row">
            {!! Form::open(['route' => 'safd.profesor.guardarInformacionP', 'method' => 'POST', 'files' => true]) !!}
            <div class="file-field input-field">
                <div class="btn">
                    <span>Foto</span>
                    <input type="file" name="file">
                </div>
                    <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" placeholder="Si desea cambiar la foto seleccione un archivo, en caso contrario dejese en blanco" />
                </div>
            </div>
            <div class="input-field">
                <input type="text" name="nombre" id="nombre" value="{{ $datos->nombre }}"/>
                <label for="nombre">Nombre</label>
            </div>
            <div class="input-field">
                <input type="email" name="correo" id="correo" value="{{ $datos->correo }}"/>
                <label for="correo">Correo</label>
            </div>
            <div class="input-field">
                <input type="text" name="telefono" id="telefono" value="{{ $datos->telefono }}"/>
                <label for="telefono">Telefono</label>
            </div>
            <div class="input-field">
                <textarea class="materialize-textarea"  name="curriculum" id="curriculum"/>{{ $datos->curriculum }}</textarea>
                <label for="curriculum">Curriculum</label>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="center">
                <button class="btn">Guardar</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection