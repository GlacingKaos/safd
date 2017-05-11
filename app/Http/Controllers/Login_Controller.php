<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Alumno;
use App\Personal;

class Login_Controller extends Controller
{
    protected $redirectTo = '/';
    public function index(){
        return view('safd.index');
    }
    public function post_index(Request $request){
	    $id="0";
	    if($request->type=='1'){//profesor
	        $user = Personal::where('nombre_user',$request->user)->where('password',$request->password)->first();
	        if($user!=null){
	            $id = $user->id_user;
	        }
	    }elseif($request->type=='2'){//alumno
	        $user = Alumno::where('nombre_user',$request->user)->where('password',$request->password)->first();
	        if($user!=null){
	            $id = $user->id_user;
	        }
	    }
		if(Auth::loginUsingId($id, true)){
		    return redirect()->route('safd.index');
		}else{
		    return redirect()->route('login');
		}
	}
	public function logout(){
	    Auth::logout();
	    return redirect()->route('login');
	}
}
