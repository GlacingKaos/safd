<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        if(!\Auth::guest() && \Auth::user()->profesor()){
            return redirect()->route('safd.profesor.index');
        }elseif(!\Auth::guest() && \Auth::user()->alumno()){
            return redirect()->route('safd.alumno.index');
        }else{
            return view('safd.index');
        }
    }
}
