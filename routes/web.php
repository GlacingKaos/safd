<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'IndexController@index')->name('safd.index');
Route::group(['middleware'=>'auth'], function(){
    Route::group(['middleware'=>'profesor','prefix'=>'profesor'], function(){
        Route::get('/', 'ProfesoresController@index')->name('safd.profesor.index');
        Route::post('/guardarInformacionP', 'ProfesoresController@guardarInformacionP')->name('safd.profesor.guardarInformacionP');
        Route::get('/documentos', 'ProfesoresController@enviarDocumento')->name('safd.profesor.documentos.documentos');
        Route::post('/subirDocumentoProfesor', 'ProfesoresController@subirDocumentoProfesor')->name('safd.profesor.subirDocumento');
        Route::get('/mensajes', 'ProfesoresController@indexMensajes')->name('safd.profesor.mensajes.IndexMensajes');
        Route::post('/enviarMensajes', 'ProfesoresController@enviarMensajes')->name('safd.profesor.mensajes.enviarMensajes');
        Route::get('/mostrarmalumnos', 'ProfesoresController@mostrarmalumnos')->name('safd.profesor.mensajes.mostrarmalumnos');
        Route::get('/mostrarmmaestros', 'ProfesoresController@mostrarmmaestros')->name('safd.profesor.mensajes.mostrarmmaestros');
        Route::post('/mostrarmmaterias', 'ProfesoresController@mostrarmmaterias')->name('safd.profesor.mensajes.mostrarmmaterias');
        Route::get('/mostrarenviados', 'ProfesoresController@mostrarenviados')->name('safd.profesor.mensajes.mostrarenviados');
        Route::post('/detallesmensajes', 'ProfesoresController@detallesmensajes')->name('safd.profesor.mensajes.detallesmensajes');
        Route::get('/getgrupos', 'ProfesoresController@getgrupos')->name('safd.profesor.mensajes.getgrupos');
        
        Route::post('/datosConsultaExamen', 'ProfesoresController@consultarExamenes')->name('safd.profesor.enviarDatosConsultaExamen');
        Route::get('/consultarExamen', 'ProfesoresController@datosConsultaExamenes')->name('safd.examenes.consultar.consultarExamenes');
         Route::get('/programarExamen', 'ProfesoresController@programarExamen')->name('safd.examenes.programar.programarExamen');
        
        
        Route::post('/catalogo/pregunta', 'ProfesoresController@catalogoPreguntaGet')->name('safd.profesor.catalogo.pregunta');
        Route::get('/catalogo/preguntas', 'ProfesoresController@catalogoPreguntas')->name('safd.profesor.catalogo.preguntas');
        Route::post('/catalogo/preguntas', 'ProfesoresController@catalogoPreguntasGet')->name('safd.profesor.catalogo');
        Route::post('/catalogo/preguntas/create', 'ProfesoresController@catalogoPreguntasCreate')->name('safd.profesor.catalogo.preguntas.create');
        Route::post('/catalogo/preguntas/update', 'ProfesoresController@catalogoPreguntasUpdate')->name('safd.profesor.catalogo.preguntas.update');
    });
    Route::group(['middleware'=>'alumno','prefix'=>'alumno'], function(){
        Route::get('/', 'AlumnosController@index')->name('safd.alumno.index');
        Route::post('/', 'AlumnosController@profesorInfo')->name('safd.alumno.index.info');
        Route::get('/crearmensajes', 'AlumnosController@crearmensajes')->name('safd.alumno.mensajes.crearmensajes');
        Route::get('/getgrupos', 'AlumnosController@getgrupos')->name('safd.alumno.mensajes.getgrupos');
        Route::post('/enviarMensajes', 'AlumnosController@enviarMensajes')->name('safd.alumno.mensajes.enviarMensajes');
        Route::get('/Mensajesrec', 'AlumnosController@Mensajesrec')->name('safd.alumno.mensajes.Mensajesrec');
        Route::get('/mostrarmalumnos', 'AlumnosController@mostrarmalumnos')->name('safd.alumno.mensajes.mostrarmalumnos');
        Route::get('/mostrarmmaestros', 'AlumnosController@mostrarmmaestros')->name('safd.alumno.mensajes.mostrarmmaestros');
        Route::post('/detallesmensajes', 'AlumnosController@detallesmensajes')->name('safd.alumno.mensajes.detallesmensajes');
        Route::post('/mostrarmmaterias', 'AlumnosController@mostrarmmaterias')->name('safd.alumno.mensajes.mostrarmmaterias');
        Route::get('/mostrarenviados', 'AlumnosController@mostrarenviados')->name('safd.alumno.mensajes.mostrarenviados');
        
        Route::get('/documentos/subir', 'AlumnosController@documentosSubir')->name('safd.alumno.documentos.subir');
        Route::post('/documentos/subir', 'AlumnosController@documentosSet')->name('safd.alumno.documentos.set');
        Route::get('/documentos/', 'AlumnosController@documentos')->name('safd.alumno.documentos');
        Route::post('/documentos/publicos', 'AlumnosController@getDocumentPublicos')->name('safd.alumno.documentos.publicos');
        Route::post('/documentos/todos', 'AlumnosController@getDocumentTodos')->name('safd.alumno.documentos.todos');
        Route::post('/documentos/tareas', 'AlumnosController@getDocumentTareas')->name('safd.alumno.documentos.tareas');
    });
    Route::get('/logout', 'Login_Controller@logout')->name('safd.logout');
});

Route::get('/login', 'Login_Controller@index')->name('login');
Route::post('/login', 'Login_Controller@post_index')->name('safd.login');