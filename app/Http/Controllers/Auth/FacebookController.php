<?php

namespace App\Http\Controllers\Auth;

use Cookie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Socialite;
use App\User;
use App\Model\User\UserRatingHistory;
use App\Library\Users\UserRating;
use App\Library\Users\Notification;
use Auth;
use Image;


class FacebookController extends Controller
{
	public function redirectToProvider()
	{
		return Socialite::driver('facebook')->stateless()->redirect();
	}

	/**
	 * Obtain the user information from GitHub.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function handleProviderCallback(Request $request)
	{
		if (!$request->has('code') || $request->has('denied')) {
			return redirect('/');}
			
		$FBuser = Socialite::driver('facebook')->stateless()->user();
		
		//Log::debug(strval($FBuser));
		if(Auth::check()){
			$user = Auth::user();
			if(
			User::where([
				['facebook_token',$FBuser->id],
				['id','<>',$user->id],
			])
				->first()
			){
				return view('message',[
					'message'	=>	trans('page_message.acaunt_is_busy')
				]);
			}else{
				if(empty($user->facebook_token)){
					UserRating::addAction('social_network',$user);
				}
				$user->facebook_token = $FBuser->id;
				$user->save();
				Notification::send('social_binding',$user);
				return redirect()->route('user.setting');
			}
		}else{
			return $this->newUser($FBuser,$request);
		}
	}

	protected function newUser($FBuser,$request){
		$user = User::when($FBuser->email,function ($usr) use ($FBuser){
			$usr->where('email',$FBuser->email);
		})
			->orWhere('facebook_token',$FBuser->id)
			->first();

		if(isset($user)){
			if(empty($user->facebook_token)){
				$user->facebook_token = $FBuser->id;
				UserRating::addAction('social_network',$user);
			}
		}else{
			$user = new User();
			$user->email = $FBuser->email ?? null;
			$user->password = 'empty';
			if(User::when($FBuser->nickname,function ($usr) use ($FBuser){
				$usr->where('name',$FBuser->nickname);
			})->first()){
				$user->name = time();
			}else{
				$user->name = $FBuser->nickname ?? time();
			}

			$nameData = explode(' ',$FBuser->name);
			if(count($nameData) > 0){
				$user->first_name = $nameData[0];
			}
			if(count($nameData) > 1){
				$user->first_name = $nameData[1];
			}
			$user->status_id = 1;
			$user->current_rating = 0;
			$user->rang_id = 1;

			if($FBuser->avatar_original){
				$filename = time().'.jpg';
				Image::make($FBuser->avatar_original)->fit (250, 250)->save( public_path('/uploads/images/avatars/' . $filename ) );
				$user->avatar = $filename;
			}

			$user->facebook_token = $FBuser->id;
			$user->save();
			$user->makeExployee('user');

			UserRating::addAction('register',$user);
			UserRating::addAction('social_network',$user);
			if(isset($FBuser->email)){
				UserRating::addAction('email',$user);
			}
			if($request->hasCookie('ref_id')){
				$ref_owner = User::find(Cookie::get('ref_id'));
				UserRating::addAction('friend',$ref_owner);
			}

		}

		UserRating::addAction('authorization',$user);
		Auth::login($user, true);

		return redirect()->route('user.cabinet');
	}
}
