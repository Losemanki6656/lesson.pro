@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        'Статистика Имтихонлар' => url(config('backpack.base.route_prefix'), 'import'),
    ];
    
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp


@section('header')
    <div class="container-fluid">
        <h2>
            <span class="text-capitalize"> Статистика </span>
            <small id="datatable_info_stack"> Имтихонлар </small>
        </h2>
    </div>
@endsection

@section('content')

    <div id="loader">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    @push('scripts')
        <script>
            function filter() {
                let result_exam = $('#result_exam').val();
                let status_exam = $('#status_exam').val();
                let organization_id = $('#organization_id').val();
                let management_id = $('#management_id').val();
                let year_exam = $('#year_exam').val();
                let year_quarter = $('#year_quarter').val();
                let status_order = $('#status_order').val();

                let url = '{{ route('exam_statistics') }}';
                window.location.href =
                    `${url}?result_exam=${result_exam}&status_exam=${status_exam}&organization_id=${organization_id}&management_id=${management_id}&year_exam=${year_exam}&year_quarter=${year_quarter}&status_order=${status_order}`;
            }
        </script>
    @endpush

    <div>
        <div class="row row-cols-auto">
            <div class="col-4 col-sm-3 col-lg-3">
                <label for="" class="mb-0">Имтихон натижаси</label>
                <select class="form-control  mb-2" id="result_exam" onchange="filter()">
                    <option value="" @if (request('result_exam') == null) selected @endif>Барчаси</option>
                    <option value="1" @if (request('result_exam') == 1) selected @endif>Яхши натижа кўрсатганлар
                    </option>
                    <option value="2" @if (request('result_exam') == 2) selected @endif>Ўта олмаганлар</option>
                </select>
            </div>
            <div class="col-4 col-sm-3 col-lg-3">
                <label for="" class="mb-0">Имтихонга қатнашиши</label>
                <select class="form-control  mb-2" id="status_exam" onchange="filter()">
                    <option value="" @if (request('status_exam') == null) selected @endif>Барчаси</option>
                    <option value="1" @if (request('status_exam') == 1) selected @endif>Қатнашмаганлар(Сабабли)
                    </option>
                    <option value="2" @if (request('status_exam') == 2) selected @endif>Қатнашмаганлар(Сабабсиз)
                    </option>
                </select>
            </div>
            <div class="col-4 col-sm-3 col-lg-3">
                <label for="" class="mb-0"> Корхоналар</label>
                <select class="form-control  mb-2" id="organization_id" onchange="filter()">
                    <option value="" @if (request('organization_id') == null) selected @endif>Барчаси</option>
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->id }}" @if (request('organization_id') == $organization->id) selected @endif>
                            {{ $organization->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-4 col-sm-3 col-lg-3">
                <label for="" class="mb-0"> Хўжаликлар</label>
                <select class="form-control  mb-2" id="management_id" onchange="filter()">
                    <option value="" @if (request('management_id') == null) selected @endif>Барчаси</option>
                    @foreach ($managements as $management)
                        <option value="{{ $management->id }}" @if (request('management_id') == $management->id) selected @endif>
                            {{ $management->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-4 col-sm-3 col-lg-3">
                <label for="" class="mb-0"> Йил</label>
                <select class="form-control" id="year_exam" onchange="filter()">
                    <option value="" @if (request('year_exam') == null) selected @endif>Барчаси</option>
                    <option value="2021" @if (request('year_exam') == 2021) selected @endif> 2021</option>
                    <option value="2022" @if (request('year_exam') == 2022) selected @endif> 2022</option>
                    <option value="2023" @if (request('year_exam') == 2023) selected @endif> 2023</option>
                    <option value="2024" @if (request('year_exam') == 2024) selected @endif> 2024</option>
                    <option value="2025" @if (request('year_exam') == 2025) selected @endif> 2025</option>
                </select>
            </div>
            <div class="col-4 col-sm-3 col-lg-3">
                <label for="" class="mb-0"> Чорак</label>
                <select class="form-control" id="year_quarter" onchange="filter()">
                    <option value="" @if (request('year_quarter') == null) selected @endif>Барчаси</option>
                    <option value="1" @if (request('year_quarter') == 1) selected @endif> 1 - чорак</option>
                    <option value="2" @if (request('year_quarter') == 2) selected @endif> 2 - чорак</option>
                    <option value="3" @if (request('year_quarter') == 3) selected @endif> 3 - чорак</option>
                    <option value="4" @if (request('year_quarter') == 4) selected @endif> 4 - чорак</option>
                </select>
            </div>
            <div class="col-4 col-sm-3 col-lg-3">
                <label for="" class="mb-0">Натижа кўрсатгичлари бўйича</label>
                <select class="form-control" id="status_order" onchange="filter()">
                    <option value="" @if (request('status_order') == null) selected @endif>Барчаси</option>
                    <option value="1" @if (request('status_order') == 1) selected @endif>Кетма-кет яхши натижа
                    </option>
                    <option value="2" @if (request('status_order') == 2) selected @endif> Кетма-кет паст натижа
                    </option>
                </select>
            </div>
        </div>

        <table class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Корхона</th>
                    <th>Ходим</th>
                    <th>Балл</th>
                    <th>Йил</th>
                    <th>Чорак</th>
                    <th>Статус</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($exam_cadries))
                    @foreach ($exam_cadries as $item)
                        <tr>
                            <td>{{ $exam_cadries->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                            <td>{{ $item->organization->name }}</td>
                            <td>{{ $item->cadry->fullname }}</td>
                            <td style="font-weight: bold">{{ $item->ball }}</td>
                            <td>{{ $item->examination->year_exam }}</td>
                            <td>{{ $item->examination->year_quarter }}</td>
                            <td class="text-center">
                                @if ($item->status_exam == true && $item->ball >= 56)
                                    <div class="circle bg-success" style="float: left">
                                        <span class="circle__content"><i class='nav-icon la la-check'></i></span>
                                    </div>
                                @elseif($item->status_exam == true && $item->ball < 56)
                                    <div class="circle bg-danger" style="float: left">
                                        <span class="circle__content"><i class='nav-icon la la-close'></i></span>
                                    </div>
                                @elseif($item->status_exam == false)
                                    <span class="status-column" style="float: left">
                                        @if ($item->status_dont_exam == true)
                                            <span class="badge rounded-pill bg-primary">
                                                + Қатнашмади
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">
                                                - Қатнашмади
                                            </span>
                                        @endif
                                    </span>
                                @endif
                            </td>
                            
                            {{-- <td>
                                @if (request('status_order') && request('year_exam') && request(''))
                                    <span class="badge rounded-pill bg-success">
                                        Яхши
                                    </span>
                                @endif
                            </td> --}}

                            <td>
                                <button class="btn btn-sm btn-outline-info" data-toggle="modal"
                                    data-target="#exampleModal{{ $item->id }}"><i class="la la-eye"></i>
                                    Кўриш</button>
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="8">
                            Ходим топилмади ...
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Корхона</th>
                    <th>Ходим</th>
                    <th>Балл</th>
                    <th>Йил</th>
                    <th>Чорак</th>
                    <th>Статус</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>

        <div class="row">
            <div class="col-md-3">
                <div class="d-flex justify-content-start">
                    <select name="" class="form-control" style="width: 100px" id="">
                        <option value="10">10</option>
                        <option value="10">20</option>
                        <option value="10">30</option>
                        <option value="10">100</option>
                    </select>
                </div>
            </div>
            <div class="col">
                <div class="d-flex justify-content-end">
                    {{ $exam_cadries->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@foreach ($exam_cadries as $exam)
    <div class="modal fade" id="exampleModal{{ $exam->id }}" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="font-weight: bold"> Инфо</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table
                        class="bg-white table table-sm table-striped table-hover nowrap rounded shadow-xs border-xs pb-2 border-bottom">
                        <tr>
                            <td style="font-weight: bold"> Хўжалик:</td>
                            <td>{{ $exam->management->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold"> Корхона:</td>
                            <td>{{ $exam->organization->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold"> Ходим:</td>
                            <td>{{ $exam->cadry->fullname }}</td>
                        </tr>
                    </table>
                    @foreach ($exam->exams as $item)
                        <table
                            class="bg-white table table-sm table-striped table-hover nowrap rounded shadow-xs border-xs">
                            <tr>
                                <td style="font-weight: bold"> Имтихон натижаси:</td>
                                <td>{{ $item->examination->year_exam }} Йил, {{ $item->examination->year_quarter }} -
                                    чорак, <span style="font-weight: bold"> {{ $item->ball }}</span> балл</td>
                            </tr>
                            <tr>
                                <td style="font-weight: bold"> Статус:</td>
                                <td>
                                    @if ($item->status_exam == true && $item->ball >= 56)
                                        <span class="status-column" style="float: left">
                                            <div class="bg-success" style="border-radius: 50%">
                                                <i class='nav-icon la la-check'></i>
                                            </div>
                                        </span>
                                    @elseif($item->status_exam == true && $item->ball < 56)
                                        <span class="status-column" style="float: left">
                                            <div class="bg-danger" style="border-radius: 50%">
                                                <i class='nav-icon la la-close'></i>
                                            </div>
                                        </span>
                                    @elseif($item->status_exam == false)
                                        <span class="status-column" style="float: left">
                                            @if ($item->status_dont_exam == true)
                                                <span class="badge rounded-pill bg-primary">
                                                    + Қатнашмади
                                                </span>
                                            @else
                                                <span class="badge rounded-pill bg-danger">
                                                    - Қатнашмади
                                                </span>
                                            @endif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="la la-ban"></i>
                        Қайтиш </button>
                </div>
            </div>
        </div>
    </div>
@endforeach



@push('after_styles')
    {{-- <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <style>
        .circle {
            display: inline-table;
            vertical-align: middle;
            width: 24px;
            height: 24px;
            border-radius: 50%;
        }

        .circle__content {
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }
    </style>
@endpush

@section('after_scripts')
    {{-- <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script> --}}
@endsection
