<h1>{{ $modo }} empleado</h1>


@if (Session::has('mensaje'))   
<div class="alert alert-success" role="alert">

    {{ Session::get('mensaje') }}

</div>
@endif

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
<input type="text" name='cuil' value="{{ isset($empleado->cuil)?$empleado->cuil:''}}" id="cuil" class="form-control" disabled>
<div>
<div class="form-group">   
<label for="Nombre">Correo</label>
<input type="text" name='email' value="{{ isset($empleado->email)?$empleado->email:'' }}" id="email" class="form-control" disabled>
<div>
<div class="form-group">   
     
@if ($empleado->cuil ==  Auth::user()->cuil && $opcion='pass') 
<label for="password" class="">{{ __('Password') }}</label>  
<input id="password" type="password" class="form-control" name="password" autocomplete="new-password">  
<label for="password-confirm" class="">{{ __('Confirm Password') }}</label>
<input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
@endif
<input type="hidden" name="img" id="img-del" value="{{ isset($empleado->img)?$empleado->img:'' }}"/>
<div class="slim mt-2 center"
     style="border-radius: 300px; width: 300px; margin-bottom:20px"
     data-label="Imagen de perfil"
     data-size="340,340"
     data-ratio="1:1">
        <input type="file" name="slim"/>
        @if (isset($empleado->img))
        <img src="{{ asset("storage").'/'.$empleado->img }}" alt="Imagen usuario" >
        @endif
</div>

</div>
    
</div>
<div class="form-group">

 <input type="submit" value='{{ $modo }}' class="btn btn-success form-control mb-1">
<a href="{{ url('empleado') }}" class="btn btn-primary form-control">Regresar</a>
</div>
<br>

@section('js')


    <!-- Scripts -->
    <script src="{{ asset('/js/slim.kickstart.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            function deleteImg() {
                        document.getElementById('img-del').value=''; 
                    }
               
              const b = document.querySelector('button[title=Remove]').addEventListener("click", deleteImg);
    
            });  
    </script>

@endsection