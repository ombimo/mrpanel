@extends('mrpanel::_layout.public')

@section('content')

<div class="login-box">
  <div class="login-box__body px-5 py-4">
    <form action="{{ route('mrpanel.login') }}" method="post">
      {{ csrf_field() }}
      {{ mrpanel_get_alert(session('mrpanel.alert')) }}
      <div class="form-group">
        <label for="fl-user">Username</label>
        <input type="text" class="form-control" id="fl-user" placeholder="username" name="username" value="{{ old('username') }}" required>
      </div>
      <div class="form-group">
        <label for="fl-pass">Password</label>
        <input type="password" class="form-control" id="fl-pass" placeholder="Password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</div>

@endsection
