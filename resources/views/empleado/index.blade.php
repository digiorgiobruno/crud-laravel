@extends('layouts.app')
@section('content')
<div class="container">
    @if (Session::has('mensaje'))   
        <div class="alert alert-success" role="alert">
        
            {{ Session::get('mensaje') }}

        </div>
    @endif


<a href="{{ url('empleado/create') }}" class="btn btn-success mb-2">Registrar nuevo empleado</a>

<table class="table table-light">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Foto</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($empleados as $empleado)
        <tr>
            <td>{{ $empleado->id }}</td>
            <td>
                <img src="{{ asset("storage").'/'.$empleado->Foto }}" width="100" alt="Imagen usuario" class="img img-responsive">
                </td>
            <td>{{ $empleado->Nombre }}</td>
            <td>{{ $empleado->Apellido }}</td>
            <td>{{ $empleado->Correo }}</td>
            <td> <a href="{{ url('/empleado/'.$empleado->id.'/edit') }}" class="btn btn-warning">Editar</a> | 
                <form action="{{ url('empleado/'.$empleado->id) }}" method="post" class="d-inline">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="submit" onclick="return confirm('¿Desea borrar?')" value="Borrar" class="btn btn-danger">   
                </form>

            </td>
        </tr>  
        @endforeach

        
    </tbody>
</table>
{!! $empleados->links() !!}

</div>
@endsection