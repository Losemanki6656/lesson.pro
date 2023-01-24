@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        'Машғулотлар' => url(config('backpack.base.route_prefix'), 'import'),
    ];
    
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp


@section('header')
    <div class="container-fluid">
        <h2>
            <span class="text-capitalize"> {{ $them->name }} </span>
            <small id="datatable_info_stack"> Ходимларнинг қатнашиши </small>
        </h2>
    </div>
@endsection

@section('content')

    <div id="loader">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <table class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Ходим</th>
                <th>Бўлим</th>
                <th>Статус</th>
                <th>Коммент</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @if (count($themes))
                @foreach ($themes as $item)
                    <tr>
                        <td style="font-weight: bold">{{ $themes->currentPage() * 10 - 10 + $loop->index + 1 }}</td>
                        <td style="font-weight: bold">{{ $item->cadry->fullname }}</td>
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
                        <td>
                            <button class="btn btn-sm btn-outline-dark" data-toggle="modal"
                                data-target="#exampleModal{{ $item->id }}"><i class="la la-edit"></i>
                                Тахрирлаш</button>
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
                <th>Бўлим</th>
                <th>Статус</th>
                <th>Коммент</th>
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
                {{ $themes->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection

@foreach ($themes as $exam)
    <div class="modal fade" id="exampleModal{{ $exam->id }}" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('edit_cadry_theme', ['id' => $exam->id]) }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Тахрирлаш</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            name="status_theme" id="flexCheckDefault{{ $exam->id }}">
                                        <label class="form-check-label" for="flexCheckDefault{{ $exam->id }}">
                                            Машғулотга қатнашмади
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="col">

                                <div class="mb-3" id="st1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="status_dont_check"
                                            id="flexCheckDefault1{{ $exam->id }}">
                                        <label class="form-check-label" for="flexCheckDefault1{{ $exam->id }}">
                                            Сабабли
                                        </label>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="mb-3" id="st2">
                            <label for="">Коммент</label>
                            <textarea name="comment" class="form-control"></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i
                                class="la la-ban"></i>
                            Бекор қилиш </button>
                        <button type="submit" class="btn btn-success"><i class="la la-save"></i> Сақлаш</button>
                    </div>
                </form>
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
