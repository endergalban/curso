@extends('layout')

@section('content')
  <div class="row">
    <div class="col s12">
       <h4>Mostrando el usuario [{{ $user->name }}]</h4>
    </div>
    <div class="col s12">
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">account_circle</i>
          <input id="name" type="text" disabled name="name"  value="{{ $user->name }}">
          <label for="name">Nombre</label>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <i class="material-icons prefix">email</i>
          <input id="email" type="email" disabled name="email" value="{{ $user->email }}">
          <label for="email">email</label>
        </div>
      </div>
    </div>
    <div class="col s1">
      <a class="waves-effect waves-light btn" href="{{ route('users.index') }}">Volver</a>
    </div>
  </div>
@endsection
