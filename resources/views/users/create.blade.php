@extends('layout')

@section('content')
<div class="row">
   <div class="col s12">
      <h4>Nuevo usuario</h4>
   </div>
   <form class="col s4" action="{{ route('users.store') }}" method="post">
      {{ csrf_field() }}
     <div class="row">
       <div class="input-field col s12">
         <i class="material-icons prefix">account_circle</i>
         <input id="icon_prefix" type="text" class="validate" name="name">
         <label for="icon_prefix">Nombre</label>
       </div>
     </div>
     <div class="row">
       <div class="input-field col s12">
         <i class="material-icons prefix">email</i>
         <input id="icon_prefix" type="email" class="validate" name="email">
         <label for="icon_prefix">Email</label>
       </div>
     </div>
     <div class="row">
       <div class="input-field col s12">
         <i class="material-icons prefix">lock_open</i>
         <input id="icon_prefix" type="password" class="validate" name="password">
         <label for="icon_prefix">Password</label>
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
