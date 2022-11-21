<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//Needed to overwrite register
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
        //Auth::check() && Auth::user()->admin == 1
        
        if($numero>0)
        {
            $this->middleware("auth");
            $this->middleware(function ($request, $next) {  
                if (Auth::user()->admin == 0) {
                    return redirect("/home");
                }
                    return $next($request);
                });
            //$this->middleware('auth');
            /*if(Auth::user()->admin == 0){
                return redirect("/");
            }*/
        }
        /*
        if(Auth::check())
        {
            dd("hola");
            if(Auth::user()->admin == 0)
                return redirect("/");
        }*/
        //dd("hola, ya estas autentificado");
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
            'email'=>['email','max:255'],
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

        if(isset($data['email']))
            $email=$data['email'];
        else
            $email=NULL;

        User::create([
            //En realidad el campo email es usado para almacenar un usuario
            //Lo dejo con ese nombre para evitarme problemas
            'usuario' => $data['usuario'],
            'email' => $email,
            'name' => $data['name'],
            'apellido' => $data['apellido'],
            'admin' => $admin,
            'password' => Hash::make($data['password']),
        ]);
    }


    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        $user = User::latest()->first();
        if(!Auth::check())
            $this->guard()->login($user);

        if ($response = $this->registered($request, $user)) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 201)
                    : redirect($this->redirectPath());
    }
}
