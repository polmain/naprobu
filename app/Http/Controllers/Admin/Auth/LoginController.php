<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

class LoginController extends Controller
{
	use AuthenticatesUsers;
	protected $redirectTo = '/admin';
	protected $redirectAfterLogout = '/admin/login';
	public function __construct()
	{
		$this->middleware('guest')->except('logout');
	}
	public function showLoginForm()
	{
		return view('admin.auth.login');
	}
}

