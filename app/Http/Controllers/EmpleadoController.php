<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;//clase que tiene elementos necesarios para manejo de archivos

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
        $datos['empleados']=Empleado::paginate(2);
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
            'Nombre'=>'required|string|max:100',
            'Apellido'=>'required|string|max:100',
            'Correo'=>'required|email',
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
    public function edit(Empleado $empleado)
    {
        //
        $empleado=Empleado::findOrFail($empleado->id);
        return view('empleado.edit',compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Empleado $empleado)
    {
        //


         //Validaciones
         $campos=[
            'Nombre'=>'required|string|max:100',
            'Apellido'=>'required|string|max:100',
            'Correo'=>'required|email',
            
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
            $empleado=Empleado::findOrFail($empleado->id);
            Storage::delete('public/'.$empleado->Foto);
            $datosEmpleado['Foto']=$request->file('Foto')->store('uploads','public');
        }

        Empleado::where('id','=',$empleado->id)->update($datosEmpleado);

        $empleado=Empleado::findOrFail($empleado->id);
        //return view('empleado.edit',compact('empleado'));

        return redirect('empleado')->with("mensaje",'Empleado modificado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empleado $empleado)
    {
        $empleado=Empleado::findOrFail($empleado->id);
        if(Storage::delete('public/'.$empleado->Foto)){
            Empleado::destroy($empleado->id);
        }

        return redirect('empleado')->with("mensaje",'Empleado borrado');
        //
    }
}
