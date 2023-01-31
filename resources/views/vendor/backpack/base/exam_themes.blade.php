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
                let organization_id = $('#organization_id').val();
                let management_id = $('#management_id').val();
                let year_theme = $('#year_theme').val();
                let month_theme = $('#month_theme').val();

                let url = '{{ route('exam_themes') }}';
                window.location.href =
                    `${url}?organization_id=${organization_id}&management_id=${management_id}&year_theme=${year_theme}&month_theme=${month_theme}`;
            }
        </script>
    @endpush

    <div>
        <div class="row row-cols-auto">
            <div class="col-12 col-sm-6 col-lg-2">
                <label for=""> Корхоналар</label>
                <select class="form-control" id="organization_id" onchange="filter()">
                    <option value="" @if (request('organization_id') == null) selected @endif>Барчаси</option>
                    @foreach ($organizations as $organization)
                        <option value="{{ $organization->id }}" @if (request('organization_id') == $organization->id) selected @endif>
                            {{ $organization->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <label for=""> Хўжаликлар</label>
                <select class="form-control" id="management_id" onchange="filter()">
                    <option value="" @if (request('management_id') == null) selected @endif>Барчаси</option>
                    @foreach ($managements as $management)
                        <option value="{{ $management->id }}" @if (request('management_id') == $management->id) selected @endif>
                            {{ $management->name }} </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <label for=""> Йил</label>
                <select class="form-control" id="year_theme" onchange="filter()">
                    <option value="" @if (request('year_theme') == null) selected @endif>
                        Барчаси
                    </option>
                    <option value="2021" @if (request('year_theme') == 2021) selected @endif> 2021
                    </option>
                    <option value="2022" @if (request('year_theme') == 2022) selected @endif> 2022
                    </option>
                    <option value="2023" @if (request('year_theme') == 2023) selected @endif> 2023
                    </option>
                    <option value="2024" @if (request('year_theme') == 2024) selected @endif> 2024
                    </option>
                    <option value="2025" @if (request('year_theme') == 2025) selected @endif> 2025
                    </option>

                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-2">
                <label for=""> Чорак</label>
                <select class="form-control" id="month_theme" onchange="filter()">
                    <option value="" @if (request('month_theme') == null) selected @endif>
                        Барчаси
                    </option>
                    <option value="1" @if (request('month_theme') == 1) selected @endif>Январь </option>
                    <option value="2" @if (request('month_theme') == 2) selected @endif>Февраль </option>
                    <option value="3" @if (request('month_theme') == 3) selected @endif>Март </option>
                    <option value="4" @if (request('month_theme') == 4) selected @endif>Апрель </option>
                    <option value="5" @if (request('month_theme') == 5) selected @endif>Май </option>
                    <option value="6" @if (request('month_theme') == 6) selected @endif>Июнь </option>
                    <option value="7" @if (request('month_theme') == 7) selected @endif>Июль </option>
                    <option value="8" @if (request('month_theme') == 8) selected @endif>Август </option>
                    <option value="9" @if (request('month_theme') == 9) selected @endif>Сентябрь </option>
                    <option value="10" @if (request('month_theme') == 10) selected @endif>Октябрь </option>
                    <option value="11" @if (request('month_theme') == 11) selected @endif>Ноябрь </option>
                    <option value="12" @if (request('month_theme') == 12) selected @endif>Декабрь </option>
                </select>
            </div>
        </div>

        <table class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2" cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ходим</th>
                    <th>Корхона</th>
                    <th>Бўлим</th>
                    <th>Статус</th>
                    <th>Коммент</th>
                </tr>
            </thead>
            <tbody>
                @if (count($exam_cadries))
                    @foreach ($exam_cadries as $item)
                        <tr>
                            <td style="font-weight: bold">{{ $exam_cadries->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                            <td style="font-weight: bold">{{ $item->cadry->fullname }}</td>
                            <td style="font-weight: bold">{{ $item->organization->name }}</td>
                            <td>{{ $item->department->name }}</td>
                            <td class="text-center">
                                @if ($item->status == false)
                                    <span class="status-column" style="float: left">
                                        @if ($item->status_dont_check == true)
                                            <span class="badge rounded-pill bg-primary">
                                                + Қатнашмади
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">
                                                - Қатнашмади
                                            </span>
                                        @endif
                                    </span>
                                @else
                                    <span class="status-column" style="float: left">
                                        <span class="badge rounded-pill bg-success">
                                            Қатнашди
                                        </span>
    
                                    </span>
                                @endif
                            </td>
                            <td>
                                {{ $item->comment }}
                            </td>
    
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="6">
                            Ходим топилмади ...
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Ходим</th>
                    <th>Корхона</th>
                    <th>Бўлим</th>
                    <th>Статус</th>
                    <th>Коммент</th>
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
