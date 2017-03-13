@extends('inferno-foundation::html')
@section('title', 'Edit user')

@section('breadcrumb')
  <section class="content-header">
    <h1>Edit user<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{route('manage-users')}}"><i class="fa fa-user"></i> Users</a></li>
      <li class="active">Edit user</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-6">
      {{--Box--}}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit user "{{ucwords($user->name)}}"</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="{{route('update-user')}}" method="post" id="update-user-form">
            {{csrf_field()}}

            <input type="hidden" name="id" value="{{$user->id}}">

            <div class="form-group">
              <label for="">Name</label>
              <input type="text"
                     name="name"
                     class="form-control"
                     value="{{ucwords($user->name)}}"
                     placeholder="Enter user name">
              <div class="HelpText error">{{$errors->first('name')}}</div>
            </div>

            <div class="form-group">
              <label for="">Email</label>
              <input type="text" class="form-control" value="{{$user->email}}" disabled>
            </div>

            <div class="form-group">
              <label for="role">Roles</label>
              <select name="role[]" id="role" class="form-control" multiple>
                @foreach($roles as $role)
                <option value="{{$role->id}}" {{($user->hasRole($role->name)) ? 'selected' : ''}}>{{$role->name}}</option>
                @endforeach
              </select>
              <div class="HelpText error">{{$errors->first('role')}}</div>
            </div>

            <div class="form-group">
              <label for="status">Status</label>
              <select name="active" id="status" class="form-control">
                <option value="0" {{($user->active == 0) ? 'selected' : ''}}>Inactive</option>
                <option value="1" {{($user->active == 1) ? 'selected' : ''}}>Active</option>
              </select>
            </div>

            <div class="form-group">
              <button class="btn btn-success">
                <i class="fa fa-save"></i> Save
              </button>
            </div>
          </form>
        </div>
        <!-- /.box-body -->
      </div>
      {{--End box--}}
    </div>

    <div class="col-sm-4">

    </div>
  </div>
@endsection

@section('styles')
  <link rel="stylesheet" href="{{ config('foundation.assets_path') . '/css/chosen.min.css' }}">
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        $('#role').chosen();
    });
</script>
@endsection
