<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Library\Users\UserRating;
use Carbon;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/cabinet/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

	/**
	 * The user has been authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
		switch($user->status_id){
			case 5:{
				$this->guard()->logout();
				return view('message',[
					'message'	=>	trans('page_message.not_verify_message')
				]);
			}
			case 1:
			case 2:
			case 3:
			case 4:
				if(Carbon::now()->subMinutes(15)->gt(new Carbon($user->last_active))){
					UserRating::addAction('authorization', $user);
				}
				break;
			/*
				return redirect()->route('user.ban');
				break;*/
		}

	}
	
}
