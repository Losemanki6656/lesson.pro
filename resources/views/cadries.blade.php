@extends(backpack_view('blank'))

@section('content')

    <div class="container-fluid table-responsive">

        <div class="row justify-content-between align-items-center mb-3">
            <div class="col flex-shrink-0 mb-5 mb-md-0">
                <h1>Ходимлар</h1>
                <div class="text-muted">Филтр</div>
            </div>
        </div>

        <table class="bg-white table-sm table table-striped table-hover nowrap rounded shadow-xs border-xs mt-2"
            cellspacing="0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Корхона</th>
                    <th>Ходим</th>
                    <th>Отдель</th>
                    <th>Лавозим</th>
                    <th>Лавозим санаси</th>
                    <th>Маълумоти</th>
                    <th>Туғилган санаси</th>
                </tr>
            </thead>
            <tbody>
                @if (count($cadries))
                    @foreach ($cadries as $item)
                        <tr>
                            <td style="font-weight: bold">{{ $cadries->currentPage() * 15 - 15 + $loop->index + 1  }}</td>
                            <td>{{ $item->organization->name }}</td>
                            <td class="" style="font-weight: bold">{{ $item->fullname }}</td>
                            <td>{{ $item->department->name }}</td>
                            <td  style="font-weight: bold">{{ $item->position->name }}</td>
                            <td >{{ $item->position_date }}</td>
                            <td  style="font-weight: bold">{{ $item->education->name }}</td>
                            <td class="text-primary" style="font-weight: bold">{{ $item->birth_date }}</td>
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
                    <th>Отдель</th>
                    <th>Лавозим</th>
                    <th>Лавозим санаси</th>
                    <th>Маълумоти</th>
                    <th>Туғилган санаси</th>
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
                    {{ $cadries->withQueryString()->links() }}
                </div>
            </div>
        </div>

    </div>
@endsection



@push('after_styles')
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
@endsection
