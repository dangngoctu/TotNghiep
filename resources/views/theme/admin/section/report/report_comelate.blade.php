<div class="block-time row">
    <div class="col-sm-12 col-md-4 mg-b-5" id="period_performance_select">
        <select class="form-control select2" style="width: 100%" id="period_performance" name="period_performance" data-placeholder="Select period">
            <option label="Select period"></option>
            @if(!isset($time_performance))
            @php 
                $time_performance = [];
                for($i=0; $i < 12; $i++) {
                    $time_performance[$i] = Carbon\Carbon::now()->subMonths($i)->format('m/Y');
                }
            @endphp
            @endif
            @foreach($time_performance as $k => $v)
            @if($loop->first)
                <option value="{{$k}}" selected>{{$v}}</option>
            @else
                <option value="{{$k}}">{{$v}}</option>
            @endif
            @endforeach
        </select>
    </div>

</div>
<div class="card">
    <div class="card-body">
        <h4 class="text-center" id="title-report"></h4>
        <div>
            <div class="horizontalBar pos-relative">
                <canvas id="auditorChart"></canvas>
            </div>
        </div>
    </div><!-- card-body -->
</div><!-- card -->