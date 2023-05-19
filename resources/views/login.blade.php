@extends('layouts.template')

@section('app-content')
    <div class="d-flex justify-content-center">
        <div class="col-5">
            <div class="card mt-5">
                {{-- Header --}}
                <div class="card-header">
                    <h3 class="text-center my-2">Inicio de sesión</h3>
                </div>
                {{-- Body --}}
                <div class="card-body">
                    @component('components.form', ['action' => route('login')])
                        @component('components.input', [
                            'name' => 'email',
                            'required' => true,
                            'type' => 'email',
                            'nombre' => 'Correo',
                        ])
                        @endcomponent

                        @component('components.input', [
                            'name' => 'password',
                            'required' => true,
                            'type' => 'password',
                            'nombre' => 'Contraseña',
                        ])
                        @endcomponent

                        <div class="col form-group">
                            @include('components.error')
                        </div>

                        <div class="d-flex justify-content-center">
                            <button class="btn btn-primary" type="submit">Entrar</button>
                        </div>
                    @endcomponent
                </div>
                {{-- Footer --}}
                <div class="card-footer text-center">
                    <small>
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}">Registrate</a>
                    </small>
                </div>
            </div>
        </div>
    </div>
@endsection