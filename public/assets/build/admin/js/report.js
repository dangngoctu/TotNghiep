$(function(){
    'use strict';
    var start = moment().subtract(6, 'days');
    var end = moment();
    var label = "1 Week";
    $('#changeUser, #changeArea, #changeStatus').select2({
        allowClear: true,
    });
    $('#reportrange').daterangepicker(
        {
            ranges   : {
                // 'Today'   : [moment(), moment()],
                '1 Week'  : [moment().subtract(6, 'days'), moment()],
                '2 Weeks' : [moment().subtract(13, 'days'), moment()],
                '4 Weeks' : [moment().subtract(27, 'days'), moment()],
                '9 Weeks' : [moment().subtract(62, 'days'), moment()],
                '13 Weeks': [moment().subtract(90, 'days'), moment()],
            },
            startDate: moment().subtract(6, 'days'),
            endDate  : moment()
        },changeTimeReport
    );

    changeTimeReport(start, end, label);
    window.chartColors = {
        red: 'rgb(198, 53, 62)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(0, 134, 68)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(231,233,237)'
    };

    //Bar and Line
    var excellent = new Image();
    excellent.src = '/assets/app/img/Excellent_1.png';

    var good = new Image();
    good.src = '/assets/app/img/good_1.png';

    var average = new Image();
    average.src = '/assets/app/img/Average_1.png';

    var poor = new Image();
    poor.src = '/assets/app/img/Poor_1.png';

    var very_poor = new Image();
    very_poor.src = '/assets/app/img/Verypoor_1.png';

    Chart.pluginService.register({
        afterUpdate: function(chart) {
            if(chart.canvas.id == 'performanceChart') {
                var length = chart.config.data.datasets[0]._meta[0].data.length;
                for(var i=0; i<length; i++) {
                    switch (chart.config.data.datasets[0].data[i])
                    {
                        case 5:
                            chart.config.data.datasets[0]._meta[0].data[i]._model.pointStyle = excellent;
                            break;
                        case 4:
                            chart.config.data.datasets[0]._meta[0].data[i]._model.pointStyle = good;
                            break;
                        case 3:
                            chart.config.data.datasets[0]._meta[0].data[i]._model.pointStyle = average;
                            break;
                        case 2:
                            chart.config.data.datasets[0]._meta[0].data[i]._model.pointStyle = poor;
                            break;
                        default:
                            chart.config.data.datasets[0]._meta[0].data[i]._model.pointStyle = very_poor;
                    }
                }
            }
        }
    });

    var ctx = document.getElementById("performanceChart").getContext("2d");
    performanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                type: 'line',
                label: 'Performance',
                borderColor: window.chartColors.red,
                borderWidth: 2,
                fill: false,
                data: []
            }, {
                type: 'bar',
                label: 'Notifications',
                backgroundColor: window.chartColors.green,
                data: [2, 4, 1, 3, 7, 3, 6]
            }]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: true
            },
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    var ctxAvg = document.getElementById("averageChart").getContext("2d");
    averageChart = new Chart(ctxAvg, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                type: 'line',
                label: 'Average',
                borderColor: window.chartColors.orange,
                borderWidth: 2,
                fill: false,
                data: [3, 6, 2, 9, 12, 5, 9]
            },
            {
                type: 'line',
                label: 'Max',
                borderColor: window.chartColors.green,
                borderWidth: 2,
                fill: false,
                data: [2, 4, 1, 3, 7, 3, 6]
            },
            {
                type: 'line',
                label: 'Min',
                borderColor: window.chartColors.red,
                borderWidth: 2,
                fill: false,
                data: [1, 2, 5, 1, 2, 1, 3]
            }]
        },
        options: {
            responsive: true,
            tooltips: {
                mode: 'index',
                intersect: true
            },
            scales: {
                yAxes: [{
                    ticks: {
                        min: 0,
                        beginAtZero: true
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "(mins / %)"
                    }
                }]
            }
        }
    });

    //Pie Chart
    var dataPieDone = {
        labels: ["Done", "Not Done"],
        datasets: [
            {
                data: [80, 20],
                backgroundColor: [window.chartColors.green,window.chartColors.gray],
            }
        ]
    };

    var dataPieCheck = {
        labels: ["Check", "Not Check"],
        datasets: [
            {
                data: [65, 35],
                backgroundColor: [window.chartColors.yellow,window.chartColors.gray],
            }
        ]
    };

    Chart.pluginService.register({
        beforeDraw: function(chart) {
            var width = chart.chart.width,
                height = chart.chart.height,
                ctx = chart.chart.ctx,
                type = chart.config.type;

            if (type == 'doughnut')
            {
                var percent = Math.round((chart.config.data.datasets[0].data[0] * 100) /
                    (chart.config.data.datasets[0].data[0] +
                        chart.config.data.datasets[0].data[1]));
                var oldFill = ctx.fillStyle;
                var fontSize = ((height - chart.chartArea.top) / 100).toFixed(2);

                ctx.restore();
                ctx.font = fontSize + "em sans-serif";
                ctx.textBaseline = "middle"

                var text = percent + "%",
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = (height + chart.chartArea.top) / 2;

                ctx.fillStyle = chart.config.data.datasets[0].backgroundColor[0];
                ctx.fillText(text, textX, textY);
                ctx.fillStyle = oldFill;
                ctx.save();
            }
        }
    });

    percentDoneChart = new Chart(document.getElementById('percentDoneChart'), {
        type: 'doughnut',
        data: dataPieDone,
        options: {
            responsive: true,
            legend: {
                display: false
            }
        }
    });

    percentCheckChart = new Chart(document.getElementById('percentCheckChart'), {
        type: 'doughnut',
        data: dataPieCheck,
        options: {
            responsive: true,
            legend: {
                display: false
            }
        }
    });
});

