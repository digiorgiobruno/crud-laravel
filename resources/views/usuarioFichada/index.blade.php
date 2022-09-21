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
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="opcion" value="1" id="flexCheckDefault" {{isset($opcion)&&$opcion==false?'checked':''}}>
                <label class="form-check-label" for="flexCheckDefault">
                  Vista sin detalles
                </label>
              </div>
        </div>

    </div>
   

</form>
@if (count($fichadas)>0)

   
    <table id ="tab-fichadas"   class="table table-striped  responsive nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Fecha</th>
                @if (!$opcion)
                    <th>Hora</th>
                @else
                    <th>Brecha horaria</th>
                    <th>Condición</th>
                    <th>Total</th>
                @endif
            </tr>
        </thead>

        <tbody>
           @if (!$opcion)
                @foreach ($fichadas as $fichada)
                <tr>
                    <td>{{ date("d/m/Y",strtotime($fichada->CHECKTIME)) }}</td> 
                    <td>{{ date("H:i:s",strtotime($fichada->CHECKTIME))}}</td>      
                    {{-- <td>{{ isset($fichada->cartel)?$fichada->cartel:'' }}</td>
                    <td>{{ isset($fichada->total)?$fichada->total:'' }}</td>  --}}       
                </tr>  
                @endforeach
           @else
                @foreach ($fichadas as $fichada)
                <tr class="{{'table-'.$fichada->tipo}}">
                    <td>{{ date("d/m/Y",strtotime($fichada->CHECKTIME)) }}</td> 
                    <td> @foreach ( array_reverse($fichada->HORA) as $key => $hora)
                        @if ((count($fichada->HORA)-1) == $key)
                            {{ $hora }} 
                        @else
                            {{ $hora.' -' }} 
                        @endif
                        @endforeach 
                    </td>
                    
                    <td>{{ isset($fichada->cartel)?$fichada->cartel:'' }}</td>
                    <td>{{ isset($fichada->total)?$fichada->total:'' }}</td>        
                </tr>  
                @endforeach
           @endif 
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

