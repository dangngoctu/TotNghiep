@extends('theme.layout.main')

@section('page_title')
    Area
@endsection

@section('css')
    <!-- <link rel="stylesheet" href="{{asset('assets/app/page/admin/css/full_layout.css')}}"> -->
@endsection

@section('page_header')
    <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Area</li>
        </ol>
        <h6 class="slim-pagetitle">Area</h6>
    </div><!-- slim-pageheader -->
@endsection

@section('page_content')
    <div class="section-wrapper">
        <div class="row">
            <div class="col-sm-6 col-md-4 mg-b-10">
                <div id="slWrapperLocation" class="parsley-select">
                    <select class="form-control select2" style="width: 100%" id="line_id" name="line_id" data-placeholder="Select line">
                        <option label="Select line"></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="text-right">
            <span class="btn btn-primary btn-icon" data-lang="{{LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']}}" id="addMore">
                <div>
                    <i class="fa fa-list"></i>
                </div>
            </span>
            <span class="btn btn-primary btn-icon" data-lang="{{LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']}}" id="addArea">
                <div>
                    <i class="fa fa-plus"></i>
                </div>
            </span>
        </div>
        @include('theme.admin.section.area.table_area')
        @include('theme.admin.section.area.modal_area')
    </div><!-- section-wrapper -->
    @include('theme.layout.modal_confirm_delete')
@endsection
@section('js')
<script src="{{asset('assets/build/admin/js/area.js')}}"></script>
@endsection
