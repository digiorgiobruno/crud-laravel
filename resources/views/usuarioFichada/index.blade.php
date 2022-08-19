@extends('layouts.app')
@section('content')
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
@endsection
<div class="container">
        @if (Session::has('mensaje'))   
        <div class="alert alert-success" role="alert">
    
        {{ Session::get('mensaje') }}

        </div>
        @endif

    <ul class="list-group"> 
        <li class="list-group-item"><span>Nombre: </span>{{ $fichadas[0]->NAME }}</li>
        <li class="list-group-item"><span>Cuil: </span>{{ $fichadas[0]->SSN }}</li>
        <li class="list-group-item"><span>Área: </span>{{ $fichadas[0]->TITLE }}</li>
        <li class="list-group-item"><span>Total fichadas registradas:</span> {{ count($fichadas)  }}</li>
      </ul>

      

       
        
      
<form action="{{ url('usuarios') }}" method="GET">
    @csrf
    

       {{--  <label for="date_started">Fecha Desde</label>
        <input id="date_started" class="form-control" type="date" name="date_started">
        <label for="date_finish">Fecha Hasta</label>
        <input id="date_finish" class="form-control" type="date" name="date_finish"> --}}
  <div class="form-group mb-2">

        <div class="row input-daterange mt-2">
            <div class="col-md-4">
                <label for="from_date">Desde</label>
                <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
            </div>
            <div class="col-md-4">
                <label for="to_date">Hasta</label>
                <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
            </div>
          
        </div>
        
        <div class="col-md-4 mt-2">

            
            <input type='submit' name="Filtrar" value='Filtrar' class='btn btn-primary'/>
            <input type='submit' name="Limpiar" value='Limpiar' class='btn btn-default'/>

        </div>

    </div>
   

</form>

<table id ="tab-fichadas" class="table table-light shadow-lg">
    <thead class="thead-light">
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Tipo</th>
        </tr>
    </thead>

    <tbody>

        @foreach ($fichadas as $fichada)
        @php
            if ($fichada->CHECKTYPE=='O'){ $clase='table-warning'; $tipo='Salída';}
            elseif ($fichada->CHECKTYPE=='I'){$clase='table-info'; $tipo='Entrada';}
        @endphp
        
        <tr class='{{ $clase }}'>
            <td>{{ date("d/m/Y",strtotime($fichada->CHECKTIME)) }}</td> 
            <td>{{ date("H:i:s",strtotime($fichada->CHECKTIME))}}</td>      
            <td>{{ $tipo }}</td>      
        </tr>  
        @endforeach

        
    </tbody>
</table>
{{-- {!! $fichadas->links() !!} --}}

</div>
    @section('js')
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function () {
                $('#tab-fichadas').DataTable({
                    lengthMenu:[[10,50,100,-1],[10,50,100,"Todos"]],
                    ordering: false,
                });
            });
        </script>
    @endsection
@endsection