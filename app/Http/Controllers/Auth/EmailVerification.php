<?php

namespace App\Http\Controllers\Auth;

use App;
use App\Services\LanguageServices\AlternativeUrlService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\User\EmailVerify;

class EmailVerification extends Controller
{
	public static function sendVerifyCode(User $user){
		$user->email_verefy_code = str_random(30);
		$user->save();
		Mail::to($user)->send(new EmailVerify($user));
	}

    public function verify($user_id,$verify_code){
		$user = User::find($user_id);

		$locale = App::getLocale();

        $routes = AlternativeUrlService::generateReplyRoutes('/verify/'.$user_id.'/'.$verify_code.'/');

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($locale, $routes);

		if(empty($user)){
			return view('message',[
				'message'	=>	trans('page_message.user_not_found_message'),
				'alternativeUrls' => $alternativeUrls
			]);
		}
		App::setlocale($user->lang);

        $alternativeUrls = AlternativeUrlService::getAlternativeUrls($user->lang, $routes);

		$this->middleware('menu');
		if($user->status_id != 5){
			return view('message',[
				'message'	=>	trans('page_message.already_verify_message'),
				'alternativeUrls' => $alternativeUrls
			]);
		}
		if($user->email_verefy_code == $verify_code){
			$user->status_id = 1;
			$user->save();
			return view('message',[
				'header'	=>	trans('page_message.thankyou_email_header'),
				'message'	=>	trans('page_message.thankyou_email_message'),
				'alternativeUrls' => $alternativeUrls
			]);
		}else{
			static::sendVerifyCode($user);
			return view('message',[
				'header'	=>	trans('page_message.cod_not_valid_header'),
				'message'	=>	trans('page_message.cod_not_valid_message',['email' => $user->email]),
				'alternativeUrls' => $alternativeUrls
			]);
		}
	}
}
