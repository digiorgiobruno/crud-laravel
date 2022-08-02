@extends('layouts.app')
@section('content')
<div class="container">

<form action="{{ url('/empleado') }}" method="post" enctype="multipart/form-data">
{{-- llave de seguridad csrf para que el sistema sepa 
    que estos ingresando al sistema  desde un 
    formulario del sistema --}}
@csrf
@include('empleado.form',['modo'=>'Crear']);

</form>


</div>
@endsection