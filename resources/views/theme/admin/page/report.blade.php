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
                    <a class="d-block" href="{{route('home.index')}}?type=machine">
                    <i class="icon ion-cube"></i>
                    <span class="d-block">MACHINE</span>
                    </a>
                </li>
                <li class="col-6 col-sm-6 col-md-6 py-3 bg-metro col-lg-3">
                    <a class="d-block" href="{{route('home.index')}}?type=performance">
                        <i class="icon ion-ios-pulse"></i>
                        <span class="d-block">User Performance</span>
                    </a>
                </li>
                <li class="col-6 col-sm-6 col-md-6 py-3 bg-metro col-lg-3">
                <a class="d-block" href="{{route('home.index')}}?type=late">
                    <i class="icon ion-android-contact"></i>
                    <small class="notification-badge"><span class="badge badge-pill badge-dark">{{$data->logtime->late}}</span></small>
                    <span class="d-block">Come Late</span>
                </a>
                </li>
                <li class="col-6 col-sm-6 col-md-6 py-3 bg-metro col-lg-3">
                <a class="d-block" href="{{route('home.index')}}?type=early">
                    <i class="icon ion-android-contact"></i>
                    <small class="notification-badge"><span class="badge badge-pill badge-dark">{{$data->logtime->early}}</span></small>
                    <span class="d-block">Leave Early</span>
                </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="slim-pageheader">
        <h6 class="slim-pagetitle">
                <span class="text-left">SUMMARY</span>
            <span class="text-right pull-right">
                <a class="collapse_panel cursor-pointer" id="collapse_summary"><i class="icon ion-android-arrow-dropup-circle"></i></a>
            </span>
        </h6>
    </div>
    <div id="collapse_summary_panel">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body pd-b-0">
                        <h6 class="slim-card-title tx-primary fsize-20">User Performance {{\Carbon\Carbon::now()->format('m/Y')}}</h6>
                        <h2 class="tx-lato tx-inverse">99%</h2>
                    </div>
                    <div id="performance_score_rs" class="ht-50 ht-sm-70 mg-r--1 rickshaw_graph"></div>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@section('js')
<script src="{{asset('assets/build/admin/js/report.js')}}"></script>
<script>
    //Performance
    @if(isset($data->performance))
        
        var performance_score_rs = new Rickshaw.Graph({
        element: document.querySelector('#performance_score_rs'),
        renderer: 'line',
        //interpolation: 'basis',
        min: 0,
        max:100,
        series: [{
        data: [
            @foreach($data->performance as $k => $v)
                    @php
                        $total = 0;
                    @endphp
                @foreach($v as $k1 => $v1)
                    @php
                        $total+= $v1->performance;
                    @endphp
                @endforeach
                { x: {{Carbon\Carbon::now()->subMonths($k)->startOfMonth()->timestamp}}, y: Math.round({{$total/count($v)}}) },
            @endforeach
        ],
        color: '#00712e',
        name: 'User performance'
        }]
        });
        performance_score_rs.configure({
            width: $('#performance_score_rs').width(),
        });
        performance_score_rs.render();

        var hoverDetail_performance = new Rickshaw.Graph.HoverDetail( {
            graph: performance_score_rs,
            formatter: function(series, x, y) {
                var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
                var swatch = '<span class="detail_swatch"></span>';
                var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
                return content;
            }
        });

        var user_per = new Rickshaw.Graph.Axis.Time( {
            graph: performance_score_rs
        });
        user_per.render();
    @endif
</script>
@endsection