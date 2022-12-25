@extends('sub.template')

@section('konten')
    <section style="padding: 15vh 0;">
        <div class="container">
            <h3 class="text-center pt-5"><b>DOWNLOAD</b></h3>
            <hr class="hr-title"/>
            <div class="mt-5 pt-5">
                <div class="row mt-5">
                    <div class="col-12 col-sm-6">
                        <h3 class="text-center"><b>FORMAT TEMPLATE</b></h3>
                        <a href="{{url('download?type=sub_template&file='.$dt_sub->template.'&name='.$dt_sub->sub)}}" class="text-decoration-none">
                            <div class="border p-3">
                                <div class="row">
                                    <div class="col-4 col-sm-4">
                                        <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/img/img-word.jpg'))}}" class="w-100">
                                    </div>
                                    <div class="col-8 col-sm-8">
                                        <h1 class="mt-1 mt-sm-4"><b>DOWNLOAD</b></h1>
                                        <h5>PAPER TEMPLATE</h5>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="text-center"><b>AUTHOR GUIDELINE</b></h3>
                        <a href="{{url('download?type=guideline&us=author')}}" class="text-decoration-none">
                            <div class="border p-3">
                                <div class="row">
                                    <div class="col-4 col-sm-4">
                                        <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/img/img-pdf.png'))}}" style="width: 80%;">
                                    </div>
                                    <div class="col-8 col-sm-8">
                                        <h1 class="mt-5"><b>DOWNLOAD</b></h1>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
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
