@extends('layout')

@section('content')
<div class="row">
  <div class="col s12">
    <h4>Nuevo usuario</h4>
    @if ($errors->any())
    <div class="card-panel white-text red lighten-2">Corrija los errores</div>
    @endif
  </div>
  <form class="col s4" action="{{ route('users.store') }}" method="post">
    {{ csrf_field() }}
    <div class="row">
      <div class="input-field col s12">
        <i class="material-icons prefix">account_circle</i>
        <input id="name" type="text" name="name"  value="{{ old('name') }}">
        <label for="name">Nombre</label>
        @if ($errors->has('name'))
        <span class="helper-text" >{{ $errors->first('name') }}</span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <i class="material-icons prefix">email</i>
        <input id="email" type="email" name="email" value="{{ old('email') }}">
        <label for="email">Email</label>
        @if ($errors->has('email'))
        <span class="helper-text" >{{ $errors->first('email') }}</span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <i class="material-icons prefix">lock_open</i>
        <input id="password" type="password" name="password">
        <label for="password">Password</label>
        @if ($errors->has('password'))
        <span class="helper-text" >{{ $errors->first('password') }}</span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <i class="material-icons prefix">lock_open</i>
        <input id="password_confirmation" type="password" name="password_confirmation">
        <label for="password_confirmation">Confirmar Password</label>
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <i class="material-icons prefix">account_circle</i>
        <input id="twitter" type="text" name="twitter"  value="{{ old('twitter') }}">
        <label for="twitter">Twitter</label>
        @if ($errors->has('twitter'))
        <span class="helper-text" >{{ $errors->first('twitter') }}</span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <i class="material-icons prefix">account_circle</i>
        <textarea id="bio" type="text" name="bio" value="{{ old('bio') }}"></textarea>
        <label for="name">Bio</label>
        @if ($errors->has('bio'))
        <span class="helper-text" >{{ $errors->first('bio') }}</span>
        @endif
      </div>
    </div>
    <div class="row">
      <div class="input-field col s12">
        <a class="waves-effect waves-light btn blue-grey lighten-5  black-text" href="{{ route('users.index')}}">Volver</a>
        <button class="waves-effect waves-light btn">Registrar</button>
      </div>
    </div>
  </form>
</div>
@endsection
