<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App;

class ModalAjaxController extends Controller
{
    //
	public function login(Request $request){
		App::setLocale($request->lang);

		$email = mb_strtolower($request->email);
		$user = User::where('email',$email)->first();
		if(empty($user)){
			return trans("auth.user_not_found");
		}
		if(!Hash::check($request->password,$user->password)){
			return trans("auth.password_not_valid");
		}
		return 'ok';
	}

	public function register(Request $request){
		App::setLocale($request->lang);

		$email = mb_strtolower($request->email);
		$user = User::where('email',$email)->first();
		if(isset($user)){
			return trans("auth.user_isset_email");
		}
		$user = User::where('name',$request->name)->first();
		if(isset($user)){
			return trans("auth.user_isset_name");
		}

		return 'ok';
	}

	public function isNameRegister(Request $request){
		$name = $request->name;
		$user = User::where('name',$name)->first();
		if(!empty($user)){
			return 'false';
		}
		return "true";
	}

	public function isEmailRegister(Request $request){
		$email = mb_strtolower($request->email);
		$user = User::where('email',$email)->first();
		if(!empty($user)){
			return 'false';
		}
		return "true";
	}
}
