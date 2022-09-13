@extends('layouts.app')
@section('content')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/b-2.2.3/r-2.3.0/datatables.min.css"/>

@endsection

<div class="container">
        @if (Session::has('mensaje'))   
        <div class="alert alert-success" role="alert">
    
        {{ Session::get('mensaje') }}

        </div>
        @endif
@if (count($fichadas)>0)
    <ul class="list-group"> 
        <li class="list-group-item"><span>Nombre: </span>{{ $fichadas[0]->NAME }}</li>
        <li class="list-group-item"><span>Cuil: </span>{{ $fichadas[0]->SSN }}</li>
        <li class="list-group-item"><span>Área: </span>{{ $fichadas[0]->TITLE }}</li>
        <li class="list-group-item"><span>Total fichadas registradas:</span> {{ count($fichadas)  }}</li>
    </ul>
@endif
      

       
        
      
<form action="{{ url('usuarios') }}" method="GET">
    @csrf

  <div class="form-group mb-2">

        <div class="row input-daterange mt-2">
            <div class="col-md-4">
                <label for="from_date">Desde</label>
                <input type="date" name="from_date" id="from_date" class="form-control" placeholder="From Date" value="{{isset($from_date)?$from_date:'' }}" />
            </div>
            <div class="col-md-4">
                <label for="to_date">Hasta</label>
                <input type="date" name="to_date" id="to_date" class="form-control" placeholder="To Date" value="{{isset($to_date)?$to_date:'' }}" />
            </div>
          
        </div>
        
        <div class="col-md-4 mt-2">
            @if (isset($cuil))
                <input type="hidden" name="cuil" value="{{$cuil}}">
            @endif
            
            <input type='submit' name="Filtrar" value='Filtrar' class='btn btn-primary'/>
            <input type='submit' name="Limpiar" value='Limpiar' class='btn btn-default'/>

        </div>

    </div>
   

</form>
@if (count($fichadas)>0)

   
    <table id ="tab-fichadas"   class="table table-striped  responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                {{-- <th>Tipo</th> --}}
            </tr>
        </thead>

        <tbody>

            @foreach ($fichadas as $fichada)
           {{--  @php
                if ($fichada->CHECKTYPE=='O'){ $clase='table-warning'; $tipo='Salída';}
                elseif ($fichada->CHECKTYPE=='I'){$clase='table-info'; $tipo='Entrada';}
            @endphp
            
            <tr class='{{ $clase }}'> --}}
            <tr>
                <td>{{ date("d/m/Y",strtotime($fichada->CHECKTIME)) }}</td> 
                <td>{{ date("H:i:s",strtotime($fichada->CHECKTIME))}}</td>      
                {{-- <td>{{ $tipo }}</td>  --}}     
            </tr>  
            @endforeach

            
        </tbody>
    </table>
    
    @else
        <div class="alert alert-success" role="alert">
           {{ $mensaje }}

        </div>
    @endif
</div>
    @section('js')

        <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/b-2.2.3/r-2.3.0/datatables.min.js"></script>

        <script>
            urlL="{{ asset('/js/dataTables.spanish.json') }}";
            $(document).ready(function () {
                $('#tab-fichadas').DataTable({           
                    lengthMenu:[[10,50,100,-1],[10,50,100,"Todos"]],
                    ordering: false,
                    language: {
                        url: urlL},
                    responsive: true 
                });
            });
        </script>
    @endsection
@endsection

