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
            <span class="text-capitalize"> Имтихонга </span>
            <small id="datatable_info_stack"> Қатнашмаганлар </small>
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
                let year_exam = $('#year_exam').val();
                let year_quarter = $('#year_quarter').val();
                
                let org_id = {{ request('org_id') }};

                let url = '{{ route('examdontcadries') }}';
                window.location.href =`${url}?result_exam=${result_exam}&org_id=${org_id}&year_exam=${year_exam}&month_exam=${year_quarter}`;
            }
        </script>
    @endpush

    <div>
        <div class="row row-cols-auto">
            <div class="col-4 col-sm-3 col-lg-3">
                <label for="" class="mb-0"> Сабаби </label>
                <select class="form-control  mb-2" id="result_exam" onchange="filter()">
                    <option value="" @if (request('result_exam') == null) selected @endif>Барчаси</option>
                    <option value="1" @if (request('result_exam') == 1) selected @endif> Сабабли
                    </option>
                    <option value="2" @if (request('result_exam') == 2) selected @endif> Сабабсиз
                    </option>
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
                    <option value="" @if (request('month_exam') == null) selected @endif>Барчаси</option>
                    <option value="1" @if (request('month_exam') == 1) selected @endif> 1 - чорак</option>
                    <option value="2" @if (request('month_exam') == 2) selected @endif> 2 - чорак</option>
                    <option value="3" @if (request('month_exam') == 3) selected @endif> 3 - чорак</option>
                    <option value="4" @if (request('month_exam') == 4) selected @endif> 4 - чорак</option>
                </select>
            </div>
        </div>

        <table class="bg-white table table-sm table-striped table-hover nowrap rounded shadow-xs border-xs mt-2"
            cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ходим</th>
                    <th>Бўлим</th>
                    <th>Лавозим</th>
                    <th>Инструктор</th>
                    <th>Балл</th>
                    <th>Йил</th>
                    <th>Чорак</th>
                    <th>Статус</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($active_cadries))
                    @foreach ($active_cadries as $item)
                        <tr>
                            <td>{{ $active_cadries->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                            <td>{{ $item->cadry->fullname }}</td>
                            <td>{{ $item->cadry->department->name }}</td>
                            <td>{{ $item->cadry->position->name }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td style="font-weight: bold">{{ $item->ball }}</td>
                            <td>{{ $item->examination->year_exam }}</td>
                            <td>{{ $item->examination->year_quarter }}</td>
                            <td class="text-center">
                                @if($item->status_exam == false)
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
                                {{$item->comment}}
                            </td>

                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="10">
                            Ходим топилмади ...
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Ходим</th>
                    <th>Бўлим</th>
                    <th>Лавозим</th>
                    <th>Инструктор</th>
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
                    {{ $active_cadries->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection


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
