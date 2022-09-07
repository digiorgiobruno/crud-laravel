@extends('layouts.app')
@section('content')
<div class="container">
    @if (Session::has('mensaje'))   
        <div class="alert alert-success" role="alert">
        
            {{ Session::get('mensaje') }}

        </div>
    @endif
    @if (Session::has('error'))   
    <div class="alert alert-danger" role="alert">
    
        {{ Session::get('error') }}

    </div>
    @endif
    
@if (Route::has('register'))
                                
                                    <a class="btn btn-success mb-2" href="{{ route('register') }}">{{ __('Registrar nuevo empleado') }}</a>
                                
                            @endif

{{-- <a href="{{ url('empleado/create') }}" class="btn btn-success mb-2">Registrar nuevo empleado</a>
 --}}
<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            {{-- <th>Foto</th> --}}
            <th>Nombre</th>
            <th>Cuil</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleados as $empleado)
        <tr>
            <td>{{ $empleado->id }}</td>
           {{--  <td>
                <img src="{{ asset("storage").'/'.$empleado->Foto }}" width="100" alt="Imagen usuario" class="img img-responsive">
                </td> --}}
            <td>{{ $empleado->name }}</td>
            <td>{{ $empleado->cuil }}</td>
            <td>{{ $empleado->email }}</td>
            <td> 
                <div class="btn-group btn-group-justified" role="group" aria-label="Basic example">    
                    <a href="{{ url('/empleado/'.$empleado->id.'/edit') }}" class="btn btn-warning">Editar</a> 
                    <form action="{{ url(route('usuarios.getuserinfo')) }}" method="get" class="d-inline">
                        @csrf
                        <input type="hidden" name="cuil" value="{{ $empleado->cuil}}">
                        <input type="submit" value="ver" class="btn btn-primary">   
                    </form>
                    <form action="{{ url('empleado/'.$empleado->id) }}" method="post" class="d-inline">
                        @csrf
                        {{ method_field('DELETE') }}
                        <input type="submit" onclick="return confirm('¿Desea borrar?')" value="Borrar" class="btn btn-danger">   
                    </form> 
                </div>
            </td>
        </tr>  
        @endforeach

        
    </tbody>
</table>
{!! $empleados->links() !!}

</div>
@endsection