@extends('layout')

@section('content')
<div class="row">
  @panel
    @slot('header')
      <h4>Editar usuario [{{ $user->name }}]</h4>
      @include('shared._errors')
    @endslot

    @endslot
    @slot('body')
      <form class="col s4" action="{{ route('users.update', $user) }}" method="post">
        {{ method_field('PUT') }}
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        @render('UserFields', ['user' => $user])
        <div class="row">
          <div class="input-field col s12">
            <a class="waves-effect waves-light btn blue-grey lighten-5  black-text" href="{{ route('users.index')}}">Volver</a>
            <button class="waves-effect waves-light btn">Actualizar</button>
          </div>
        </div>
      </form>
    @endslot
  @endpanel
</div>
@endsection
