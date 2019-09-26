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
    @if(!empty($data->performance))
        <div id="collapse_summary_panel">
            <div class="row">
                <div class="col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body pd-b-0">
                            <h6 class="slim-card-title tx-primary fsize-20">User Performance {{\Carbon\Carbon::now()->format('m/Y')}}</h6>
                            <?php
                                $avg = array_sum(array_column((array)current($data->performance)->performance, 'performance'))/count(current($data->performance)->performance);  
                            ?>
                            <h2 class="tx-lato tx-inverse">{{$avg}}%</h2>
                        </div>
                        <div id="performance_score_rs" class="ht-50 ht-sm-70 mg-r--1 rickshaw_graph"></div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(!empty($data->notification))
        <div class="row mg-t-5">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body pd-b-0">
                        <h6 class="slim-card-title tx-primary fsize-16">Total Notification {{\Carbon\Carbon::now()->format('m/Y')}}</h6>
                        <h2 class="tx-lato tx-inverse">{{current($data->notification)->count}}</h2>
                    </div>
                    <div id="notification_count_rs" class="ht-50 ht-sm-70 mg-r--1 rickshaw_graph"></div>
                </div>
            </div>
        </div>
    @endif

    @if(count($data->total_user) > 0)
        <div class="row mg-t-5">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body pd-b-0">
                        <h6 class="slim-card-title tx-primary fsize-20">Total User {{\Carbon\Carbon::now()->format('m/Y')}}</h6>
                        <h2 class="tx-lato tx-inverse">{{current($data->total_user)->count}}</h2>
                    </div>
                    <div id="total_user_rs" class="ht-50 ht-sm-70 mg-r--1 rickshaw_graph"></div>
                </div>
            </div>
        </div>
    @endif

    @if(count($data->total_machine) > 0)
        <div class="row mg-t-5">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body pd-b-0">
                        <h6 class="slim-card-title tx-primary fsize-20">Total Machine {{\Carbon\Carbon::now()->format('m/Y')}}</h6>
                        <h2 class="tx-lato tx-inverse">{{current($data->total_machine)->count}}</h2>
                    </div>
                    <div id="total_machine_rs" class="ht-50 ht-sm-70 mg-r--1 rickshaw_graph"></div>
                </div>
            </div>
        </div>
    @endif

    @if(isset($data->machine_no_noti))
        <div class="row">
            <div class="col-md-12 col-lg-12 mg-t-10">
                <div class="card card-customer-overview">
                        <div class="card-header text-center">
                            <h6 class="slim-card-title text-center fsize-18">List of machines without notification in month</h6>
                            </div>
                    <div class="card-body">
                    <table id="datatable1" class="table display responsive nowrap total_no_audit_table">
                            <thead>
                                <td>
                                    Name
                                </td>
                            </thead>
                            <tbody>
                                @foreach($data->machine_no_noti as $k => $v)
                                <tr>
                                    <td>
                                        <a class="tx-inverse tx-14 tx-medium d-block">
                                            <span class="square-8 bg-danger mg-r-5 rounded-circle"></span>  
                                            <span class="fsize-15">{{$v->m_device_translations->name}}</span>
                                        </a>
                                        <span class="tx-11 d-block">
                                            <span class="mg-r-15"></span>  
                                            <span class="fsize-14">
                                            {{$v->m_area->m_line->m_line_translations->name}} > 
                                            {{$v->m_area->m_area_translations->name}}</span>
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif


    
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
            @foreach(array_reverse($data->performance) as $k => $v)
                @php
                    $total = 0;
                @endphp
                @foreach($v->performance as $k1 => $v1)
                    @php
                        $total+= $v1->performance;
                    @endphp
                @endforeach
                { x: {{Carbon\Carbon::parse($v->time->date)->timestamp}}, y: Math.round({{$total/count($v->performance)}}) },
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

    @if(!empty($data->notification))
        // TOTAL NOTIFY
        var notification_count_rs = new Rickshaw.Graph({
            element: document.querySelector('#notification_count_rs'),
            renderer: 'area',
            //interpolation: 'basis',
            min: 0,
            series: [{
            data: [
                @foreach(array_reverse((array)$data->notification) as $k => $v)
                    { x: {{Carbon\Carbon::parse($v->time->date)->timestamp}}, y: {{$v->count}} },
                @endforeach
            ],
            color: '#00712e',
            name: 'Notification'
            }]
        });
        notification_count_rs.render();
        

        var hoverDetail_NC = new Rickshaw.Graph.HoverDetail( {
            graph: notification_count_rs,
            formatter: function(series, x, y) {
                var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
                var swatch = '<span class="detail_swatch"></span>';
                var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
                return content;
            }
        });

        var axes_NC = new Rickshaw.Graph.Axis.Time( {
            graph: notification_count_rs
        });
        axes_NC.render();
    @endif
    

    @if(count($data->total_user) > 0)
        //TOTAL USER
        var total_user_rs = new Rickshaw.Graph({
            element: document.querySelector('#total_user_rs'),
            renderer: 'area',
            //interpolation: 'basis',
            min: 0,
            series: [{
            data: [
                @foreach(array_reverse($data->total_user) as $k => $v)
                    { x: {{Carbon\Carbon::parse($v->time->date)->timestamp}}, y: {{$v->count}} },
                @endforeach
            ],
            color: '#00712e',
            name: 'User'
            }]
        });
        total_user_rs.render();

        var hoverDetail_U = new Rickshaw.Graph.HoverDetail( {
        graph: total_user_rs,
        formatter: function(series, x, y) {
            var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
            var swatch = '<span class="detail_swatch"></span>';
            var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
            return content;
        }
        });

        var axes_U = new Rickshaw.Graph.Axis.Time( {
            graph: total_user_rs
        });
        axes_U.render();
    @endif

    @if(count($data->total_machine) > 0)
        //TOTAL MACHINE
        var total_machine_rs = new Rickshaw.Graph({
            element: document.querySelector('#total_machine_rs'),
            renderer: 'area',
            //interpolation: 'basis',
            min: 0,
            series: [{
            data: [
                @foreach(array_reverse($data->total_machine) as $k => $v)
                    { x: {{Carbon\Carbon::parse($v->time->date)->timestamp}}, y: {{$v->count}} },
                @endforeach
            ],
            color: '#00712e',
            name: 'Machine'
            }]
        });
        total_machine_rs.render();

        var hoverDetail_M = new Rickshaw.Graph.HoverDetail( {
        graph: total_machine_rs,
        formatter: function(series, x, y) {
            var date = '<span class="date">' + new Date(x * 1000).toUTCString() + '</span>';
            var swatch = '<span class="detail_swatch"></span>';
            var content = swatch + series.name + ": " + parseInt(y) + '<br>' + date;
            return content;
        }
        });

        var axes_M = new Rickshaw.Graph.Axis.Time( {
            graph: total_machine_rs
        });
        axes_M.render();
    @endif
</script>
@endsection