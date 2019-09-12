@extends('theme.layout.main')

@section('page_title')
    Notification
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('assets/app/page/admin/css/full_layout.min.css')}}">
@endsection

@section('page_header')
    <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notification</li>
        </ol>
        <h6 class="slim-pagetitle">Notification</h6>
    </div><!-- slim-pageheader -->
@endsection

@section('page_content')
    <div class="section-wrapper">
        <div class="text-right">
            <span class="btn btn-primary btn-icon" data-lang="{{LaravelLocalization::getSupportedLocales()[LaravelLocalization::getCurrentLocale()]['id']}}" id="addNotification">
                <div>
                    <i class="fa fa-plus"></i>
                </div>
            </span>
        </div>
        @include('theme.admin.section.notification.table_notification')
        @include('theme.admin.section.notification.modal_notification_add')
        @include('theme.admin.section.notification.modal_notification_insert')
    </div><!-- section-wrapper -->
    @include('theme.layout.modal_confirm_delete')
@endsection
@section('js')
<script src="{{asset('assets/build/admin/js/notification.js')}}"></script>
@endsection
