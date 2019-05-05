@extends('layout')

@section('content')
<div class="row">
   <div class="col s12">
      <h4>Editar usuario [{{ $user->name }}]</h4>
      @if ($errors->any())
        <p>Corrija los errores</p>
      @endif
   </div>
   <form class="col s4" action="{{ route('users.update', $user) }}" method="post">
      {{ csrf_field() }}
      {{ method_field('PUT') }}
     <div class="row">
       <div class="input-field col s12">
         <i class="material-icons prefix">account_circle</i>
         <input id="name" type="text" class="validate" name="name"  value="{{ old('name', $user->name) }}">
         <label for="name">Nombre</label>
         @if ($errors->has('name'))
         <span class="helper-text">{{ $errors->first('name') }}</span>
         @endif
       </div>
     </div>
     <div class="row">
       <div class="input-field col s12">
         <i class="material-icons prefix">email</i>
         <input id="email" type="email" class="validate" name="email" value="{{ old('email', $user->email) }}">
         <label for="email">email</label>
         @if ($errors->has('email'))
         <span class="helper-text">{{ $errors->first('email') }}</span>
         @endif
       </div>
     </div>
     <div class="row">
       <div class="input-field col s12">
          <a class="waves-effect waves-light btn blue-grey lighten-5  black-text" href="{{ route('users.index')}}">Volver</a>
          <button class="waves-effect waves-light btn">Actualizar</button>
       </div>
     </div>
   </form>
 </div>
@endsection
