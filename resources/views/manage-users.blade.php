@extends('inferno-foundation::html')
@section('title', 'Manage users')

@section('breadcrumb')
  <section class="content-header">
    <h1>Manage users<small>Manage users of the application</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Users</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="section">
    <div class="row">
      <div class="col-sm-8">
        {{--Box--}}
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Users</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table table-bordered table-striped table-hover">
              <thead>
              <tr>
                <td>#</td>
                <td>Name</td>
                <td>Email</td>
                <td>Active</td>
                <td>Created at</td>
                <td></td>
              </tr>
              </thead>
              <tbody>
              @foreach($users as $user)
                <tr>
                  <td>{{$user->id}}</td>
                  <td>{{ucwords($user->name)}}</td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->active}}</td>
                  <td>{{$user->created_at}}</td>
                  <td class="col-sm-3">
                    <div class="pull-left">
                      <a href="{{route('edit-user', $user->id)}}" class="btn btn-primary btn-xs">
                        <i class="fa fa-edit"></i> Edit
                      </a>
                    </div>
                    <div class="pull-left gap-left gap-10">
                      <confirm-modal
                        btn-text='<i class="fa fa-trash"></i> Delete'
                        btn-class="btn-danger"
                        url="{{url('api/v1/delete-user')}}"
                        :post-data="{{json_encode(['id' => $user->id])}}"
                        :refresh="true"
                        message="Are you sure you want to delete user {{$user->name}}?">
                      </confirm-modal>
                    </div>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>

            {{$users->render()}}
          </div>
          <!-- /.box-body -->
        </div>
        {{--End box--}}
      </div>

      <div class="col-sm-4">
        {{--Box--}}
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Add a new User</h3>
          </div>
          <form action="{{route('add-user')}}" method="post" id="user-save-form">
            <!-- /.box-header -->
            <div class="box-body">
              {{csrf_field()}}
              <div class="form-group">
                <label for="">Name:</label>
                <input type="text"
                       placeholder="Enter user name"
                       name="name"
                       value="{{old('name')}}"
                       class="form-control">
                <div class="HelpText error">{{$errors->first('name')}}</div>
              </div>

              <div class="form-group">
                <label for="">Email:</label>
                <input type="text"
                       placeholder="Enter user email address"
                       name="email"
                       value="{{old('email')}}"
                       class="form-control">
                <div class="HelpText error">{{$errors->first('email')}}</div>
              </div>

              <div class="form-group">
                <label for="">Password:</label>
                <input type="password"
                       placeholder="Enter user password"
                       name="password"
                       value="{{old('password')}}"
                       class="form-control">
                <div class="HelpText error">{{$errors->first('password')}}</div>
              </div>

              <div class="form-group">
                <label for="">Confirm password:</label>
                <input type="password"
                       placeholder="Enter user password again"
                       name="confirm_password"
                       value="{{old('confirm_password')}}"
                       class="form-control">
                <div class="HelpText error">{{$errors->first('confirm_password')}}</div>
              </div>

              <div class="form-group">
                <label for="">User status:</label>
                <select name="active" id="active" class="form-control">
                  <option value="0" {{ (old('active') == 0) ? 'selected' : '' }}>Inactive</option>
                  <option value="1" {{ (old('active') == 1) ? 'selected' : '' }}>Active</option>
                </select>
                <div class="HelpText error">{{$errors->first('active')}}</div>
              </div>

              <div class="form-group">
                <label for="">Roles:</label>
                <select name="roles[]" id="roles" class="form-control" multiple>
                  @foreach ($roles as $role)
                    <option value="{{$role->name}}">{{$role->name}}</option>
                  @endforeach
                </select>
                <div class="HelpText error">{{$errors->first('roles')}}</div>
              </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-success">Submit</button>
            </div>
          </form>
        </div>
        {{--End box--}}
      </div>
    </div>
  </div>
@endsection

@section('styles')
  <link rel="stylesheet" href="{{ config('foundation.assets_path') . '/css/chosen.min.css' }}">
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#roles').chosen();
    });
</script>
@endsection
