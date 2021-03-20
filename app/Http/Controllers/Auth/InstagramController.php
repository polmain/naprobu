<?php

namespace App\Http\Controllers\Auth;

use Cookie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\User;
use App\Model\User\UserRatingHistory;
use App\Library\Users\UserRating;
use App\Library\Users\Notification;
use Auth;
use Image;

class InstagramController extends Controller
{
	public function redirectToProvider()
	{
		return Socialite::driver('instagram')->stateless()->redirect();
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

		$instagramUser = Socialite::driver('instagram')->stateless()->user();
		if(Auth::check()){
			$user = Auth::user();
			if(
				User::where([
				['instagram_token',$instagramUser->id],
				['id','<>',$user->id],
				])
				->first()
			){

				return view('message',[
					'message'	=>	trans('page_message.acaunt_is_busy')
				]);

			}else{
				if(empty($user->instagram_token)){
					UserRating::addAction('social_network',$user);
				}
				$user->instagram_token = $instagramUser->id;
				$user->save();
				Notification::send('social_binding',$user);
				return redirect()->route('user.setting');
			}

		}else{
			return $this->newUser($instagramUser,$request);
		}
	}



	protected function newUser($instagramUser,$request){
		$user = User::when($instagramUser->email,function ($usr) use ($instagramUser){
			$usr->where('email',$instagramUser->email);
		})
			->orWhere('instagram_token',$instagramUser->id)
			->first();

		if(isset($user)){
			if(empty($user->instagram_token)){
				$user->instagram_token = $instagramUser->id;
				UserRating::addAction('social_network',$user);
			}
		}else{
			$user = new User();
			$user->email = $instagramUser->email ?? null;
			$user->password = 'empty';
			if(User::when($instagramUser->nickname,function ($usr) use ($instagramUser){
				$usr->where('name',$instagramUser->nickname);
			})->first()){
				$user->name = time();
			}else{
				$user->name = $instagramUser->nickname ?? time();
			}


			$nameData = explode(' ',$instagramUser->name);
			if(count($nameData) > 0){
				$user->first_name = $nameData[0];
			}
			if(count($nameData) > 1){
				$user->last_name = $nameData[1];
			}

			$user->status_id = 1;
			$user->current_rating = 0;
			$user->rang_id = 1;

			if($instagramUser->avatar){
				$filename = time().'.jpg';
				Image::make($instagramUser->avatar)->fit (250, 250)->save( public_path('/uploads/images/avatars/' . $filename ) );
				$user->avatar = $filename;
			}

			$user->instagram_token = $instagramUser->id;
			$user->save();
			$user->makeExployee('user');

			UserRating::addAction('register',$user);
			UserRating::addAction('social_network',$user);
			if(isset($instagramUser->email)){
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
