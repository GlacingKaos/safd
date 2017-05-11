<div class="navbar-fixed">
  <nav class='red darken-4'>
    <div class="nav-wrapper">
      <a href="#!" class="brand-logo">
        @if(!Auth::guest() && Auth::user()->type==1)
          @yield('name')
        @else
          Instituto Tecnologico de Morelia
        @endif
      </a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      @if (Auth::guest())
        <ul class="right hide-on-med-and-down">
          <li><a href="{{ route('login') }}">Ingresar</a></li>
        </ul>
      @elseif(Auth::user()->type==0)
        <ul class="right hide-on-med-and-down">
          <li><a href="{{ route('safd.profesor.index') }}">Inicio</a></li>
          <li><a href="{{ route('safd.profesor.documentos.documentos') }}">Documentos</a></li>
          <li><a href="{{ route('safd.profesor.mensajes.IndexMensajes') }}">Mensajes</a></li>
          <li><a href="#!" class="dropdown-button" data-activates='exam'>Exámenes</a></li>
          <li><a href="{{ route('safd.logout') }}">Salir</a></li>
        </ul>
        <ul id='exam' class='dropdown-content'>
          <li><a href="{{ route('safd.profesor.catalogo.preguntas') }}">Catalogo de preguntas</a></li>
          <li><a href="{{ route('safd.examenes.consultar.consultarExamenes') }}">Consultar examenes</a></li>
          <li><a href="#!">Programar examen</a></li>
        </ul>
      @elseif(Auth::user()->type==1)
        <ul class="right hide-on-med-and-down">
          <li><a href="{{ route('safd.alumno.index') }}">Inicio</a></li>
          <li><a href="#!" class="dropdown-button" data-activates='documentos'>Documentos</a></li>
          <li><a href="#!" class="dropdown-button" data-activates='mensajes'>Mensajes</a></li>
          <li><a href="#!" class="dropdown-button" data-activates='examenes'>Exámenes</a></li>
          <li><a href="{{ route('safd.logout') }}">Salir</a></li>
        </ul>
        <ul id='documentos' class='dropdown-content'>
          <li><a href="{{ route('safd.alumno.documentos.subir') }}">Subir Documento</a></li>
          <li><a href="{{ route('safd.alumno.documentos') }}">Mis Documentos</a></li>
        </ul>
        <ul id='mensajes' class='dropdown-content'>
          <li><a href="{{ route('safd.alumno.mensajes.crearmensajes') }}">Nuevo Mensaje</a></li>
          <li><a href="#!">Mensajes Recibidos</a></li>
          <li><a href="#!">Mensajes Enviados</a></li>
        </ul>
        <ul id='examenes' class='dropdown-content'>
          <li><a href="#!">Exámenes Activos y Pasados</a></li>
          <li><a href="#!">Calificaciones</a></li>
        </ul>
      @endif
    </div>
  </nav>
</div>