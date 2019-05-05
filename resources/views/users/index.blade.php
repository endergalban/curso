@extends('layout')

@section('content')
<div class="row">
  <div class="col s12">
    <h4>{{ $title }}</h4>
  </div>
  <div class="col s2 offset-s10">
    <a class="waves-effect waves-light btn" href="{{ route('users.create')}}"><i class="material-icons left">add</i>Nuevo Usuario</a>
  </div>
  <div class="col s12">
    <table class="responsive-table striped highlight">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Email</th>
          <th>Profesión</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($users as $key => $user)
        <tr>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>{{ $user->profession ? $user->profession->title : '' }}</td>
          <td nowrap>
            <form action="{{route('users.destroy', $user)}}" method="post">
              <a class="waves-effect waves-light btn" href="{{ route('users.show',[$user->id]) }}"><i class="material-icons">search</i></a>
              <a class="waves-effect waves-light btn" href="{{ route('users.edit',[$user->id]) }}"><i class="material-icons">edit</i></a>
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button class="waves-effect waves-light btn"><i class="material-icons">delete</i></button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="4">No existen usuarios</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
