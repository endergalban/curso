@extends('layout')

@section('content')
<div class="row">
@panel
  @slot('header')
    <h4>Nuevo usuario</h4>
    @include('shared._errors')
  @endslot
  @slot('body')
    <form class="col s4" action="{{ route('users.store') }}" method="post">
      @include('users._fields')
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
          <a class="waves-effect waves-light btn blue-grey lighten-5  black-text" href="{{ route('users.index')}}">Volver</a>
          <button class="waves-effect waves-light btn">Registrar</button>
        </div>
      </div>
    </form>
  @endslot
@endpanel
</div>
@endsection
