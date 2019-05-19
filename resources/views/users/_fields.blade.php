{{ csrf_field() }}
<div class="row">
  <div class="input-field col s12">
    <i class="material-icons prefix">account_circle</i>
    <input id="name" type="text" name="name"  value="{{ old('name', $user->name) }}">
    <label for="name">Nombre</label>
    @if ($errors->has('name'))
    <span class="helper-text" >{{ $errors->first('name') }}</span>
    @endif
  </div>
</div>
<div class="row">
  <div class="input-field col s12">
    <i class="material-icons prefix">email</i>
    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}">
    <label for="email">Email</label>
    @if ($errors->has('email'))
    <span class="helper-text" >{{ $errors->first('email') }}</span>
    @endif
  </div>
</div>
<div class="row">
  <div class="input-field col s12">
    <select id="profession_id" name="profession_id" class="browser-default">
      <option value="" disabled selected>Choose your option</option>
      @foreach($professions as $profession )
        <option value="{{ $profession->id }}" {{$profession->id == old('profession_id', $user->profile->profession_id) ? 'selected' : ''}}>{{ $profession->title }}</option>
      @endforeach
    </select>
  </div>
</div>
<div class="row">
  <div class="input-field col s12">
    <i class="material-icons prefix">account_circle</i>
    <input id="twitter" type="text" name="twitter"  value="{{ old('twitter', $user->profile->twitter) }}">
    <label for="twitter">Twitter</label>
    @if ($errors->has('twitter'))
      <span class="helper-text" >{{ $errors->first('twitter') }}</span>
    @endif
  </div>
</div>
<div class="row">
  <div class="input-field col s12">
    <i class="material-icons prefix">mode_edit</i>
    <textarea id="bio"  name="bio" class="materialize-textarea">{{ old('twitter', $user->profile->bio) }}</textarea>
    <label for="bio">Bio</label>
    @if ($errors->has('bio'))
      <span class="helper-text" >{{ $errors->first('bio') }}</span>
    @endif
  </div>
</div>
<div class="input-field col s12">
  <h5>Habilidades</h5>
</div>
<div class="row">
  <div class="input-field col s12">
    @foreach ($skills as $key => $skill)
      <div class="col s3">
        <label>
          <input type="checkbox"
            name="skills[{{$skill->id}}]"
            class="filled-in"
            value="{{$skill->id}}"
            {{old("skills.{$skill->id}") ? 'checked' : ''}}
          />
          <span>{{$skill->name}}</span>
        </label>
      </div>
    @endforeach
  </div>
  <div class="input-field col s12">
    <h5>Roles</h5>
  </div>
  <div class="row">
    <div class="input-field col s12">
      @foreach ($roles as $role => $name)
        <div class="col s4">
          <label>
            <input class="with-gap" name="role" type="radio" value="{{$role}}"
              {{old("role") == $role ? 'checked' : ''}} />
            <span>{{$name}}</span>
          </label>
        </div>
      @endforeach
    </div>
  </div>
