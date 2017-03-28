@extends('inferno-foundation::html')
@section('title', 'Manage settings')

@section('breadcrumb')
    <section class="content-header">
        <h1>Manage settings<small>Manage settings of the application.</small></h1>
        <ol class="breadcrumb">
            <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Settings</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="section">
        <div class="row">
            <div class="col-sm-6">
                {{--Box--}}
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Manage settings</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="{{route('save-settings')}}" method="post">
                            {{csrf_field()}}
                            @foreach($settings as $key => $value)
                                <div class="form-group">
                                    <label for="">{{$key}}</label>
                                    @if($value === true)
                                        <input type="text" class="form-control" name="{{$key}}" value="true">
                                    @elseif($value === false)
                                        <input type="text" class="form-control" name="{{$key}}" value="false">
                                    @else
                                        <input type="text" class="form-control" name="{{$key}}" value="{{$value}}">
                                    @endif
                                </div>
                            @endforeach

                            <button class="btn btn-success">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
                {{--End box--}}
            </div>

            <div class="col-sm-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Add new setting</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="{{route('add-setting')}}" method="post">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" value="{{old('name')}}">
                            </div>

                            <div class="form-group">
                                <label for="name">Value</label>
                                <input type="text" class="form-control" name="value" value="{{old('value')}}">
                                <small>True and False will be treated as boolean values.</small>
                            </div>

                            <button class="btn btn-success">
                                <i class="fa fa-save"></i> Save
                            </button>
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
