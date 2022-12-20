@extends(backpack_view('blank'))



@section('content')
    <div class="container-xl">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col flex-shrink-0 mb-5 mb-md-0">
                <h1>Статистика</h1>
                <div class="text-muted">по всем категориям</div>
            </div>
            <div class="col-12 col-md-auto">
                <div class="d-flex flex-column flex-sm-row gap-3">
                    
                </div>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-sm-6 col-lg-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value text-primary">{{$cadries}}</div>
                            <h6>Все время</h6>
                        </div>
                       

                        <div>Сотрудники.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 13.2%" aria-valuenow="13.2"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        {{$main_cadries}} <small> - количество основных занятий.</small>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value text-danger">0</div>
                            <h6>В предыдущем квартале</h6>
                        </div>

                        <div>Количество не сдавших экзамены.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        0<small> - количество образцовых исполнителей.</small>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value text-warning">{{$cadry30}}</div>
                            <h6>В текущем году</h6>
                        </div>

                        <div>Количество молодых специалистов.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 30%" aria-valuenow="30"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        {{$teacher_cadries}}<small> - количество наставников, закрепленных за молодыми специалистами.</small>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value text-info">0</div>
                            <h6>В текущем году</h6>
                        </div>

                        <div>Количество обученных в этом году.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 280%" aria-valuenow="280"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        0 <small> - не сдавших экзамены.</small>
                    </div>

                </div>
            </div>

            <div class="col-sm-6 col-lg-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value">0</div>
                            <h6>В текущем месяце</h6>
                        </div>

                        <div>Количество не участвовавших в обучении.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 280%" aria-valuenow="280"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        0 <small> - не сдавших экзамены.</small>
                    </div>

                </div>
            </div>

            {{-- <div class="col-sm-6 col-lg-6">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="text-value">210</div>

                        <div>Количество обученных в этом году.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 280%" aria-valuenow="280"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <small> - не сдавших экзамены.</small>
                    </div>

                </div>
            </div> --}}
        </div>
    </div>
@endsection
