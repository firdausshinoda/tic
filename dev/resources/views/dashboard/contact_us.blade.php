@extends('dashboard.template')

@section('konten')
    <section class="inner-header parallax-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><b>CONTACT US</b></h2>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 15vh auto;">
            <div class="row">
                <div class="col-sm-12 col-md-8">
                    <iframe style="border:none; height: 70vh;" class="google-map w-100" id="contact-page-google-map" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyDwMcyoyB7YIzDvhk1vskhg-Gjpsb__fvk&q=Politeknik+Harapan+Bersama&zoom=13"></iframe>
                </div>
                <div class="col-sm-12 col-md-4">
                    <ul class="contact-info">
                        @foreach($dt_kontak as $it_kontak_2)
                            <li>
                                <div class="icon-box">
                                    <div class="inner">
                                        <i class="{{$it_kontak_2->icon}}"></i>
                                    </div>
                                </div>
                                <div class="content-box">
                                    <h4 class="mb-1">{{$it_kontak_2->judul}}</h4>
                                    <p class="mb-0">{{$it_kontak_2->isi}}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-contact-us').addClass("active");
        });
    </script>
@endsection
