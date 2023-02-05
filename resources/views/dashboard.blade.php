@extends(backpack_view('blank'))



@section('content')
    <div class="container-xl">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col flex-shrink-0 mb-5 mb-md-0">
                <h1>Статистика</h1>
                <div class="text-muted">барча корхоналар бўйича</div>
            </div>
            <div class="col-12 col-md-auto">
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <select class="form-control input-sm select2" id="railway_select" onchange="myFilter()">
                        <option value="">-- Барчаси --</option>
                        @foreach ($organizations as $item)
                            <option @if ($item->id == request('organization_id')) selected @endif value="{{ $item->id }}">
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @push('scripts')
            <script>
                function myFilter() {
                    let organization_id = $('#railway_select').val();
                    let year_exam = $('#year_exam').val();
                    let quar_exam = $('#quar_exam').val();
                    let year_theme = $('#year_theme').val();
                    let month_theme = $('#month_theme').val();
                    let url = '{{ route('statistics') }}';
                    window.location.href =
                        `${url}?organization_id=${organization_id}&year_exam=${year_exam}&quar_exam=${quar_exam}&year_theme=${year_theme}&month_theme=${month_theme}`;
                }
            </script>
        @endpush
        <div class="row align-items-center">

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            Ходимлар бўйича маълумотлар

                            <a type="button" class="btn btn-sm btn-outline-primary mb-0" href=""><i
                                    class="la la-eye"></i> Кўриш</a>

                        </div>
                    </div>
                    <div class="card-body">
                        <div id="container"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            Машғулотга қатнашмаганлар

                            <a type="button" class="btn btn-sm btn-outline-danger mb-0"
                                href="{{ route('exam_themes') }}"><i class="la la-eye"></i> Кўриш</a>

                        </div>

                    </div>
                    <div class="card-body">
                        <div id="examinations"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            Имтихон натижалари

                            <a type="button" href="{{ route('exam_statistics') }}"
                                class="btn btn-sm btn-outline-success"><i class="la la-eye"></i> Кўриш</a>

                        </div>

                    </div>
                    <div class="card-body">
                        <div id="exam"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            Имтихон натижалари
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="examcadries"></div>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="row align-items-center text-center">
            <div class="col text-center">
                <h6 style="font-weight: bold">---------------Имтихон натижалари (Ўтган чорак)---------------</h6>
            </div>
        </div>

        <div class="row align-items-center">
            @foreach ($managements as $item)
                <div class="col-md-3">
                    <div @if ($a[$item->id] > 56) class="card border-success" @else class="card" @endif 
                        data-toggle="modal" data-target="#exampleModal{{ $item->id }}" style="cursor: pointer">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <span style="font-weight: bold">{{ $item->name }}</span>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <span @if ($a[$item->id] > 56) class="text-success" @endif style="font-weight: bold">
                                Ўртача - {{ $a[$item->id] }}%</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@foreach ($managements as $item)
    <div class="modal fade" id="exampleModal{{ $item->id }}" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <span style="font-weight: bold" class="text-info">{{$item->name}} - </span>
                    <span class="modal-title" id="exampleModalLabel" style="font-weight: bold"> Корхоналар бўйича</span>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs"
                        cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Корхона</th>
                                <th>Балл</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($b[$item->id] as $arr)
                                <tr>
                                    <td></td>
                                    <td>{{ $arr['name'] }}</td>
                                    <td>{{ $arr['koef'] }}</td>
                                    <td>
                                        <a type="button" href="{{ route('exam_teachers',[
                                            'org_id' => $arr['organization_id'],
                                            'manag_id' => $arr['management_id'],
                                            ])}}" class="btn btn-sm btn-success"><i
                                                class="la la-eye"></i> Кўриш</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Корхона</th>
                                <th>Балл</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endforeach

