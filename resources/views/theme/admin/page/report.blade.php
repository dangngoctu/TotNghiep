@extends('theme.layout.main')

@section('page_title')
    Report
@endsection
@section('page_header')
    <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Report</li>
        </ol>
        <h6 class="slim-pagetitle">Report</h6>
    </div><!-- slim-pageheader -->
@endsection
@section('page_content')
    <div id="collapse_chart_panel" class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <!--widget area-->
            <ul class="row mx-0 list-unstyled social-three text-center">
                <li class="col-6 col-sm-6 col-md-6 py-3 bg-metro col-lg-3">
                <a class="d-block" href="{{route('home.index')}}?type=late">
                    <i class="icon ion-android-contact"></i>
                    <small class="notification-badge"><span class="badge badge-pill badge-dark">{{$data['logtime']['late']}}</span></small>
                    <span class="d-block">Come Late</span>
                </a>
                </li>
                <li class="col-6 col-sm-6 col-md-6 py-3 bg-metro col-lg-3">
                <a class="d-block" href="{{route('home.index')}}?type=early">
                    <i class="icon ion-android-contact"></i>
                    <small class="notification-badge"><span class="badge badge-pill badge-dark">{{$data['logtime']['early']}}</span></small>
                    <span class="d-block">Leave Early</span>
                </a>
                </li>
            </ul>
            <!--end widget area-->
        </div>
    </div>
@endsection

@section('js')
<script src="{{asset('assets/build/admin/js/report.js')}}"></script>
@endsection