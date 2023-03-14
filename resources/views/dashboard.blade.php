@extends(backpack_view('blank'))



@section('content')
    <div class="container-xl">

        <div class="row justify-content-between align-items-center mb-3">
            <div class="col flex-shrink-0 mb-5 mb-md-0">
                <h1>Статистика</h1>
                <div class="text-muted">барча корхоналар бўйича</div>
            </div>
        </div>

        <div class="row align-items-center mb-5">

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                <div id="cards_landscape_wrap-2">
                    <a href="javascript: void(0)" data-toggle="modal" data-target="#orgs">
                        <div class="card-flyer" style="min-height: 150px">
                            <div class="text-box">
                                <div class="text-container">
                                    <h6 class="text-success"> <i class="las la-users" style="font-size: 24px"></i> Жами
                                        ходимлар сони </h6>
                                    <p class="mb-0 mt-0" style="font-size: 20px; font-weight: bold">Хозирда</p>
                                    <p class="mb-0 mt-0 font-weight-bold text-primary" style="font-size: 20px">
                                        {{ $cadries }} та
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                <div id="cards_landscape_wrap-2">
                    <a href="javascript: void(0)" data-toggle="modal" data-target="#orgs">
                        <div class="card-flyer" style="min-height: 150px">
                            <div class="text-box">
                                <div class="text-container">
                                    <h6 class="text-warning"> <i class="las la-user-check" style="font-size: 24px"></i>
                                        Асосий касб эгалари</h6>
                                    <p class="mb-0 mt-0" style="font-size: 20px; font-weight: bold"> Хозирда </p>
                                    <p class="mb-0 mt-0 font-weight-bold text-primary" style="font-size: 20px">
                                        {{ $main_cadries }} та
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>



            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                <div id="cards_landscape_wrap-2">
                    <a href="javascript: void(0)" data-toggle="modal" data-target="#orgs">
                        <div class="card-flyer" style="min-height: 150px">
                            <div class="text-box">
                                <div class="text-container">
                                    <h6 class="" style="color: rgb(172, 30, 248)"> <i class="las la-snowflake"
                                            style="font-size: 24px"></i>
                                        Биринчи қишловчилар</h6>
                                    <p class="mb-0 mt-0" style="font-size: 20px; font-weight: bold"> Хозирда </p>
                                    <p class="mb-0 mt-0 font-weight-bold text-primary" style="font-size: 20px">
                                        {{ $cadrywinter }} та
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                <div id="cards_landscape_wrap-2">
                    <a href="javascript: void(0)" data-toggle="modal" data-target="#orgs">
                        <div class="card-flyer" style="min-height: 150px">
                            <div class="text-box">
                                <div class="text-container">
                                    <h6 class="" style="color: #6eaf05"> <i class="las la-user-tag"
                                            style="font-size: 24px"></i>
                                        Ёш мутахасссислар</h6>
                                    <p class="mb-0 mt-0" style="font-size: 20px; font-weight: bold"> Хозирда </p>
                                    <p class="mb-0 mt-0 font-weight-bold text-primary" style="font-size: 20px">
                                        {{ $cadry30 }} та
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                <div id="cards_landscape_wrap-2">
                    <a href="javascript: void(0)" data-toggle="modal" data-target="#orgs">
                        <div class="card-flyer" style="min-height: 150px">
                            <div class="text-box">
                                <div class="text-container">
                                    <h6 class="text-info"> <i class="las la-user-tie" style="font-size: 24px"></i>
                                        Йўриқчилар</h6>
                                    <p class="mb-0 mt-0" style="font-size: 20px; font-weight: bold"> Хозирда </p>
                                    <p class="mb-0 mt-0 font-weight-bold text-primary" style="font-size: 20px">
                                        {{ $teacher_cadries }} та
                                    </p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                <div id="cards_landscape_wrap-2">
                    <a href="{{ route('management_statistics') }}">
                        <div class="card-flyer" style="min-height: 150px">
                            <div class="text-box">
                                <div class="text-container">
                                    <h6> <i class="las la-graduation-cap" style="font-size: 24px"></i> Имтихон натижалари
                                    </h6>
                                    <p class="mb-0 mt-0" style="font-size: 20px; font-weight: bold">2022 йил, 4-чорак</p>
                                    <p class="mb-0 mt-0 font-weight-bold text-primary" style="font-size: 20px">
                                        {{ $second_exam }}%</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                <div id="cards_landscape_wrap-2">
                    <a href="javascript: void(0)" data-toggle="modal" data-target="#orgs_check">
                        <div class="card-flyer" style="min-height: 150px">
                            <div class="text-box">
                                <div class="text-container">
                                    <p class="text-danger mt-0 mb-0" style="font-size: 20px;font-weight: bold"> <i
                                            class="las la-user-minus" style="font-size: 24px"></i> Машғулотга
                                        қатнашмаганлар
                                    </p>
                                    <p class="mb-0 mt-0" style="font-size: 20px; font-weight: bold">Ўтган ойда</p>
                                    <p class="mb-0 mt-0 font-weight-bold text-primary" style="font-size: 20px">
                                        {{ $demo_cadry }} та</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                <div id="cards_landscape_wrap-2">
                    <a href="#">
                        <div class="card-flyer" style="min-height: 150px">
                            <div class="text-box">
                                <div class="text-container">
                                    <h6 class="text-success"> <i class="las la-smile" style="font-size: 24px"></i> Фаол
                                        ходимлар</h6>
                                    <p class="mb-0 mt-0" style="font-size: 20px; font-weight: bold">Хозирда (Скоро)</p>
                                    <p class="mb-0 mt-0 font-weight-bold text-primary" style="font-size: 20px"> 26 та</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                <div id="cards_landscape_wrap-2">
                    <a href="#">
                        <div class="card-flyer" style="min-height: 150px">
                            <div class="text-box">
                                <div class="text-container">
                                    <p class="text-dark mt-0 mb-0" style="font-size: 20px; font-weight: bold"> <i
                                            class="las la-user-times" style="font-size: 24px"></i> Билим савияси етарли
                                        даражада </p>
                                    <p class="mb-0 mt-0" style="font-size: 20px; font-weight: bold">бўлмаган ходимлар (Скоро)</p>
                                    <p class="mb-0 mt-0 font-weight-bold text-primary" style="font-size: 20px"> 26 та</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection

