@extends('theme.layout.main')

@section('page_title')
    Major
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('assets/app/page/admin/css/location.css')}}">
@endsection

@section('page_header')
    <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Major</li>
        </ol>
        <h6 class="slim-pagetitle">Major</h6>
    </div><!-- slim-pageheader -->
@endsection

@section('page_content')
    <div class="section-wrapper">
        <div class="text-right">
            <span class="btn btn-primary btn-icon" data-lang="{{LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']}}" id="addLocation">
                <div>
                    <i class="fa fa-plus"></i>
                </div>
            </span>
        </div>
        @include('theme.admin.section.location.table_major')
        @include('theme.admin.section.location.modal_major')
    </div><!-- section-wrapper -->
    @include('theme.layout.modal_confirm_delete')
@endsection
@section('js')
<script src="{{asset('assets/build/admin/js/location.js')}}"></script>
@endsection
