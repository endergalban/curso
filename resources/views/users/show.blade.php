@extends('layout')

@section('content')
  <div class="row">
    <div class="col s12">
        <h4>Mostrando el usuario {{ $user->name }}</h4>
        <p>Nombre: {{$user->name}}</p>
        <p>Correo Electrónico: {{$user->email}}</p>
    </div>
    <div class="col s12">
      <a class="waves-effect waves-light btn" href="{{ route('users.index') }}">Volver</a>
    </div>
  </div>
@endsection