<div class="modal fade" id="orgs" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body table-responsive">
                <table class="bg-white table-sm table table-striped table-hover nowrap rounded shadow-xs border-xs"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Корхона</th>
                            <th>Ходимлар сони</th>
                            <th>Асосий касб эгалари</th>
                            <th>Биринчи қишловчилар</th>
                            <th>Ёш мутахасссислар</th>
                            <th>Йўриқчилар</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($organizations as $org)
                            <tr>
                                <td></td>
                                <td style="font-weight: bold"><i class="las la-sitemap"></i> {{ $org->name }}</td>
                                <td style="font-weight: bold"><a  class="text-primary" > <i class="las la-users"></i> {{ $org_cadries[$org->id]->count_cadriez ?? 0 }}</a> </td>
                                <td style="font-weight: bold"><a href="{{ route('view_cadries', ['org_id' => $org->id, 'cadry' => true]) }}" class="text-success"> <i class="las la-user-check"></i>
                                    {{ $org_main_cadries[$org->id] }} </td>
                                <td style="font-weight: bold"><a href="{{ route('view_cadries', ['org_id' => $org->id, 'winter' => true]) }}" class="text-warning"> <i class="las la-snowflake"></i>
                                    {{ $org_winter_cadries[$org->id] }} </td>
                                <td style="font-weight: bold"><a href="{{ route('view_cadries', ['org_id' => $org->id, 'cadry30' => true]) }}" class="text-danger"> <i class="las la-user-tag"></i>
                                    {{ $org_30_cadries[$org->id] }} </td>
                                <td style="font-weight: bold"><a href="{{ route('view_cadries', ['org_id' => $org->id, 'teacher' => true]) }}" class="text-dark"> <i
                                            class="las la-user-tie"></i> {{ $teacher_cadry[$org->id] }}</a> </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Корхона</th>
                            <th>Ходимлар сони</th>
                            <th>Асосий касб эгалари</th>
                            <th>Биринчи қишловчилар</th>
                            <th>Ёш мутахасссислар</th>
                            <th>Йўриқчилар</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="orgs_check" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body table-responsive">
                <table class="bg-white table-sm table table-striped table-hover nowrap rounded shadow-xs border-xs"
                    cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Корхона</th>
                            <th>Қатнашмаганлар сони</th>
                            <th>Сабабли</th>
                            <th>Сабабсиз</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($organizations as $org)
                            <tr>
                                <td></td>
                                <td style="font-weight: bold">
                                    <a href="{{ route('exam_themes') }}"><i class="las la-sitemap"></i>
                                        {{ $org->name }}</a>
                                </td>
                                <td class="text-dark" style="font-weight: bold"><i class="las la-ban"></i>
                                    {{ $demo_org_cadries[$org->id]['count'] }} </td>
                                <td class="text-warning" style="font-weight: bold"><i class="las la-plus"></i>
                                    {{ $demo_org_cadries[$org->id]['count_sababli'] }} </td>
                                <td class="text-danger" style="font-weight: bold"><i class="las la-minus"></i>
                                    {{ $demo_org_cadries[$org->id]['count_sababsiz'] }} </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Корхона</th>
                            <th>Қатнашмаганлар сони</th>
                            <th>Сабабли</th>
                            <th>Сабабсиз</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

