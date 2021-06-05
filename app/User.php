<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Library\Users\ActiveUser;
use App\Model\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPassword;


class User extends Authenticatable
{
	use Notifiable, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
        'email',
        'phone',
        'lang',
        'password',
        'status_id',
        'current_rating',
        'rang_id',
        'first_name',
        'last_name',
        'patronymic',
        'birsday',
        'country',
        'region',
        'city',
        'sex',
        'nova_poshta_city',
        'nova_poshta_warehouse'
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function reviews(){
		return $this->hasMany('App\Model\Review', 'user_id');
	}

	public function rang(){
		return $this->hasOne('App\Model\User\UserRatingStatus', 'id', 'rang_id');
	}

	public function history(){
		return $this->hasMany('App\Model\User\UserRatingHistory', 'user_id');
	}

	public function requests(){
		return $this->hasMany('App\Model\Project\ProjectRequest', 'user_id');
	}

	public function comments(){
		return $this->hasMany('App\Model\Review\Comment', 'user_id');
	}

	public function roles(){
		return $this->belongsToMany('App\Model\Role','user_roles', 'user_id', 'role_id');
	}

	public function status(){
		return $this->hasOne('App\Model\User\UserStatus','id', 'status_id');
	}

	public function ban(){
		return $this->hasOne('App\Model\User\UserChangeStatuses','user_id', 'id')->orderBy('id','desc');
	}

	public function userNotifications(){
		return $this->hasMany('App\Model\User\UserNotification','user_id')->orderBy('created_at','desc');
	}

	public function presents(){
		return $this->hasMany('App\Model\User\UserPresents','user_id')->orderBy('rang_id','desc');
	}

    public function country_model(){
        return $this->hasOne('App\Model\Geo\Country',  'id','country_id');
    }

    public function region_model(){
        return $this->hasOne('App\Model\Geo\Region',  'id','region_id');
    }

    public function city_model(){
        return $this->hasOne('App\Model\Geo\City','id', 'city_id');
    }

	public function isOnline(){
		return ActiveUser::isOnline($this->last_active);
	}

	public function lastOnline(){
		return ActiveUser::lastActive($this->last_active);
	}

	public function isExployee(){
		$roles = $this->roles->toArray();
		return !empty($roles);
	}

	public function hasRole($check){
		return in_array($check, array_pluck($this->roles->toArray(), "name"));
	}

	private function getIdInArray($array,$terms){
		foreach ($array as $key => $value){
			if($value == $terms){
				return $key+1;
			}
		}
		return false;
	}

	public function makeExployee($title){
		$assigned_roles = array();
		$roles = array_pluck(Role::all()->toArray(),'name');
		switch ($title){
			case 'admin':
				$assigned_roles[] = $this->getIdInArray($roles, 'admin');
			case 'moderator':
				$assigned_roles[] = $this->getIdInArray($roles, 'moderator');
			case 'expert':
				$assigned_roles[] = $this->getIdInArray($roles, 'expert');
			case 'user':
				$assigned_roles[] = $this->getIdInArray($roles, 'user');
				break;
			case 'bloger':
				$assigned_roles[] = $this->getIdInArray($roles, 'bloger');
				$assigned_roles[] = $this->getIdInArray($roles, 'user');
				break;
			default:
				$assigned_roles[] = $this->getIdInArray($roles, 'user');
		}
		$this->roles()->detach();
		$assigned_roles = array_reverse($assigned_roles);
		$this->roles()->attach($assigned_roles);
	}

	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPassword($token));
	}
}
