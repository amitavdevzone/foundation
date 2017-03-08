@extends('inferno-foundation::guest-template')

@section('content')
  <div class="login-box-body">
    <p class="login-box-msg">Hell awaits you... login to enter.</p>

    <form action="{{route('login')}}" method="post">
      {{csrf_field()}}
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" name="email" tabindex="1">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <div class="HelpText error">{{$errors->first('email')}}</div>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password" tabindex="2">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <div class="HelpText error">{{$errors->first('password')}}</div>
      </div>
      <div class="form-group has-feedback">
        <label>
          <input type="checkbox" name="remember"> Remember Me
        </label>
      </div>
      <button type="submit" class="btn btn-primary btn-block btn-flat">Login In</button>
    </form>
    <br/>
    <a href="{{route('forgot-password')}}">I forgot my password</a><br>
  </div>
  <!-- /.login-box-body -->
@endsection