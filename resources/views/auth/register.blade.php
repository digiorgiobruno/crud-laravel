@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Registrar usuario') }}</div>

                <div class="card-body">
                    {{-- Zona de mensajes --}}
                    @if (Session::has('error'))   
                        <div class="alert alert-danger" role="alert">
                        
                            {{ Session::get('error') }}

                        </div>
                    @endif
                    @if (Session::has('mensaje'))   
                        <div class="alert alert-success" role="alert">
                        
                            {{ Session::get('mensaje') }}
                
                        </div>
                    @endif
                    @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <ul>                         
                            @foreach($errors->all(':message') as $error)
                                <li>   {{ $error}} </li>   
                            @endforeach     
                        </ul>
                    </div> 
                    @endif
                    
                {{-- FIN de Zona de mensajes --}}

                    
                    @if (isset($datos)) 

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="cuil" class="col-md-4 col-form-label text-md-end">{{ __('Cuil') }}</label>

                                <div class="col-md-6">
                                    <input id="cuil" type="cuil" class="form-control @error('cuil') is-invalid @enderror " name="cuil" value="{{$datos->CUIL}}"  readonly>

                                    @error('cuil')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="name" class="col-md-4 col-form-label text-md-end" >{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror " name="name" value="{{ $datos->NAME  }}" required  readonly>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="surname" class="col-md-4 col-form-label text-md-end">{{ __('Apellido') }}</label>

                                <div class="col-md-6">
                                    <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror " name="surname" value="{{ $datos->SURNAME  }}" required readonly>

                                    @error('surname')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- <div class="row mb-3">
                                <label for="cuil-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm cuil') }}</label>

                                <div class="col-md-6">
                                    <input id="cuil-confirm" type="cuil" class="form-control" name="cuil_confirmation" required autocomplete="new-cuil">
                                </div>
                            </div> --}}


                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" value="{{ $datos->PASSWORD }}" name="password" required autocomplete="new-password" readonly>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{--<div class="row mb-3">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div> --}}
                        
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    @else
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <div class="row mb-3">
                                <label for="cuil" class="col-md-4 col-form-label text-md-end">{{ __('Cuil') }}</label>
                                <div class="col-md-6">
                                    <input id="cuil" type="cuil" class="form-control @error('cuil') is-invalid @enderror" name="cuil" required autocomplete="new-cuil" size="11" maxlength="11">
                                    <input type="hidden" name="cargar" value="cargar">
                                {{--@error('cuil')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">

                                    <button type="submit" class="btn btn-success">
                                        {{ __('Cargar') }}
                                    </button>
                                
                                </div>
                            </div>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
