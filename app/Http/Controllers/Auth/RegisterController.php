<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
        $numero=(User::count());
        if($numero>0)
            $this->middleware('auth');
        else
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
            'usuario' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'apellido' => ['required', 'string'],
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
        /*
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        */
        //Hay que consultar si ya hay usuarios en la BD, si no entonces el primer usuario seré el admin
        //Después solo el admin podrá registrar usuarios, por lo cual solo el podrá ver la página

        $numero=(User::count());
        if($numero==0)
            $admin=1;
        else
            $admin=0;

        return User::create([
            //En realidad el campo email es usado para almacenar un usuario
            //Lo dejo con ese nombre para evitarme problemas
            'usuario' => $data['usuario'],
            'name' => $data['name'],
            'apellido' => $data['apellido'],
            'admin' => $admin,
            'password' => Hash::make($data['password']),
        ]);
    }
}