@section('after_scripts')
    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script> --}}

@endsection

<style lang="scss">
    /*----  Main Style  ----*/
    #cards_landscape_wrap-2 {
        text-align: center;
        background: #F7F7F7;
    }

    #cards_landscape_wrap-2 a {
        text-decoration: none;
        outline: none;
    }

    #cards_landscape_wrap-2 .card-flyer {
        border-radius: 5px;
    }

    #cards_landscape_wrap-2 .card-flyer .image-box {
        background: #ffffff;
        overflow: hidden;
        box-shadow: 0px 2px 15px rgba(0, 0, 0, 0.50);
        border-radius: 5px;
    }

    #cards_landscape_wrap-2 .card-flyer .image-box img {
        -webkit-transition: all .9s ease;
        -moz-transition: all .9s ease;
        -o-transition: all .9s ease;
        -ms-transition: all .9s ease;
        width: 100%;
        height: 200px;
    }

    #cards_landscape_wrap-2 .card-flyer:hover .image-box img {
        opacity: 0.7;
        -webkit-transform: scale(1.15);
        -moz-transform: scale(1.15);
        -ms-transform: scale(1.15);
        -o-transform: scale(1.15);
        transform: scale(1.15);
    }

    #cards_landscape_wrap-2 .card-flyer .text-box {
        text-align: center;
    }

    #cards_landscape_wrap-2 .card-flyer .text-box .text-container {
        padding: 15px 15px;
    }

    #cards_landscape_wrap-2 .card-flyer {
        background: #FFFFFF;
        margin-top: 10px;
        -webkit-transition: all 0.2s ease-in;
        -moz-transition: all 0.2s ease-in;
        -ms-transition: all 0.2s ease-in;
        -o-transition: all 0.2s ease-in;
        transition: all 0.2s ease-in;
        box-shadow: 0px 3px 4px rgba(0, 0, 0, 0.40);
    }

    #cards_landscape_wrap-2 .card-flyer:hover {
        background: #fff;
        box-shadow: 0px 15px 26px rgba(0, 0, 0, 0.50);
        -webkit-transition: all 0.2s ease-in;
        -moz-transition: all 0.2s ease-in;
        -ms-transition: all 0.2s ease-in;
        -o-transition: all 0.2s ease-in;
        transition: all 0.2s ease-in;
        margin-top: 10px;
    }

    #cards_landscape_wrap-2 .card-flyer .text-box p {
        margin-top: 10px;
        margin-bottom: 0px;
        padding-bottom: 0px;
        font-size: 14px;
        letter-spacing: 1px;
        color: #000000;
    }

    #cards_landscape_wrap-2 .card-flyer .text-box h6 {
        margin-top: 0px;
        margin-bottom: 4px;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        font-family: 'Roboto Black', sans-serif;
        letter-spacing: 1px;
        color: #00acc1;
    }
</style>
