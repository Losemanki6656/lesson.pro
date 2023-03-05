@extends(backpack_view('blank'))



@section('content')
    <div class="container-xl">

        <div class="row justify-content-between align-items-center mb-3">
            <div class="col flex-shrink-0 mb-5 mb-md-0">
                <h1> Имтихон натижалари </h1>
                <div class="" style="font-weight: bold">Хўжаликлар бўйича</div>
            </div>
        </div>

        <div class="row align-items-center">
            @foreach ($managements as $item)
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                    <div id="cards_landscape_wrap-2">
                        <div class="card-flyer" style="min-height: 150px;">
                            <div class="text-box">
                                <div class="text-container">
                                    <h6
                                        @if ($a[$item->id] > 56) class="text-success"
                                        @elseif($a[$item->id] < 56 && $a[$item->id] > 56)
                                            class="text-warning"
                                        @else
                                            class="text-danger" @endif>
                                        <i class="las la-graduation-cap" style="font-size: 24px"></i>
                                        {{ $item->name }} - {{ $a[$item->id] }}%
                                    </h6>

                                    @foreach ($b[$item->id] as $arr)
                                        <a
                                            href="{{ route('exam_teachers', [
                                                'org_id' => $arr['organization_id'],
                                                'manag_id' => $arr['management_id'],
                                            ]) }}">
                                            <p class="mb-0 mt-0 font-weight-bold text-dark" style="font-size: 16px">
                                                <i class="lab la-first-order-alt"></i> {{ $arr['name'] }} -
                                                {{ $arr['koef'] }}%
                                            </p>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
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
