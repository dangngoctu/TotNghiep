@extends('theme.layout.main')

@section('page_title')
  User
@endsection

@section('page_header')
    <div class="slim-pageheader">
        <ol class="breadcrumb slim-breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home.index')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User</li>
        </ol>
        <h6 class="slim-pagetitle">User</h6>
    </div><!-- slim-pageheader -->
@endsection

@section('page_content')
    <div class="section-wrapper">
        <!-- <div class="row">
            <div class="col-sm-6 col-md-4 mg-b-10">
                <div id="slWrapperLocation" class="parsley-select">
                    <select class="form-control select2" style="width: 100%" id="line_id_filter" name="line_id_filter" data-placeholder="Select line">
                        <option label="Select Line"></option>
                    </select>
                </div>
            </div>
        </div> -->
        <div class="text-right">
            <span class="btn btn-primary btn-icon mg-l-5" id="addUser">
                <div>
                    <i class="fa fa-plus"></i>
                </div>
            </span>
        </div>
        @include('theme.admin.section.user.table_user')
        @include('theme.admin.section.user.modal_user')
        @include('theme.admin.section.user.modal_log')
    </div><!-- section-wrapper -->
    @include('theme.layout.modal_confirm_delete')
@endsection
@section('js')
<script src="{{asset('assets/build/admin/js/user.js')}}"></script>
@endsection
