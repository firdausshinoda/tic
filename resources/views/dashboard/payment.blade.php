@extends('dashboard.template')

@section('konten')
    <section class="inner-header parallax-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><b>PAYMENT</b></h2>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 15vh auto;">
            <h3 class="text-center"><b>FEE AND PAYMENT</b></h3>
            <div class="row mt-5">
                <?= $dt_fee; ?>
            </div>
            <div class="owl-carousel owl-theme pt-3" id="carousel-bank">
                @foreach($dt_bank as $item)
                    <div class="item">
                        <div class="card shadow border-0 ml-2 mb-2">
                            <div class="card-body">
                                <table>
                                    <tbody>
                                    <tr>
                                        <td><small>Bank Name</small></td>
                                        <td>:</td>
                                        <td><small><?= $item->nama_jenis_pembayaran; ?></small></td>
                                    </tr>
                                    <tr>
                                        <td><small>Swift/BIC</small></td>
                                        <td>:</td>
                                        <td><small>Code Abstract or Participant</small></td>
                                    </tr>
                                    <tr>
                                        <td><small>Account Number</small></td>
                                        <td>:</td>
                                        <td><small><?= $item->nomor_jenis_pembayaran; ?></small></td>
                                    </tr>
                                    <tr>
                                        <td><small>Account Holder</small></td>
                                        <td>:</td>
                                        <td><small><?= $item->an_jenis_pembayaran; ?></small></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    @if(!empty($item->logo_1))
                                        <div class="col-2 col-sm-2 col-md-2">
                                            <img src="{{Helpers::base64_encode_image(asset('upload/jenis_pembayaran/'.$item->logo_1))}}" class="img-crop-payment-icon">
                                        </div>
                                    @endif
                                    @if(!empty($item->logo_2))
                                        <div class="col-2 col-sm-2 col-md-2">
                                            <img src="{{Helpers::base64_encode_image(asset('upload/jenis_pembayaran/'.$item->logo_2))}}" class="img-crop-payment-icon">
                                        </div>
                                    @endif
                                    @if(!empty($item->logo_3))
                                        <div class="col-2 col-sm-2 col-md-2">
                                            <img src="{{Helpers::base64_encode_image(asset('upload/jenis_pembayaran/'.$item->logo_3))}}" class="img-crop-payment-icon">
                                        </div>
                                    @endif
                                    @if(!empty($item->logo_4))
                                        <div class="col-2 col-sm-2 col-md-2">
                                            <img src="{{Helpers::base64_encode_image(asset('upload/jenis_pembayaran/'.$item->logo_4))}}" class="img-crop-payment-icon">
                                        </div>
                                    @endif
                                    @if(!empty($item->logo_5))
                                        <div class="col-2 col-sm-2 col-md-2">
                                            <img src="{{Helpers::base64_encode_image(asset('upload/jenis_pembayaran/'.$item->logo_5))}}" class="img-crop-payment-icon">
                                        </div>
                                    @endif
                                </div>
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
            $('#li-registration').addClass("active");
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
