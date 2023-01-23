@extends(backpack_view('layouts.top_left'))

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

    <div class="container-fluid">
        <div class="row row-cols-auto">
            <div class="col-12 col-sm-6 col-lg-2">
                <label for="">Имтихон натижаси</label>
                <select name="" class="form-control" id="">
                    <option value="1">Яхши натижа кўрсатганлар</option>
                    <option value="0">Ўта олмаганлар</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <label for="">Имтихонга қатнашиши</label>
                <select name="" class="form-control" id="">
                    <option value="1">Қатнашмаганлар(Сабабли)</option>
                    <option value="0">Қатнашмаганлар(Сабабсиз)</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <label for=""> Корхоналар</label>
                <select name="" class="form-control" id="">
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->id }}"> {{ $organization->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <label for=""> Хўжаликлар</label>
                <select name="" class="form-control" id="">
                    @foreach ($managements as $management)
                        <option value="{{ $management->id }}"> {{ $management->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <label for=""> Йил</label>
                <select name="" class="form-control" id="">
                    <option value="2021"> 2021</option>
                    <option value="2022"> 2022</option>
                    <option value="2023"> 2023</option>
                    <option value="2024"> 2024</option>
                    <option value="2025"> 2025</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <label for=""> Чорак</label>
                <select name="" class="form-control" id="">
                    <option value="1"> 1 - чорак</option>
                    <option value="2"> 2 - чорак</option>
                    <option value="3"> 3 - чорак</option>
                    <option value="4"> 4 - чорак</option>
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
                            <td>{{ $loop->index + 1 }}</td>
                            <td>{{ $item->organization->name }}</td>
                            <td>{{ $item->cadry->fullname }}</td>
                            <td>{{ $item->ball }}</td>
                            <td>{{ $item->examination->year_exam }}</td>
                            <td>{{ $item->examination->year_quarter }}</td>
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
                    <table class="bg-white table table-sm table-striped table-hover nowrap rounded shadow-xs border-xs pb-2 border-bottom">
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
                        <table class="bg-white table table-sm table-striped table-hover nowrap rounded shadow-xs border-xs">
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
        .status-column {
            width: 24px;
            margin: 0 auto;
            display: block;
            text-align: center;
        }
    </style>
@endpush

@section('after_scripts')
    {{-- <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script> --}}
@endsection
