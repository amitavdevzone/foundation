@extends('inferno-foundation::html')
@section('title', 'Welcome to your Home')
@section('content')
	<div class="row">
		<div class="col-sm-12">
			{{--Box--}}
			<div class="box box-primary">
			  <div class="box-header with-border">
			    <h3 class="box-title">My activities</h3>
			  </div>
			  <!-- /.box-header -->
			  <div class="box-body">
			  	<div class="row">
			  		<div class="col-md-9">
			  			<activity-graph></activity-graph>
			  		</div>
			  	</div>
			  </div>
			  <!-- /.box-body -->
			</div>
			{{--End box--}}
		</div>
	</div>
	@{{ message }}
@endsection
