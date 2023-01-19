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

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Ходим қўшиш</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Корхонани танланг</label>
                    <select style="width: 100%" data-init-function="bpFieldInitSelect2Element"
                        class="form-control input-sm select2">
                        @foreach ($organizations as $org)
                            <option value="{{ $org->id }}"> {{ $org->name }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Ходимни танланг</label>
                    <select style="width: 100%" data-init-function="bpFieldInitSelect2Element"
                        class="form-control input-sm select2">
                        @foreach ($exam_cadries as $cadry)
                            <option value="{{ $cadry->id }}"> {{ $cadry }} </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                   <label for="">Балл</label>
                   <input type="number" class="form-control" name="ball" placeholder="">
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="la la-ban"></i>
                    Отмена</button>
                <button type="button" class="btn btn-success"><i class="la la-save"></i> Сохранить</button>
            </div>
        </div>
    </div>
</div>

@section('content')

    <div id="loader">
        <div class="cv-spinner">
            <span class="spinner"></span>
        </div>
    </div>

    <div class="row">
        <div class="container-fluid">

            <button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"><i class="la la-plus"></i> Ходим
                қўшиш</button>
            <table id="crudTable" class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2"
                cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
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
                                <td>{{ $item->file_name }}</td>
                                <td>{{ $item->row_count }} rows</td>
                                <td>{{ $item->date_vgo }}</td>
                                <td>
                                    @if ($item->status == true)
                                        <span class="badge badge-success"> Successfully </span>
                                    @else
                                        <span class="badge badge-primary"> Proceccing ... </span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status == true)
                                        <a type="button" href="{{ route('delete_task', ['id' => $item->id]) }}"
                                            class="btn btn-outline-danger btn-sm"> <i class="la la-trash"></i> Delete</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="5">
                                Ходим топилмади ...
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Row Count</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>


        </div>
    </div>
@endsection

@section('after_scripts')
    <script>
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
