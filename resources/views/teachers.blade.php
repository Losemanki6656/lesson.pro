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
                    <th>Почта</th>
                    <th>Created_at</th>
                </tr>
            </thead>
            <tbody>
                @if (count($users))
                    @foreach ($users as $item)
                        <tr>
                            <td style="font-weight: bold">{{ $loop->index + 1  }}</td>
                            <td>{{ $item->userorganization->organization->name }}</td>
                            <td class="" style="font-weight: bold">{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td  style="font-weight: bold">{{ $item->created_at }}</td>
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
                    <th>Почта</th>
                    <th>Created_at</th>
                </tr>
            </tfoot>
        </table>

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
