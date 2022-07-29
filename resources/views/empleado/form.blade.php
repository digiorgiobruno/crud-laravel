<h1>{{ $modo }} empleado</h1>
<label for="Nombre">Nombre</label>
<input type="text" name='Nombre' value="{{isset($empleado->Nombre)?$empleado->Nombre:''  }}" id="Nombre">
<br>
<label for="Nombre">Apellido</label>
<input type="text" name='Apellido' value="{{ isset($empleado->Apellido)?$empleado->Apellido:''}}" id="Apellido">
<br>
<label for="Nombre">Correo</label>
<input type="text" name='Correo' value="{{ isset($empleado->Correo)?$empleado->Correo:'' }}" id="Correo">
<br>
<label for="Nombre">Foto</label>
{{-- {{ $empleado->Foto }} --}}
@if (isset($empleado->Foto))
<img src="{{ asset("storage").'/'.$empleado->Foto }}" width="100" alt="Imagen usuario">

@endif

<input type="file" name='Foto' value="{{ isset($empleado->Foto)?$empleado->Foto:'' }}" id="Foto">
<br>
<input type="submit" value='{{ $modo }}'>

<a href="{{ url('empleado') }}">Regresar</a>

<br>