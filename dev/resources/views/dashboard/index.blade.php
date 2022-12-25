@extends('dashboard.template')

@section('konten')
    <section id="index-page-top">
        <div class="container">
            <div class="bg-index"></div>
            <div class="row">
                <div class="col-sm-12 col-md-6 text-light" style="margin-top: 30vh;">
                    <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('img/logo.png'))}}" class="w-100">
                    <div class="border-left border-dark">
                        <p class="text-justify ml-2 text-dark">
                            <?= strip_tags($dt_tema); ?>
                        </p>
                    </div>
                    @if(count($dt_kerjasama)>0)
                        <p class="mt-3 mb-0">Collaboration With</p>
                        <div class="owl-carousel owl-theme" id="carousel-kerjasama">
                            @foreach($dt_kerjasama as $item)
                                <div class="item">
                                    <a href="{{$item->link}}" target="_blank" title="{{$item->nama}}">
                                        <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/upload/kerjasama/'.$item->logo))}}" style="width:3vw;height: 3vw;" alt="{{$item->nama}}" class="lazy">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    @if(count($dt_cohost)>0)
        <section>
            <div class="container" style="margin-top: 10vh">
                <h3 class="text-center"><b>CO-HOST</b></h3>
                <div class="owl-carousel owl-theme my-5" id="carousel-cohost">
                    @foreach($dt_cohost as $item)
                        <div class="item">
                            <a href="{{$item->link}}" target="_blank" title="{{$item->nama}}">
                                <img data-src="{{\App\Helpers\Helpers::base64_encode_image(asset('/upload/co_host/'.$item->thumbnail))}}" style="width:100%;" alt="{{$item->nama}}" class="lazy">
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    <section>
        <div class="container">
            <div class="row mt-5 py-5">
                <div class="col-sm-12 col-md-8">
                    <h3 class="text-center"><b>BACKGROUND</b></h3><br/><br/>
                    <p class="text-justify">
                        <?= $dt_deskripsi_panjang; ?>
                    </p>
                </div>
                <div class="col-sm-12 col-md-4">
                    <img data-src="{{\App\Helpers\Helpers::base64_encode_image(asset('/upload/event/thumbnail/'.$dt_pamflet->pamflet))}}" class="w-100 lazy d-none">
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container py-5">
            <div class="card shadow border-0 bg-persegipanjang">
                <div class="card-body text-center text-light">
                    <h2 class="font-weight-bold">THEME</h2>
                    <?= $dt_tema; ?>
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
    <section style="padding: 0 0 15vh 0;" class="bg-partikel-3">
        <div class="container">
            <h3 class="text-center"><b>CALL FOR PAPERS</b></h3>
            <div class="mt-5 px-md-5">
               <?= $dt_call_for_paper; ?>
            </div>
        </div>
        <div class="container" style="margin-top: 15vh">
            <h3 class="text-center"><b>SYMPOSIA</b></h3>
            <h5 class="text-center mt-5">Two symposia, <b>TIC on Applied Sciences</b> and <b>TIC on Applied Social Sciences & Humanities</b> with suitable sub themes will be presented this year.</h5>
            <div class="row mt-5 px-md-5">
                @foreach($dt_kategori as $item_kategori)
                    <div class="col-12 col-sm-6">
                        <a href="{{url('/sub/'.$item_kategori->slug)}}" class="text-decoration-none">
                            <div class="card shadow bg-transparent">
                                <img data-src="{{\App\Helpers\Helpers::base64_encode_image(asset('upload/sub/'.$item_kategori->thumbnail))}}" class="w-100  lazy">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div style="margin-top: 15vh">
            <div class="container">
                <div class="mb-3 ml-0 mr-0">
                    <h3 class="text-center"><b>IMPORTANT DATES</b></h3>
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
        </div>
        <div style="margin-top: 15vh;display:none;">
            <div class="container mt-5">
                <h3 class="text-center"><b>PUBLICATION OPPORTUNITIES</b></h3>
                <div class="mt-5 text-center">
                    <h5><?= strip_tags($dt_publication_opportunity); ?></h5>
                </div>
            </div>
        </div>
        <div style="margin-top: 15vh; display: none;">
            <div class="container mt-5">
                <h6>Indexed By</h6>
                <div class="owl-carousel owl-theme" id="carousel-index">
                    @foreach($dt_indexing as $item_indexing)
                        <div class="item">
                            <div class="card shadow border-0 ml-2 mb-2">
                                <div class="card-body">
                                    <img data-src="{{\App\Helpers\Helpers::base64_encode_image(asset('/upload/index/'.$item_indexing->logo))}}" class="card-img lazy" style="height: 7vh">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        var ttl_keynote = "<?= count($dt_invited); ?>";
        $(document).ready(function () {
            $('#li-home').addClass("active");
        });
        var owl_keynote_cohost = $("#carousel-cohost").owlCarousel({
            loop:true,
            margin:10,
            center:false,
            nav:false,
            rtl:false,
            responsive:{
                400:{items:8},
                800:{items:11},
                1400:{items:14},
            },
            smartSpeed: 1000,
            autoplay:true,
            dots: true,
            autoplayTimeout:3000,
            autoplayHoverPause:true
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
            dots: true,
            autoplayTimeout:2500,
            autoplayHoverPause:true
        });
        var owl_keynote_kerjasama = $("#carousel-kerjasama").owlCarousel({
            loop:true,
            margin:10,
            nav:false,
            rtl:true,
            responsive:{
                0:{items:2},
                600:{items:7},
            },
            smartSpeed: 1000,
            autoplay:true,
            dots: true,
            autoplayTimeout:3000,
            autoplayHoverPause:true
        });
        if (parseInt(ttl_keynote) > 0){
            $('#v_page_keynote').show();
        } else {
            $('#v_page_keynote').hide();
        }
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
        $("#carousel-index").owlCarousel({
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
        $("#carousel-bank").owlCarousel({
            loop:true,
            margin:10,
            nav:false,
            responsive:{
                0:{items:1},
                1030:{items:2},
                1980: {item:3},
            },
            smartSpeed: 5000,
            autoplay:true,
            dots: true,
            autoplayTimeout:6000,
            autoplayHoverPause:true
        });
    </script>
@endsection
