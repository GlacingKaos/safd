@extends('safd.template.main')

@section('title','Sistema')

@section('content')
<div class="container">
    @if (Auth::guest())
    {!! Form::open(['route' => 'safd.login', 'method' => 'POST']) !!}
        <div class="row">
            <div class="input-field col s6">
                <input placeholder="User" id="user" name="user" type="text" class="validate" required>
                <label for="user">Usuario</label>
            </div>
            <div class="input-field col s6">
                <input placeholder="***************" id="password" name="password" type="password" class="validate" required>
                <label for="password">Contraseña</label>
            </div>
            <div class="input-field col s12">
                <select name="type" class="select" required>
                    <option></option>
                    <option value="1">profesor</option>
                    <option value="2">alumno</option>
                </select>
                <label>Tipo</label>
            </div>
        </div>
        <button class="btn" type="submit">Inciar</button>
    {!! Form::close() !!}
    @else 
        <h1>Bienvenido</h1>
    @endif
</div>
@endsection