<?php

namespace App\Http\Controllers\Auth;

use App;
use App\Entity\EmploymentEnum;
use App\Entity\WorkEnum;
use App\Http\Controllers\Auth\EmailVerification;
use App\Model\Geo\City;
use App\Model\Geo\Region;
use App\Model\User\UserChild;
use Cookie;
use App\Library\Users\UserRating;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class ExpertRegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'sex' => $data['sex'],
            'password' => Hash::make($data['password']),
            'status_id' => 5,
            'current_rating' => 0,
            'rang_id' => 1,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'patronymic' => $data['patronymic'],
            'birsday' => $data['birsday'],
            'nova_poshta_city' => isset($data['nova_poshta_city_name']) ? $data['nova_poshta_city_name'] : null,
            'nova_poshta_warehouse' => isset($data['nova_poshta_warehouse']) ? $data['nova_poshta_warehouse'] : null,
            'education' => $data['education'],
            'employment' => $data['employment'],
            'family_status' => $data['family_status'],
            'has_child' => $data['has_child'],
            'material_condition' => $data['material_condition'],
            'hobbies' => $data['hobbies'] ?? [],
            'hobbies_other' => $data['hobbies_other'],
        ]);
        return $user;
    }
    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $country_id = $request->country_id;
        $user->country_id = $country_id;

        $region_id = $request->region_id !== 'other' ? $request->region_id : null;
        if($request->new_region != ""){
            $region = new Region();
            $region->name = $request->new_region;
            $region->lang = 'ru';
            $region->rus_lang_id = 0;
            $region->country_id = $country_id;
            $region->is_verify = false;
            $region->save();

            $region_id = $region->id;
        }
        $user->region_id = $region_id;

        $city_id = $request->city_id;
        if($request->new_city != ""){
            $city = new City();
            $city->name = $request->new_city;
            $city->lang = 'ru';
            $city->rus_lang_id = 0;
            $city->country_id = $country_id;
            $city->region_id = $region_id;
            $city->is_verify = false;
            $city->save();

            $city_id = $city->id;
        }
        $user->city_id = $city_id;
        $user->new_form_status = true;

        if(EmploymentEnum::getInstance($request->employment)->isWork()){
            $user->work = $request->work;
        }

        $user->save();

        if ($request->has_child) {
            foreach ($request->child_birthday as $childBirth) {
                $date = new \Carbon\Carbon($childBirth);
                $child = $user->children->where('birthday', $date->format('Y-m-d'))->first();
                if (!$child) {
                    $child = new UserChild();
                    $child->birthday = $date;
                    $child->user_id = $user->id;
                    $child->save();
                }
            }
        }

        $this->user_rating($user);
        $user->makeExployee('expert');
        EmailVerification::sendVerifyCode($user);

        if($request->hasCookie('ref_id')){
            $ref_owner = User::find(Cookie::get('ref_id'));
            UserRating::addAction('friend',$ref_owner);
        }

        $this->guard()->logout();
        return view('message',[

            'header'	=>	'Благодарим за регистрацию.',
            'message'	=>	'На ваш email: '.$user->email.' было высланно письмо с активационной ссылкой. Пожалуйста перейдите на неё для завершения процедуры регистрации.'
        ]);
    }

    protected function user_rating($user){
        UserRating::addAction('register',$user);
        UserRating::addAction('email',$user);
    }
}
