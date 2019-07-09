@extends('theme.layout.main')

@section('page_title')
    Class
@endsection

@section('css')
    <!-- <link rel="stylesheet" href="{{asset('assets/app/page/admin/css/full_layout.css')}}"> -->
@endsection

@section('page_header')
    <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Class</li>
        </ol>
        <h6 class="slim-pagetitle">Class</h6>
    </div><!-- slim-pageheader -->
@endsection

@section('page_content')
    <div class="section-wrapper">
        <div class="row">
            <div class="col-sm-6 col-md-4 mg-b-10">
                <div id="slWrapperLocation" class="parsley-select">
                    <select class="form-control select2" style="width: 100%" id="major_id_filter" name="major_id_filter" data-placeholder="Select major">
                        <option label="Select major"></option>
                    </select>
                </div>
            </div>
            <div class="col-sm-6 col-md-4 mg-b-10 d-none">
                <div id="slWrapperLocation" class="parsley-select">
                    <select class="form-control select2 " style="width: 100%" id="course_id_filter" name="course_id_filter" data-placeholder="Select course">
                        <option label="Select course"></option>
                    </select>
                </div>
            </div>
        </div>
        <div class="text-right">
        {{--<a href="{{route('admin.location.machine.code.download.ajax')}}?action=all" class="btn btn-info" id="downQRcode">
                <div>
                    <i class="fa fa-download"></i> Download Class Info
                </div>
            </a> --}} 
            <span class="btn btn-primary btn-icon" data-lang="{{LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']}}" id="addMore">
                <div>
                    <i class="fa fa-list"></i>
                </div>
            </span>
            <span class="btn btn-primary btn-icon mg-l-5" data-lang="{{LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']}}" id="addDevice">
                <div>
                    <i class="fa fa-plus"></i>
                </div>
            </span>
        </div>
        @include('theme.admin.section.class.table_class')
        @include('theme.admin.section.class.modal_class')
    </div><!-- section-wrapper -->
    @include('theme.layout.modal_confirm_delete')
@endsection
@section('js')
<script src="{{asset('assets/build/admin/js/device.js')}}"></script>
@endsection
