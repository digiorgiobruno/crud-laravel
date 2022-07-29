Mostrar la lista de empleados
@if (Session::has('mensaje'))
    {{ Session::get('mensaje') }}
@endif

<a href="{{ url('empleado/create') }}">Registrar nuevo empleado</a>

<table class="table table-dark">
    <thead class="thead-dark">
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
                <img src="{{ asset("storage").'/'.$empleado->Foto }}" width="100" alt="Imagen usuario">
                </td>
            <td>{{ $empleado->Nombre }}</td>
            <td>{{ $empleado->Apellido }}</td>
            <td>{{ $empleado->Correo }}</td>
            <td> <a href="{{ url('/empleado/'.$empleado->id.'/edit') }}">Editar</a> | 
                <form action="{{ url('empleado/'.$empleado->id) }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}
                    <input type="submit" onclick="return confirm('¿Desea borrar?')" value="Borrar">   
                </form>

            </td>
        </tr>  
        @endforeach

        
    </tbody>
</table>