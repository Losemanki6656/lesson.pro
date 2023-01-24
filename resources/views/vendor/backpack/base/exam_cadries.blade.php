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
            <span class="text-capitalize"> {{ $exam->name }} </span>
            <small id="datatable_info_stack"> Ходимлар </small>
        </h2>
    </div>
@endsection

<div class="modal fade" id="exampleModal" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('add_cadry_to_exam', ['id' => $exam->id]) }}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Ходим қўшиш</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Корхонани танланг</label>
                        <select style="width: 100%" id="railway_select" name="organization_id"
                            class="js-example-basic-single" onchange="myFilter()" required>
                            <option value="0"> -- </option>
                            @foreach ($organizations as $org)
                                <option value="{{ $org->id }}"> {{ $org->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Ходимни танланг</label>
                        <select style="width: 100%" class="cadry_select" id="cadry_exam" name="cadry_id" required>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Балл</label>
                        <input type="number" class="form-control" name="ball" placeholder="" value="0"
                            required>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" onclick="check_status()"
                                        name="status_exam" id="flexCheckDefault">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Имтихонга қатнашмади
                                    </label>
                                </div>
                            </div>

                        </div>
                        <div class="col">

                            <div class="mb-3" id="st1" style="display: none">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="status_dont_exam"
                                        id="flexCheckDefault1">
                                    <label class="form-check-label" for="flexCheckDefault1">
                                        Сабабли
                                    </label>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="mb-3" id="st2" style="display: none">
                        <label for="">Коммент</label>
                        <textarea name="comment" class="form-control"></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="la la-ban"></i>
                        Бекор қилиш </button>
                    <button type="submit" class="btn btn-success"><i class="la la-save"></i> Сақлаш</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('content')

    <div id="loader">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <div class="container-fluid">

        <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="la la-plus"></i> Ходим
            қўшиш</button>
        <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2"
            cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Корхона</th>
                    <th>Ходим</th>
                    <th>Балл</th>
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
                            <td>
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
                            <td>
                                <a type="button" href="{{ route('delete_exam_cadry', ['id' => $item->id]) }}"
                                    class="btn btn-outline-danger btn-sm"> <i class="la la-trash"></i> Ўчириш</a>
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
                    <th>Корхона</th>
                    <th>Ходим</th>
                    <th>Балл</th>
                    <th>Статус</th>
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
