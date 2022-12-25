@extends('sub.template')

@section('konten')
    <section>
        <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/upload/sub/'.$dt_sub->thumbnail))}}" style="width: 100%;">
    </section>
    <section>
        <div class="container">
            <div class="row mt-5 py-5">
                <div class="col-sm-12 col-md-6">
                    <h3 class="text-center"><b>BACKGROUND</b></h3><br/><br/>
                    <p class="text-justify"><?= $dt_sub->deskripsi; ?></p>
                </div>
                <div class="col-sm-12 col-md-6">
                    <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/img/bg-gedung-3.jpg'))}}" class="bg-tentang">
                    <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/img/bg-sub-1.png'))}}" class="w-100">
                </div>
            </div>
        </div>
    </section>
    <section style="padding: 15vh 0">
        <div class="container">
            <h2 class="font-weight-bold text-center mb-5">KEYNOTE SPEAKERS</h2>
            <div class="mb-2" id="v_page_keynote">
                <div class="text-right mt-3 mr-2">
                    <a href="javascript:void(0)" class="view-floating-sm bg-white scroll-left-keynote-speaker">
                        <i class="fas fa-angle-left text-dark"></i>
                    </a>
                    <a href="javascript:void(0)" class="view-floating-sm bg-white scroll-right-keynote-speaker">
                        <i class="fas fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            <div class="owl-carousel owl-theme" id="carousel-keynote-speaker">
                @foreach($dt_keynote as $item_keynote)
                    <div class="item">
                        <div class="row mr-0">
                            <div class="col-12 col-sm-9 pr-2">
                                <h4 class="text-uppercase"><b>{{$item_keynote->nama}}</b></h4>
                                <p class="text-justify pt-3">
                                    {{$item_keynote->institusi}}<br/><br/>
                                    <?= $item_keynote->topik; ?>
                                </p>
                            </div>
                            <div class="col-4 col-sm-3">
                                <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/upload/keynote_speaker/'.$item_keynote->thumbnail))}}" class="w-100 pl-4 pl-md-0">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container mt-5">
            <h2 class="font-weight-bold">INVITED SPEAKERS</h2>
            <div class="mb-2">
                <div class="text-right mt-3 mr-2">
                    <a href="javascript:void(0)" class="view-floating-sm bg-white scroll-left-invited-speaker">
                        <i class="fas fa-angle-left text-dark"></i>
                    </a>
                    <a href="javascript:void(0)" class="view-floating-sm bg-white scroll-right-invited-speaker">
                        <i class="fas fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            <div class="owl-carousel owl-theme" id="carousel-invited-speaker">
                @foreach($dt_invited as $item_invited)
                    <div class="item">
                        <div class="row mr-0 mb-5">
                            <div class="col-4 col-sm-3">
                                <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/upload/invited_speaker/'.$item_invited->thumbnail))}}" class="w-100 pl-4 pl-md-0" style="border-radius: 50px 0 20px 0;">
                            </div>
                            <div class="col-12 col-sm-9 pr-2">
                                <div class="card shadow border-0">
                                    <div class="card-body">
                                        <h4><b>{{$item_invited->nama}}</b></h4>
                                        <p class="text-justify pt-3">
                                            {{$item_invited->institusi}}<br/><br/>
                                            <?= $item_invited->topik; ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <h3 class="text-center"><b>CALL FOR PAPERS</b></h3>
            <div class="mt-5 px-md-5">
                <?= $dt_setting->call_for_paper; ?>
            </div>
        </div>
        <div class="container d-none py-5">
            <h2 class="font-weight-bold text-center pb-3">VIRTUAL CONVERENCE</h2>
            <div class="row">
                @foreach($dt_vc as $item_vc)
                    <div class="col-12 col-sm-4">
                        <a href="{{$item_vc->link}}" target="_blank" class="text-decoration-none text-dark">
                            <div class="card border-0">
                                <div class="card-body text-center">
                                    <i class="{{$item_vc->icon}} fa-5x"></i>
                                    <p><h4><b>{{$item_vc->judul}}</b></h4></p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="bg-partikel-1">
        <div class="container" style="padding: 12vh 0;">
            <div class="card border-0 shadow bg-white">
                <div class="card-header">
                    <h3 class="text-center pt-4 pb-4"><b>LIST OF SCOPES<br/>({{$dt_sub->sub}})</b></h3>
                    <table class="table table-hover">
                        <thead class="text-center">
                        <tr>
                            <th>Scope</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dt_scope as $key => $item_scope)
                            <tr class="text-center">
                                <td>{{$item_scope->scope}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <section style="padding: 15vh 0;">
        <div class="container">
            <div class="mb-3 ml-0 mr-0">
                <h3 class="text-center"><b>TIMELINE</b></h3>
                <p class="text-center">
                    Tegal International Conference Event Schedule
                </p>
                <div class="owl-carousel owl-theme mt-4" id="carousel-timeline">
                    @foreach($dt_timeline as $key => $item_timeline)
                        <div class="item">
                            <div class="card shadow border-0 ml-2 mb-2">
                                <div class="card-body">
                                    <h5 class="text-center"><b>{{$key+1}}</b></h5>
                                    <h5 class="text-center"><b>{{$item_timeline['date']." ".$item_timeline['month']." ".$item_timeline['year']}}</b></h5>
                                    <div style="min-height: 15vh;display: flex;justify-content: center; align-items: center;">
                                        <p class="text-center">{{$item_timeline['timeline']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section style="padding: 15vh 0;">
        <div class="container text-center">
            <h3 class="pl-4"><b>CONFERENCE DAY</b></h3>
            <div id="countdown">
                <ul class="mb-0">
                    <li>
                        <span id="days" style="font-size: 2rem"></span>DAYS
                    </li>
                    <li>
                        <span id="hours" style="font-size: 2rem"></span>HOURS
                    </li>
                    <li>
                        <span id="minutes" style="font-size: 2rem"></span>MINUTES
                    </li>
                    <li>
                        <span id="seconds" style="font-size: 2rem"></span>SECONDS
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section style="padding-bottom: 15vh;display:none;">
        <div class="container">
            <h6>Indexed By</h6>
            <div class="owl-carousel owl-theme" id="carousel-index">
                @foreach($dt_indexing as $item_indexing)
                    <div class="item">
                        <div class="card shadow border-0 ml-2 mb-2">
                            <div class="card-body">
                                <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/upload/index/'.$item_indexing->logo))}}" class="card-img" style="height: 7vh">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-home').addClass("active");
            setCountDown();
            var owl_keynotespeaker = $("#carousel-keynote-speaker").owlCarousel({
                loop:true,
                margin:10,
                nav:false,
                responsive:{
                    0:{items:1},
                },
                smartSpeed: 1000,
                autoplay:true,
                dots: true,
                autoplayTimeout:3000,
                autoplayHoverPause:true
            });
            $(".scroll-right-keynote-speaker").click(function() {
                owl_keynotespeaker.trigger('prev.owl.carousel');
            });
            $(".scroll-left-keynote-speaker").click(function() {
                owl_keynotespeaker.trigger('next.owl.carousel');
            });
            var owl_invited_speaker = $("#carousel-invited-speaker").owlCarousel({
                loop:true,
                margin:10,
                nav:false,
                responsive:{
                    0:{items:1},
                },
                smartSpeed: 1000,
                autoplay:true,
                dots: true,
                autoplayTimeout:3000,
                autoplayHoverPause:true
            });
            $(".scroll-left-invited-speaker").click(function() {
                owl_invited_speaker.trigger('prev.owl.carousel');
            });
            $(".scroll-right-invited-speaker").click(function() {
                owl_invited_speaker.trigger('next.owl.carousel');
            });
            var owl_carousel_timeline = $("#carousel-timeline").owlCarousel({
                loop:true,
                margin:10,
                nav:false,
                responsive:{
                    0:{items:2},
                    600:{items:4},
                },
                smartSpeed: 1000,
                autoplay:true,
                dots: false,
                autoplayTimeout:2000,
                autoplayHoverPause:true
            });
            var owl_carousel_index = $("#carousel-index").owlCarousel({
                loop:true,
                margin:10,
                nav:false,
                responsive:{
                    0:{items:2},
                    600:{items:5},
                },
                smartSpeed: 1000,
                autoplay:true,
                dots: true,
                autoplayTimeout:2000,
                autoplayHoverPause:true
            });
        });
        function setCountDown() {
            (function () {
                const second = 1000,
                    minute = second * 60,
                    hour = minute * 60,
                    day = hour * 24;
                let birthday = "{{$dt_setting->tgl_conference}} 00:00:00",
                    countDown = new Date(birthday).getTime(),
                    x = setInterval(function() {
                        let now = new Date().getTime(), distance = countDown - now;
                        document.getElementById("days").innerText = Math.floor(distance / (day)),
                            document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
                            document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                            document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);
                        if (distance < 0) {
                            clearInterval(x);
                            document.getElementById("days").innerText = Math.floor(0);
                            document.getElementById("hours").innerText = Math.floor(0);
                            document.getElementById("minutes").innerText = Math.floor(0);
                            document.getElementById("seconds").innerText = Math.floor(0);
                            $('#countdown').append("<h5 class='text-danger'>CONFERENCE STARTING SOON</h5>")
                        }
                    }, 0)
            }());
        }
    </script>
@endsection
