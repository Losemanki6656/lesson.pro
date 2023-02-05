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
            <span class="text-capitalize"> {{ $manag_name }} - {{$org_name}} </span>
            <small id="datatable_info_stack"> Устоз ходимлар кўрсаткичлари </small>
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
                    <th>Устоз Ходим</th>
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
                                <a type="button" href="{{ route('exam_teacher_deps',[
                                    'org_id' => $org_id,
                                    'manag_id' => $manag_id,
                                    'user_id' => $value['id']
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
                    <th>Устоз Ходим</th>
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

@section('after_scripts')
    <script src="{{ asset('packages/select2/dist/js/select2.full.min.js') }}"></script>

    <script>
        function check_status() {
            if ($('#flexCheckDefault').is(':checked')) {
                var x1 = document.getElementById("st1");
                x1.style.display = "block";
                var x2 = document.getElementById("st2");
                x2.style.display = "block";
            } else {
                var x1 = document.getElementById("st1");
                x1.style.display = "none";
                var x2 = document.getElementById("st2");
                x2.style.display = "none";
            }
        }

        function myFilter() {
            let organization_id = $('#railway_select').val();

            $.ajax({
                url: '{{ route('load_cadries') }}',
                type: 'GET',
                dataType: 'json',
                cache: false,
                data: {
                    organization_id: organization_id
                },
                success: function(data) {
                    var len = 0;
                    if (data != null) {
                        len = data.length;
                    }

                    if (len > 0) {
                        $("#cadry_exam").empty();
                        for (var i = 0; i < len; i++) {
                            var id = data[i].id;
                            var fullname = data[i].fullname;
                            var option = "<option value='" + id + "'>" + fullname + "</option>";
                            $("#cadry_exam").append(option);
                        }
                    } else {
                        $("#cadry_exam").empty();
                        var option = "<option value=''>" + "Xodim topilmadi" + "</option>";
                        $("#cadry_exam").append(option);
                    }
                }
            });
        }
    </script>
    <script>
        $('#mySelect2').select2({
            dropdownParent: $('#myModal')
        });
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            $('.cadry_select').select2();


        });

        $(document).ready(function() {
            var msg = '{{ Session::get('msg') }}';
            var exist = '{{ Session::has('msg') }}';
            if (exist) {
                if (msg == 1) {
                    swal({
                        'icon': 'success',
                        'title': '{{ __('Success') }}',
                        'text': 'Successfully deleted!'
                    });
                }
            }

        });
    </script>
@endsection
