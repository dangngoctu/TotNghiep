@extends('theme.layout.main')

@section('page_title')
  Failure mode detail
@endsection

@section('page_header')
    <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Failure mode detail</li>
        </ol>
        <h6 class="slim-pagetitle">Failure mode detail</h6>
    </div><!-- slim-pageheader -->
@endsection

@section('page_content')
    <div class="section-wrapper">
        <div class="text-right">
            <span class="btn btn-primary btn-icon" data-lang="{{LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']}}" id="addFailModeDetail">
                <div>
                    <i class="fa fa-plus"></i>
                </div>
            </span>
        </div>
        @include('theme.admin.section.fail_mode_detail.table_fail_mode_detail')
        @include('theme.admin.section.fail_mode_detail.modal_fail_mode_detail')
    </div><!-- section-wrapper -->
    @include('theme.layout.modal_confirm_delete')
@endsection
@section('js')
<script src="{{asset('assets/build/admin/js/fail_mode_detail.js')}}"></script>
@endsection
