@extends('theme.layout.main')

@section('page_title')
    Report User Performance
@endsection

@section('css')
    <!-- <link rel="stylesheet" href="{{asset('assets/app/page/admin/css/full_layout.css')}}"> -->
@endsection

@section('page_header')
    <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Report</li>
        </ol>
        <h6 class="slim-pagetitle">User Performance</h6>
    </div><!-- slim-pageheader -->
@endsection
@section('page_content')
    <div class="section-wrapper">
        @include('theme.admin.section.report.report_performance')
    </div><!-- section-wrapper -->
@endsection
@section('js')
<script src="{{asset('assets/build/admin/js/report_performance.js')}}"></script>
@endsection