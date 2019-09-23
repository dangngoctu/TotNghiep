@extends('theme.layout.main')

@section('page_title')
    Error
@endsection

@section('page_content')
<div class="page-error-wrapper">
        <div>
          <h1 class="error-title"><img class="lazy" src="{{asset('/img/images_app/logo.jpg')}}" width="300px" alt="logo"></h1>
          <h5 class="tx-sm-24 tx-normal">Service Temporarily Unavailable.</h5>
          <p class="mg-b-50">The server is unable to service your request due to maintenance downtime or capacity problems.</p>
        <p class="mg-b-50">
          <a href="{{route('home.index')}}" class="btn btn-error">Back to Home</a>
          <a href="{{route('home.logout')}}" class="btn btn-error">Logout</a>
        </p>
          <p class="error-footer">&copy; Copyright 2019. All Rights Reserved.</p>
        </div>
</div><!-- page-error-wrapper -->
@endsection