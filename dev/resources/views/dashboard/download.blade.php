@extends('dashboard.template')

@section('konten')
    <section class="inner-header parallax-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><b>DOWNLOAD</b></h2>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container" style="margin: 15vh auto;">
            <h3 class="text-center"><b>FORMAT TEMPLATE</b></h3>
            <div class="row mt-5">
                <?php foreach ($dt_sub as $item): ?>
                    <div class="col-12 col-sm-6">
                        <a href="{{url('download?type=sub_template&file='.$item->template.'&name='.$item->sub)}}" class="text-decoration-none">
                            <div class="border p-3">
                                <div class="row">
                                    <div class="col-4 col-sm-4">
                                        <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/img/img-word.jpg'))}}" class="w-100">
                                    </div>
                                    <div class="col-8 col-sm-8">
                                        <h1 class="mt-1 mt-sm-4"><b>DOWNLOAD</b></h1>
                                        <h5>PAPER TEMPLATE</h5>
                                        <p>{{strtoupper($item->sub)}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
            <h3 class="text-center pt-5 mt-5"><b>AUTHOR GUIDELINE</b></h3>
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 pt-5">
                    <a href="{{url('download?type=guideline&us=author')}}" class="text-decoration-none">
                        <div class="border p-3">
                            <div class="row">
                                <div class="col-4 col-sm-4">
                                    <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/img/img-pdf.png'))}}" class="w-100">
                                </div>
                                <div class="col-8 col-sm-8">
                                    <h1 class="mt-5 pt-3"><b>DOWNLOAD</b></h1>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-download').addClass("active");
        });
    </script>
@endsection
