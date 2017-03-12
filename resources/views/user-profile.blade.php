@extends('inferno-foundation::html')
@section('title', 'My Profile page')

@section('breadcrumb')
  <section class="content-header">
    <h1>My profile<small>Manage my settings and other aspects of application</small></h1>
    <ol class="breadcrumb">
      <li><a href="{{route('home')}}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Profile</li>
    </ol>
  </section>
@endsection

@section('content')
  <div class="section">
    <div class="row">
      @include('inferno-foundation::partials.profile-details')
      @include('inferno-foundation::partials.profile-pic-upload')
    </div>
    <!-- /.row -->
    <div class="row">

    </div>
  </div>
@endsection
