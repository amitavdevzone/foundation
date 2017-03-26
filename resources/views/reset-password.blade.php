@extends('inferno-foundation::guest-template')

@section('content')
    <div class="login-box-body">

        <form action="{{route('change-user-password')}}" method="post">
            {{csrf_field()}}

            <input type="hidden" value="{{$token}}" name="token">

            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Password" name="password" tabindex="1">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div class="HelpText error">{{$errors->first('password')}}</div>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="Confirm password" name="confirm_password" tabindex="2">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                <div class="HelpText error">{{$errors->first('confirm_password')}}</div>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-flat">Reset password</button>
        </form>

    </div>
    <!-- /.login-box-body -->
@endsection