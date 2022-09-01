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
<input type="text" name='name' value="{{isset($empleado->name)?$empleado->name:''  }}" id="name" class="form-control">
</div>
<div class="form-group">
    <label for="Apellido">Apellido</label>
    <input type="text" name='surname' value="{{isset($empleado->surname)?$empleado->surname:''  }}" id="surname" class="form-control">
    </div>
<div class="form-group">
<label for="Nombre">Cuil</label>
<input type="text" name='cuil' value="{{ isset($empleado->cuil)?$empleado->cuil:''}}" id="cuil" class="form-control">
<div>
<div class="form-group">   
<label for="Nombre">Correo</label>
<input type="text" name='email' value="{{ isset($empleado->email)?$empleado->email:'' }}" id="email" class="form-control">
<div>
<div class="form-group">    

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