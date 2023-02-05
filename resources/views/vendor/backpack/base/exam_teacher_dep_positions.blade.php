@extends(backpack_view('layouts.top_left'))

@php
    $defaultBreadcrumbs = [
        trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
        __('Import') => url(config('backpack.base.route_prefix'), 'import'),
    ];
    
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp


@section('header')
    <div class="container-fluid">
        <h2>
            <span class="text-capitalize"> {{ $manag_name }} - {{$org_name}} - {{$user_name}} - {{$dep_name}} </span>
            <small id="datatable_info_stack"> Лавозимлар кўрсаткичлари </small>
        </h2>
    </div>
@endsection

@section('content')

    <div id="loader">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <div class="col-8">

        <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2"
            cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Лавозим</th>
                    <th>Балл</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (count($a))
                    @foreach ($a as $key => $value)
                        <tr>
                            <td style="font-weight: bold">{{$loop->index + 1}}</td>
                            <td style="font-weight: bold">{{$value['name']}}</td>
                            <td @if ($value['ball'] > 56)
                                class="text-success"
                            @endif style="font-weight: bold">{{$value['ball']}}</td>
                            <td>
                                <a type="button" href="{{ route('exam_teacher_dep_position_cadries',[
                                    'org_id' => $org_id,
                                    'manag_id' => $manag_id,
                                    'user_id' => $user_id,
                                    'dep_id' => $dep_id,
                                    'pos_id' => $value['id']
                                ])}}" class="btn btn-sm btn-success"><i
                                        class="la la-eye"></i> Кўриш</a>
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
                    <th>Лавозим</th>
                    <th>Балл</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>


    </div>
@endsection



@push('after_styles')
    <link href="{{ asset('packages/select2/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