@section('after_scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script>
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'February, 2023',
                align: 'left'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.y}</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: ''
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y} та'
                    }
                }
            },
            series: [{
                name: 'Категориялар',
                colorByPoint: true,
                data: [{
                    name: 'Барча ходимлар',
                    y: {{ $cadries }},
                    sliced: true,
                    selected: true
                }, {
                    name: 'Биринчи қишловчилар',
                    y: {{ $cadrywinter }}
                }, {
                    name: 'Устозлар',
                    y: {{ $teacher_cadries }}
                }, {
                    name: 'Ёш мутахасссислар',
                    y: {{ $cadry30 }}
                }]
            }]
        });
    </script>
    <script>
        function month(id) {
            if (id == 1) return "Январь";
            if (id == 2) return "Февраль";
            if (id == 3) return "Март";
            if (id == 4) return "Апрель";
            if (id == 5) return "Май";
            if (id == 6) return "Июнь";
            if (id == 7) return "Июль";
            if (id == 8) return "Август";
            if (id == 9) return "Сентябрь";
            if (id == 10) return "Октябрь";
            if (id == 11) return "Ноябрь";
            if (id == 12) return "Декабрь";
        }
    </script>
    <script>
        var demo_cadry = @json($demo_cadry);

        Highcharts.chart('examinations', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: {{ $year_check }} + ' йил ' + month({{ $month_check }}) + ' ойида:'
            },
            subtitle: {
                align: 'left'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Корхоналар кесимида'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
            },

            series: [{
                name: 'Ходимлар сони',
                colorByPoint: true,
                data: demo_cadry

            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                }
            }
        });
    </script>
    <script>
        var exam_plus = @json($exam_plus);
        var exam_minus = @json($exam_minus);

        Highcharts.chart('exam', {
            chart: {
                type: 'column'
            },
            title: {
                text: {{ $year_exam }} + ' йилнинг ' + {{ $month_exam }} + ' чорагида:',
                align: 'left'
            },
            xAxis: {
                categories: ["РЖУ", "ВЧД-7", "ТЧ-6", "ТЧ-5", "ПЧ-10", "ПЧ-9", "ПЧ-11", "ПЧ-8", "ШЧ-7", "ШЧ-6",
                    "ШЧ-5", "ЭЧ-4", "ЭЧ-8", "ЯКТНЧК", "Қоровулбозор"
                ]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Корхоналар кесимида'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'gray',
                        textOutline: 'none'
                    }
                }
            },
            legend: {
                align: 'left',
                x: 70,
                verticalAlign: 'top',
                y: 70,
                floating: true,
                backgroundColor: Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                headerFormat: '<b>{point.x}</b><br/>',
                pointFormat: '{series.name}: {point.y}<br/>Умумий: {point.stackTotal}'
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            series: [{
                name: 'Яхши топширганлар',
                data: [{{ implode(',', $exam_plus) }}],
                color: '#90ED7D'
            }, {
                name: 'Топшира олмаганлар',
                data: [{{ implode(',', $exam_minus) }}],
                color: '#000000'
            }]
        });
    </script>
    {{-- <script>
        // Data retrieved from https://gs.statcounter.com/browser-market-share#monthly-202201-202201-bar

        // Create the chart
        Highcharts.chart('examcadries', {
            chart: {
                type: 'column'
            },
            title: {
                align: 'left',
                text: 'Browser market shares. January, 2022'
            },
            subtitle: {
                align: 'left',
                text: 'Click the columns to view versions. Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total percent market share'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },

            series: [{
                name: 'Browsers',
                colorByPoint: true,
                data: [{
                        name: 'Chrome',
                        y: 63.06,
                        drilldown: 'Chrome'
                    },
                    {
                        name: 'Safari',
                        y: 19.84,
                        drilldown: 'Safari'
                    },
                    {
                        name: 'Firefox',
                        y: 4.18,
                        drilldown: 'Firefox'
                    },
                    {
                        name: 'Edge',
                        y: 4.12,
                        drilldown: 'Edge'
                    },
                    {
                        name: 'Opera',
                        y: 2.33,
                        drilldown: 'Opera'
                    },
                    {
                        name: 'Internet Explorer',
                        y: 0.45,
                        drilldown: 'Internet Explorer'
                    },
                    {
                        name: 'Other',
                        y: 1.582,
                        drilldown: null
                    }
                ]
            }],
            drilldown: {
                breadcrumbs: {
                    position: {
                        align: 'right'
                    }
                },
                series: [{
                        name: 'Chrome',
                        id: 'Chrome',
                        data: [
                            [
                                'v65.0',
                                0.1
                            ],
                            [
                                'v64.0',
                                1.3
                            ],
                            [
                                'v63.0',
                                53.02
                            ],
                            [
                                'v62.0',
                                1.4
                            ],
                            [
                                'v61.0',
                                0.88
                            ],
                            [
                                'v60.0',
                                0.56
                            ],
                            [
                                'v59.0',
                                0.45
                            ],
                            [
                                'v58.0',
                                0.49
                            ],
                            [
                                'v57.0',
                                0.32
                            ],
                            [
                                'v56.0',
                                0.29
                            ],
                            [
                                'v55.0',
                                0.79
                            ],
                            [
                                'v54.0',
                                0.18
                            ],
                            [
                                'v51.0',
                                0.13
                            ],
                            [
                                'v49.0',
                                2.16
                            ],
                            [
                                'v48.0',
                                0.13
                            ],
                            [
                                'v47.0',
                                0.11
                            ],
                            [
                                'v43.0',
                                0.17
                            ],
                            [
                                'v29.0',
                                0.26
                            ]
                        ]
                    },
                    {
                        name: 'Firefox',
                        id: 'Firefox',
                        data: [
                            [
                                'v58.0',
                                1.02
                            ],
                            [
                                'v57.0',
                                7.36
                            ],
                            [
                                'v56.0',
                                0.35
                            ],
                            [
                                'v55.0',
                                0.11
                            ],
                            [
                                'v54.0',
                                0.1
                            ],
                            [
                                'v52.0',
                                0.95
                            ],
                            [
                                'v51.0',
                                0.15
                            ],
                            [
                                'v50.0',
                                0.1
                            ],
                            [
                                'v48.0',
                                0.31
                            ],
                            [
                                'v47.0',
                                0.12
                            ]
                        ]
                    },
                    {
                        name: 'Internet Explorer',
                        id: 'Internet Explorer',
                        data: [
                            [
                                'v11.0',
                                6.2
                            ],
                            [
                                'v10.0',
                                0.29
                            ],
                            [
                                'v9.0',
                                0.27
                            ],
                            [
                                'v8.0',
                                0.47
                            ]
                        ]
                    },
                    {
                        name: 'Safari',
                        id: 'Safari',
                        data: [
                            [
                                'v11.0',
                                3.39
                            ],
                            [
                                'v10.1',
                                0.96
                            ],
                            [
                                'v10.0',
                                0.36
                            ],
                            [
                                'v9.1',
                                0.54
                            ],
                            [
                                'v9.0',
                                0.13
                            ],
                            [
                                'v5.1',
                                0.2
                            ]
                        ]
                    },
                    {
                        name: 'Edge',
                        id: 'Edge',
                        data: [
                            [
                                'v16',
                                2.6
                            ],
                            [
                                'v15',
                                0.92
                            ],
                            [
                                'v14',
                                0.4
                            ],
                            [
                                'v13',
                                0.1
                            ]
                        ]
                    },
                    {
                        name: 'Opera',
                        id: 'Opera',
                        data: [
                            [
                                'v50.0',
                                0.96
                            ],
                            [
                                'v49.0',
                                0.82
                            ],
                            [
                                'v12.1',
                                0.14
                            ]
                        ]
                    }
                ]
            }
        });
    </script> --}}
@endsection
