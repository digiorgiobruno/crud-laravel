Formulario de creacion de empleado

<form action="{{ url('/empleado') }}" method="post" enctype="multipart/form-data">
{{-- llave de seguridad csrf para que el sistema sepa 
    que estos ingresando al sistema  desde un 
    formulario del sistema --}}
@csrf
@include('empleado.form',['modo'=>'Crear']);

</form>