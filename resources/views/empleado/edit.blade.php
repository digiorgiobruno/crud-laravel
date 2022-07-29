este formulario es para editar
<form action="{{ url('/empleado/'.$empleado->id) }}" method="post" enctype="multipart/form-data">
@csrf
{{ method_field('PATCH') }}
@include('empleado.form',['modo'=>'Editar']);

</form>