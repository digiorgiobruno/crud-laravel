<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;//clase que tiene elementos necesarios para manejo de archivos
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Classes\Slim;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //dump(Auth::user()->roles[0]->role);
        //Gate::authorize('create-user');
        //autorizacion
        if (Gate::denies('create-user')) {
            return redirect('/usuarios');
        }

        $datos['empleados']=User::paginate(4);
        //return $datos;
        return view('empleado.index',$datos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('empleado.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validaciones
        $campos=[
            'name'=>'required|string|max:100',
            'surname'=>'required|string|max:100',
            'email'=>'required|email',
            'img'=>'required|max:10000|mimes:jpeg,png,jpg'
        ];
        $mensajes=[
        'required'=>'El :attribute es requerido',
        'img.required'=>'La foto es requerida'
        ];
        $this->validate($request,$campos,$mensajes);
        //---------------
        $datosEmpleado= request()->except('_token');
        if($request->hasFile('img')){
            //si hay un archivo llamado img lo copiamos en storage 
            $datosEmpleado['img']=$request->file('img')->store('uploads','public');
        }
        Empleado::insert($datosEmpleado);
        //return response()->json($datosEmpleado);
        return redirect('empleado')->with("mensaje",'Empleado agregado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(User $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function edit(User $empleado)
    {
        //
        if (Gate::denies('create-user')&&$empleado->id != Auth::user()->id) {
            return redirect('/usuarios');
        } 
        $empleado=User::findOrFail($empleado->id);
        return view('empleado.edit',compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $empleado)
    {   
      
         //Validaciones
         $campos=[
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:25'],
        ];
        $mensajes=[
        'required'=>'El :attribute es requerido',

        ];
        //$opcion='';
        if($empleado->id== Auth::user()->id && isset($request->password)){ 
            $campos=[
                 'password' => ['string', 'min:8', 'confirmed'], 
            ];
            $datosEmpleado= request()->except(['_token','_method','slim','password_confirmation']);
            $datosEmpleado['password']=Hash::make($request->password);
            //$opcion=$request->get('opcion');
        }else{
            $datosEmpleado= request()->except(['_token','_method','slim','password_confirmation','password']);
        }
      
        $this->validate($request,$campos,$mensajes);

        $mensajes="Request ".$request->img." Empleado->img ".$empleado->img;
        $name='';//$request->img=='' &&
         if( $empleado->img!=''){
            $name=$empleado->img;
        }
        if($name==''){
            $name = md5(uniqid() . time()) . '.' . 'png';
        }
   
        if (isset(Slim::getImages()[0]))
        {
            $image = Slim::getImages()[0];

                if (isset($image['output']['data'])){
                    $data = $image['output']['data'];
                    $path = base_path() . '/storage/app/public/img';
                    $file = Slim::saveFile($data, $name, $path,false);
                    $datosEmpleado['img']=$file['name']; 
                }
        }else{

            if (!$request->img && $empleado->img!= null ){
                $path = base_path() . '/storage/app/public/img/'.$empleado->img;
                unlink($path);
                //Storage::delete($urlImg);
                $datosEmpleado['img'] = null;
            }
        }

         
        
        User::where('id','=',$empleado->id)->update($datosEmpleado);

        $empleado=User::findOrFail($empleado->id);
        
        $datos['empleado']=$empleado;
        $datos['mensaje']=$mensajes;//'Modificado.';
        return redirect()->route('empleado.edit',  $empleado)->with("mensaje",$datos['mensaje']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $empleado)
    {
        $empleado=User::findOrFail($empleado->id);
         if(Storage::delete('public/'.$empleado->img)){
            User::destroy($empleado->id);
        } 
        if($empleado->id== Auth::user()->id){
            return redirect('empleado')->with("mensaje",'No puedes borrar tu propio usuario.');
        }
        User::destroy($empleado->id);
        return redirect('empleado')->with("mensaje",'Empleado borrado');
        //
    }
}
