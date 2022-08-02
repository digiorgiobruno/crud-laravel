<h1>{{ $modo }} empleado</h1>

@if(count($errors)>0)

<div class="alert alert-danger" role="alert">
    <ul>
        
            @foreach($errors->all() as $error)
            <li>   {{ $error}} </li>   
            @endforeach
                
        
    </ul>

</div>
@endif


<div class="form-group">
<label for="Nombre">Nombre</label>
<input type="text" name='Nombre' value="{{isset($empleado->Nombre)?$empleado->Nombre:''  }}" id="Nombre" class="form-control">
</div>
<div class="form-group">
<label for="Nombre">Apellido</label>
<input type="text" name='Apellido' value="{{ isset($empleado->Apellido)?$empleado->Apellido:''}}" id="Apellido" class="form-control">
<div>
<div class="form-group">   
<label for="Nombre">Correo</label>
<input type="text" name='Correo' value="{{ isset($empleado->Correo)?$empleado->Correo:'' }}" id="Correo" class="form-control">
<div>
<div class="form-group">    
<label for="Nombre"></label>
{{-- {{ $empleado->Foto }} --}}
@if (isset($empleado->Foto))
<img src="{{ asset("storage").'/'.$empleado->Foto }}" width="100" alt="Imagen usuario" class="img-thumbnail img-fluid">

@endif

</div>
<div class="form-group">
<input type="file" name='Foto' value="{{ isset($empleado->Foto)?$empleado->Foto:'' }}" id="Foto" class="form-control mt-2 mb-2">
<input type="submit" value='{{ $modo }}' class="btn btn-success form-control mb-1">

<a href="{{ url('empleado') }}" class="btn btn-primary form-control">Regresar</a>
</div>
<br>