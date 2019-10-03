$(function(){
    'use strict';

    $('#period_performance').select2({
        minimumResultsForSearch: Infinity,
    });
    $('#period_performance').on("select2:select", function (e) {
        var data = e.params.data;
        period_performance = data.id;
        getReport();
    }).on('select2:unselect', function (e) {
        period_performance = 0;
        getReport();
    });
    
    getReport();
    window.chartColors = {
        red: 'rgba(250,82,82,0.7)',
        orange: 'rgb(255,146,43,0.7)',
        yellow: 'rgba(252,196,25,0.7)',
        green: 'rgba(130,201,30,0.7)',
        blue: 'rgba(34,139,230,0.7)',
        purple: 'rgb(121,80,242,0.7)',
        grey: 'rgba(73,80,87,0.7)'
    };
    $('#reportrange').daterangepicker(
        {
            ranges : {
                // 'Today'   : [moment(), moment()],
                '1 Week'  : [moment().subtract(6, 'days'), moment()],
                '2 Weeks' : [moment().subtract(13, 'days'), moment()],
                '4 Weeks' : [moment().subtract(27, 'days'), moment()],
                '9 Weeks' : [moment().subtract(62, 'days'), moment()],
                '13 Weeks': [moment().subtract(90, 'days'), moment()],
            },
            startDate: moment().subtract(6, 'days'),
            endDate  : moment(),
            autoApply: true
            // showCustomRangeLabel: false
        },changeTimeReport
    );

    var ctxAuditor = document.getElementById("auditorChart").getContext("2d");
    auditChart = new Chart(ctxAuditor, {
        type: 'horizontalBar',
        data: {
            labels: labelsAudit,
            datasets: [{
                label: 'Number notification',
                backgroundColor: window.chartColors.red,
                data: dataAudit
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                xAxes: [{
                    ticks: {
                        min: 0,
                        beginAtZero: true
                    }
                }],
                yAxes: [{
                    ticks: {
                        mirror: true,
                        padding: -10
                    },
                    maxBarThickness: 50,
                    barThickness: 'flex'
                }]
            },
            legend: {
                labels: {
                    usePointStyle: true
                },
                display: false
            },
            tooltips: {
                // enabled: false,
                // mode: 'index',
                // position: 'nearest',
                // custom: customTooltips
                callbacks: {
                    title: function(tooltipItem, data) {
                        var maxLabelLength = 30;
                        var length_y = data.labels[tooltipItem[0].index].length;
                        if (length_y > maxLabelLength) {
                            var t_count = '';
                            for (var i_count = 0; i_count < length_y; i_count += maxLabelLength) {
                                var break_line = '\r\n';
                                if(length_y - i_count <= maxLabelLength) {
                                    break_line = '';
                                }
                                t_count += (data.labels[tooltipItem[0].index]).substr(i_count, maxLabelLength) + break_line;
                            }
                            return t_count;
                        } else {
                            return data.labels[tooltipItem[0].index];
                        }
                    },
                    label: function (tooltipItem, data) {
                        var label = data.datasets[tooltipItem.datasetIndex].label || '';

                        if (label) {
                            label += ': ';
                        }
                        var txt_percent = '%';
                        if(typeChart == 1) {
                            txt_percent = '';
                        }
                        label += data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index] + txt_percent;
                        return label;
                    }
                }
            },
            animation: {
                onProgress: function() {
                    var height = labelsAudit.length * 20;
                    if(height < 500) {
                        height = 500;
                    }
                    $("#auditorChart").parent().height(height);

                    const chartInstance = this.chart;
                    const ctx = chartInstance.ctx;
                    const dataset = this.data.datasets[0];
                    const meta = chartInstance.controller.getDatasetMeta(0);

                    Chart.helpers.each(meta.data.forEach((bar, index) => {
                        const label = this.data.labels[index];
                        const labelPositionX = 20;
                        const labelWidth = ctx.measureText(label).width + labelPositionX;

                        ctx.textBaseline = 'middle';
                        ctx.textAlign = 'left';
                        ctx.fillStyle = '#333';
                        ctx.fillText(label, labelPositionX, bar._model.y);
                    }));
                },
                onComplete: function(animation){
                    if($('#btn-savegraph').length > 0) {
                        document.querySelector('#btn-savegraph').setAttribute('href', this.toBase64Image());
                    }
                }
            }
        }
    });
});

var getUrlParameter = function(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

var labelsAudit = [], dataAudit = [], auditChart, list_report, period = 0, period_performance =0, typeChart = 1;
var type = getUrlParameter('type');
var changeTimeReport = function (start, end) {
    $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    startAjax = start.format('YYYY-MM-DD HH:mm:ss');
    endAjax = end.format('YYYY-MM-DD HH:mm:ss');
    week = moment(end).diff(moment(start), 'weeks') + 1;
    switch (week)
    {
        case 0:
        case 1:
        case 2:
        {
            var days = [];
            for(var i = start; i <= end; i = moment(i).add(1, 'days')) {
                days.push(i.format('DD/MM/YYYY HH:mm:ss'));
            }
            labels = days;
            break;
        }
        default:
        {
            var days = [];
            for(var i = start; i <= end; i = moment(i).add(7, 'days')) {
                days.push(i.format('DD/MM/YYYY HH:mm:ss'));
            }
            labels = days;
            break;
        }
    }
    getReport();
};

var getReport = function(){
    $.ajax({
        url: base_admin + "/home/ajax/ajax_report_performance?month=" + period_performance,
        type: "get",
        success: function(response) {
            if (response.code == '200') {
                list_report = response.data;
            } else {
                list_report =[];
                $('.section-wrapper').waitMe('hide');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            list_report = [];
            $('.section-wrapper').waitMe('hide');
        }
    }).then(function () {
        dataAudit = [];
        labelsAudit = [];
        $.each(list_report, function(key, value) {
            $('#bread-type, #title-page, #title-report').html('Customer');
            dataAudit.push(value.performance);
            labelsAudit.push(value.name);
        });
        if(typeof auditChart != "undefined") {
            auditChart.data.labels = labelsAudit;
            auditChart.data.datasets[0].data = dataAudit;
            auditChart.data.datasets[0].label = 'User Performance';
            auditChart.update();
        }
    });
};