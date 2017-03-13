@extends('inferno-foundation::html')
@section('title', 'Edit role')

@section('breadcrumb')
  <section class="content-header">
    <h1>Edit role<small></small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{route('manage-roles')}}"><i class="fa fa-user"></i> Role</a></li>
      <li class="active">Edit role</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="row">
    <div class="col-sm-6">
      {{--Box--}}
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit role "{{ucwords($role->name)}}"</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="{{route('update-role')}}" method="post" id="update-role-form">
            {{csrf_field()}}

            <input type="hidden" name="id" value="{{$role->id}}">

            <div class="form-group">
              <label for="">Name</label>
              <input type="text"
                     name="name"
                     class="form-control"
                     value="{{ucwords($role->name)}}"
                     placeholder="Enter role name">
              <div class="HelpText error">{{$errors->first('name')}}</div>
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
