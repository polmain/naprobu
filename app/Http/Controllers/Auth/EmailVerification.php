<?php

namespace App\Http\Controllers\Auth;

use App;
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

		$lang = ($locale == 'ru')?'ua':'ru';
		//разбиваем на массив по разделителю
		$segments = explode('/', route('auth.verify',[$user_id,$verify_code]));

		//Если URL (где нажали на переключение языка) содержал корректную метку языка
		if (in_array($segments[3], App\Http\Middleware\LocaleMiddleware::$languages)) {
			unset($segments[3]); //удаляем метку
		}

		//Добавляем метку языка в URL (если выбран не язык по-умолчанию)
		if ($lang != App\Http\Middleware\LocaleMiddleware::$mainLanguage){
			array_splice($segments, 3, 0, $lang);
		}

		//формируем полный URL
		$alternet_url = implode("/", $segments);

		if(empty($user)){
			return view('message',[
				'message'	=>	trans('page_message.user_not_found_message'),
				'alternet_url' => $alternet_url
			]);
		}
		App::setlocale($user->lang);
		$this->middleware('menu');
		if($user->status_id != 5){
			return view('message',[
				'message'	=>	trans('page_message.already_verify_message'),
				'alternet_url' => $alternet_url
			]);
		}
		if($user->email_verefy_code == $verify_code){
			$user->status_id = 1;
			$user->save();
			return view('message',[
				'header'	=>	trans('page_message.thankyou_email_header'),
				'message'	=>	trans('page_message.thankyou_email_message'),
				'alternet_url' => $alternet_url
			]);
		}else{
			static::sendVerifyCode($user);
			return view('message',[
				'header'	=>	trans('page_message.cod_not_valid_header'),
				'message'	=>	trans('page_message.cod_not_valid_message',['email' => $user->email]),
				'alternet_url' => $alternet_url
			]);
		}
	}
}