var labels = [], dataOne = [], dataTwo = [], performanceChart, percentDoneChart, percentCheckChart, averageChart;
var changeTimeReport = function (start, end, label) {
    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    switch (label)
    {
        case "1 Week":
        case "2 Weeks":
        {
            var days = [];
            for(var i = start; i <= end; i = moment(i).add(1, 'days')) {
                days.push(i.format('MMMM D, YYYY'));
            }
            labels = days;
            dataOne = [];
            dataTwo = [2, 4, 1, 3, 7, 3, 6, 2, 4, 1, 3, 7, 3, 6];
            break;
        }
        case "4 Weeks":
        {
            var days = [];
            for(var i = start; i <= end; i = moment(i).add(7, 'days')) {
                days.push(i.format('MMMM D, YYYY'));
            }
            labels = days;
            dataOne = [];
            dataTwo = [3, 7, 3, 6];
            break;
        }
        case "9 Weeks":
        {
            var days = [];
            for(var i = start; i <= end; i = moment(i).add(7, 'days')) {
                days.push(i.format('MMMM D, YYYY'));
            }
            labels = days;
            dataOne = [5, 3, 2, 1, 5, 3, 4, 1, 4];
            dataTwo = [3, 7, 3, 6, 3, 7, 3, 6, 10];
            break;
        }
        case "13 Weeks":
        {
            var days = [];
            for(var i = start; i <= end; i = moment(i).add(7, 'days')) {
                days.push(i.format('MMMM D, YYYY'));
            }
            labels = days;
            dataOne = [5, 3, 4, 1, 5, 3, 4, 1, 4, 3, 5, 3, 2];
            dataTwo = [3, 7, 3, 6, 3, 7, 3, 6, 10, 5, 3, 4, 10];
            break;
        }
        default:
        {
            break;
        }
    }

    if(typeof performanceChart != "undefined") {
        performanceChart.data.labels = labels;
        performanceChart.data.datasets[0].data = dataOne;
        performanceChart.data.datasets[1].data = dataTwo;
        performanceChart.update();
    }
};