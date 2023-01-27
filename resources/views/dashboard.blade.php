@extends(backpack_view('blank'))



@section('content')
    <div class="container-xl">
        <div class="row justify-content-between align-items-center mb-3">
            <div class="col flex-shrink-0 mb-5 mb-md-0">
                <h1>Статистика</h1>
                <div class="text-muted">барча корхоналар бўйича</div>
            </div>
            <div class="col-12 col-md-auto">
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <select class="form-control input-sm select2" id="railway_select" onchange="myFilter()">
                        <option value="">-- Барчаси --</option>
                        @foreach ($organizations as $item)
                            <option @if ($item->id == request('organization_id')) selected @endif value="{{ $item->id }}">
                                {{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        @push('scripts')
            <script>
                function myFilter() {
                    let organization_id = $('#railway_select').val();
                    let year_exam = $('#year_exam').val();
                    let quar_exam = $('#quar_exam').val();
                    let year_theme = $('#year_theme').val();
                    let month_theme = $('#month_theme').val();
                    let url = '{{ route('statistics') }}';
                    window.location.href =
                    `${url}?organization_id=${organization_id}&year_exam=${year_exam}&quar_exam=${quar_exam}&year_theme=${year_theme}&month_theme=${month_theme}`;
                }
            </script>
        @endpush
        <div class="row align-items-center">
            <div class="col-sm-6 col-lg-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value text-primary">{{ $cadries }}</div>
                            <h6>Барчаси</h6>
                        </div>


                        <div>Ходимлар (асосий касб эгалари).</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 13.2%" aria-valuenow="13.2"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <button class="btn btn-sm btn-primary"><i class="la la-eye"></i> Кўриш</button>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value text-success" id="result">{{ $examination_plus }} /
                                {{ $examination_plus }}</div>
                            <h6>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control form-control-sm" id="year_exam" onchange="myFilter()">
                                            <option value="" @if (request('year_exam') == null) selected @endif>Барчаси
                                            </option>
                                            <option value="2021" @if (request('year_exam') == 2021) selected @endif> 2021
                                            </option>
                                            <option value="2022" @if (request('year_exam') == 2022) selected @endif> 2022
                                            </option>
                                            <option value="2023" @if (request('year_exam') == 2023) selected @endif> 2023
                                            </option>
                                            <option value="2024" @if (request('year_exam') == 2024) selected @endif> 2024
                                            </option>
                                            <option value="2025" @if (request('year_exam') == 2025) selected @endif> 2025
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control form-control-sm" id="quar_exam" onchange="myFilter()">
                                            <option value="" @if (request('quar_exam') == null) selected @endif>Барчаси
                                            </option>
                                            <option value="1" @if (request('quar_exam') == 1) selected @endif> 1 -
                                                чорак</option>
                                            <option value="2" @if (request('quar_exam') == 2) selected @endif> 2 -
                                                чорак</option>
                                            <option value="3" @if (request('quar_exam') == 3) selected @endif> 3 -
                                                чорак</option>
                                            <option value="4" @if (request('quar_exam') == 4) selected @endif> 4 -
                                                чорак</option>
                                        </select>
                                    </div>
                                </div>
                            </h6>
                        </div>

                        <div>Топшира олмаганлар / Яхши топширганлар.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 80%" aria-valuenow="80"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <a type="button" href="{{ route('exam_statistics') }}" class="btn btn-sm btn-success"><i
                                class="la la-eye"></i> Кўриш</a>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value text-warning">{{ $cadry30 }} / {{ $teacher_cadries }}</div>
                            <h6>Жорий йилда</h6>
                        </div>

                        <div>Ёш мутахассислар сони / Устозлар.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 30%" aria-valuenow="30"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <button class="btn btn-sm btn-warning text-white"><i class="la la-eye"></i> Кўриш</button>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value text-danger">{{ $cadries_demo }}</div>
                            <h6>
                                <div class="row">
                                    <div class="col">
                                        <select class="form-control form-control-sm" id="year_theme" onchange="myFilter()">
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
                                    <div class="col">
                                        <select class="form-control form-control-sm" id="month_theme" onchange="myFilter()">
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
                                            <option value="12" @if (request('month_theme') == 12) selected @endif>Декабрь  </option>
                                        </select>
                                    </div>
                                </div>
                            </h6>
                        </div>

                        <div>Машғулотга қатнашмаганлар сони.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 280%" aria-valuenow="280"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <button class="btn btn-sm btn-danger"><i class="la la-eye"></i> Кўриш</button>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value">0</div>
                            <h6>Жорий йилда</h6>
                        </div>

                        <div>Биринчи қишловчилар сони.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 280%" aria-valuenow="280"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <button class="btn btn-sm btn-info"><i class="la la-eye"></i> Кўриш</button>
                    </div>

                </div>
            </div>
            <div class="col-sm-6 col-lg-4">
                <div class="card border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="text-value text-info">0</div>
                            <h6>Ўтган йилда</h6>
                        </div>

                        <div>Малака оширганлар сони.</div>

                        <div class="progress progress-white progress-xs my-2">
                            <div class="progress-bar" role="progressbar" style="width: 280%" aria-valuenow="280"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        0 <small> - Имтихондан ўта олмаганлар сони.</small>
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
