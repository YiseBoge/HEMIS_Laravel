<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Institution\Instance;
use App\Models\Institution\Institution;
use App\Models\Institution\InstitutionName;
use App\Traits\Uuids;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Webpatser\Uuid\Uuid;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use Uuids;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'institution_name_id'=>['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        $institution=Institution::where('institution_name_id',$data['institution_name_id'])->first();
        if($institution==null){
            $institution = new Institution();
            $instance=Instance::all()->first();
            //$institution->id=Uuid::generate()->string;
            $institution->institution_name_id = $data['institution_name_id'];
            $institution->instance_id=Uuid::generate()->string;
            $institution->save();
        }

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'institution_id'=>$institution->id,
            'password' => Hash::make($data['password']),
        ]);
    }

    public function getRegistrationForm(){
        $institutions= InstitutionName::pluck('institution_name','id');

        return view('auth.register',compact('id','institutions'));

    }


}
