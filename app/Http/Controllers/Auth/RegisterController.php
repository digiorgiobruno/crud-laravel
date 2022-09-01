<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\DB;;

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

        //Sobreescribo el metodo register para poder desactivar el login automatico luego del registro 
        /**
         * Handle a registration request for the application.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function register(Request $request)
        {   

            $datos = DB::connection('sqlsrv')->table('USERINFO')->select( 'USERINFO.NAME','USERINFO.SSN')
            ->where('USERINFO.SSN', $this->cuilFormat($request->cuil));
            /* dump($datos);
            dd($request->cargar);  */
            
            if($datos->count()>0){
                
                if(isset($request->cargar)){ 
                    $datos=$datos->first();
                    $datos->CUIL=str_replace("-","",$datos->SSN);
                    $datos->SURNAME=trim(explode(",", $datos->NAME)[0]);
                    $datos->NAME=trim(explode(",", $datos->NAME)[1]);
                    $datos->PASSWORD=Hash::make($datos->CUIL);//hacemos un hash con el cuil
                    $dat['datos'] = $datos;
                    return view('auth.register',$dat);
                 //   return redirect('/register')->with("datos",$dat);
                }
         
                $this->validator($request->all())->validate();
                event(new Registered($user = $this->create($request->all())));
                if(isset($user)){$mensaje='Usuario creado con exito, revisar mail para validar.';
                    return $this->registered($request, $user)
                    ?: redirect('/register')->with("mensaje",$mensaje);
                }
                
            }else{
                $mensaje='CUIL no presente en el sistema.';
            }
            //$this->guard()->login($user); //evitamos login automatico
            return redirect('/register')->with("error",$mensaje);//$this->redirectPath());
           
        }



    
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
        /* $this->middleware('guest'); */
        $this->middleware('auth');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
       /*  return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'cuil' => [ 'required','same:cuil_confirmation', 'string', 'size:11', 'unique:users', 'confirmed'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]); */
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:25'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'cuil' => [ 'required', 'string', 'size:11', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'cuil' => $data['cuil'],
            'password' => Hash::make($data['password']),
        ]);
    }

    function cuilFormat($cuil){
            $ultimo=substr($cuil, -1);
            $primeros=substr($cuil,0, 2);
            $medio=substr($cuil, -9, 8);
            $cuil=$primeros."-".$medio."-".$ultimo;
        return $cuil;
    }


    
}
