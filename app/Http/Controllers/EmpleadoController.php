<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;//clase que tiene elementos necesarios para manejo de archivos
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

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
        //
        //$empleado=new Empleado();
        //$empleado->Nombre='';
     /*    $empleado->Apellido='';
        $empleado->Foto='';
        $empleado->Correo='';
        $empleado->Id=''; */
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
            'Foto'=>'required|max:10000|mimes:jpeg,png,jpg'
        ];
        $mensajes=[
        'required'=>'El :attribute es requerido',
        'Foto.required'=>'La foto es requerida'
        
        ];
        $this->validate($request,$campos,$mensajes);
        //---------------
        $datosEmpleado= request()->except('_token');
        if($request->hasFile('Foto')){
            //si hay un archivo llamado foto lo copiamos en storage 
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
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
    public function show(Empleado $empleado)
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'cuil' => [ 'required', 'string', 'size:11', 'unique:users'],
            
        ];
        $mensajes=[
        'required'=>'El :attribute es requerido',        
        ];

        if($request->hasFile('Foto')){
            $campos=['Foto'=>'required|max:10000|mimes:jpeg,png,jpg'];
            $mensajes=['Foto.required'=>'La foto es requerida'];
        }
        $this->validate($request,$campos,$mensajes);

        $datosEmpleado= request()->except(['_token','_method']);

        if($request->hasFile('Foto')){
            $empleado=User::findOrFail($empleado->id);
            Storage::delete('public/'.$empleado->Foto);
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }

        User::where('id','=',$empleado->id)->update($datosEmpleado);

        $empleado=User::findOrFail($empleado->id);
        //return view('empleado.edit',compact('empleado'));

        return redirect('empleado')->with("mensaje",'Empleado modificado');
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
        /* if(Storage::delete('public/'.$empleado->Foto)){
            User::destroy($empleado->id);
        } */
        if($empleado->id== Auth::user()->id){
            return redirect('empleado')->with("mensaje",'No puedes borrar tu propio usuario.');
        }
        User::destroy($empleado->id);
        return redirect('empleado')->with("mensaje",'Empleado borrado');
        //
    }
}
