@extends('layouts.app')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
@endsection
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
    
    <form action="{{ url(route('usuarios.getuserinfo')) }}" method="get" >
        @csrf
        <div class="form-group">
          <label for="cuil">Buscar marcas de empleado</label>
          <input type="hidden" name="opcion" value='true'>
          <input type="hidden" name="consulta" value='true'>
          <input class="form-control" id="cuil" name="cuil" aria-describedby="cuilHelp" placeholder="CUIL" size="11" maxlength="11">

          <small id="cuilHelp" class="form-text text-muted">Ingrese CUIL sin guiones.</small>
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

   {{--  <form action="{{ url(route('usuarios.getuserinfo')) }}" method="get" class="d-inline">
        @csrf
        <input type="hidden" name="opcion" value='true'>
        <input type="hidden" name="cuil" value="{{ $empleado->cuil}}">
        <input type="submit" value="ver" class="btn btn-primary">   
    </form>
 --}}

</div>


@section('js')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>


<script>
    $(document).ready(function () {
   
        urlL="{{ asset('/js/dataTables.spanish.json') }}";

        $('#tab-empleados').DataTable({
            lengthMenu:[[10,50,100,-1],[10,50,100,"Todos"]],
            responsive: true,
            ordering: false,
            language: {
            url: urlL} 
        });
    });
</script>
@endsection
@endsection