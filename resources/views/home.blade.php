@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bienvenido a UserApp</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                    @if(auth()->user()->role !== 'user')
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">Abrir Gestión de Usuarios</a>
                    @endif                     
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
