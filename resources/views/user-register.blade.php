@extends('inferno-foundation::guest-template')

@section('content')
    <div class="login-box-body">
        <p class="login-box-msg">Hell awaits you... create your account.</p>

        <form action="{{route('do-registration')}}" method="post">
            {{csrf_field()}}
            <div class="form-group has-feedback">
                <input type="text" class="form-control" placeholder="Name" name="name" tabindex="1" value="{{old('name')}}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div class="HelpText error">{{$errors->first('name')}}</div>
            </div>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="Email" name="email" tabindex="2" value="{{old('email')}}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div class="HelpText error">{{$errors->first('email')}}</div>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password" tabindex="3">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <div class="HelpText error">{{$errors->first('password')}}</div>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Confirm password" name="confirm_password" tabindex="4">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                <div class="HelpText error">{{$errors->first('confirm_password')}}</div>
            </div>
            <div class="form-group has-feedback">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-flat">Login In</button>
        </form>
        <br/>
        <a href="{{route('login')}}">I have an account</a><br>
    </div>
    <!-- /.login-box-body -->
@endsection