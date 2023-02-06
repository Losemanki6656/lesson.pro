@extends(backpack_view('blank'))



@section('content')
    <div class="container-xl">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col flex-shrink-0 mb-5 mb-md-0">
                <h1>Статистика</h1>
                <div class="text-muted">барча корхоналар бўйича</div>
            </div>
        </div>
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
                                href=""><i class="la la-eye"></i> Кўриш</a>

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

                            <a type="button" href=""
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
                                        @if (backpack_user()->userorganization->organization_id == $arr['organization_id'])
                                            <a type="button" href="{{ route('exam_teachers',[
                                                'org_id' => $arr['organization_id'],
                                                'manag_id' => $arr['management_id'],
                                                ])}}" class="btn btn-sm btn-success"><i
                                                    class="la la-eye"></i> Кўриш</a>   
                                        @else
                                            
                                        @endif
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
        Highcharts.chart('examinations', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: "Ўтган ойда",
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
                    y: {{ $cadries_demo }},
                    sliced: true,
                    selected: true
                },{
                    name: 'Сабабсиз',
                    y:  {{$cadries_demo}} - {{ $cadries_demo_sababli }}
                },  {
                    name: 'Сабабли',
                    y: {{ $cadries_demo_sababli }}
                }]
            }]
        });
       
    </script>
     <script>
        Highcharts.chart('exam', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: "Ўтган ойда",
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
                    y: {{ $examination_minus }} + {{$examination_plus}},
                    sliced: true,
                    selected: true
                }, {
                    name: 'Топшира олмаганлар',
                    y:  {{$examination_minus}}
                }, {
                    name: 'Яхши топширганлар',
                    y: {{ $examination_plus }}
                } ]
            }]
        });
       
    </script>
@endsection
