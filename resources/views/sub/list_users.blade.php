@extends('sub.template')

@section('konten')
    <section class="bg-partikel-2" style="padding: 15vh 0;">
        <div class="container">
            <h3 class="text-center pt-5"><b>LIST USERS</b></h3>
            <hr class="hr-title"/>
            <div class="row pt-5">
                @foreach($data as $item)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="card shadow">
                            @if(empty($item->foto_author))
                                <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/img/user_default.jpg'))}}" class="card-img img-crop">
                            @else
                                <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/upload/author/'.$item->foto_author))}}" class="card-img img-crop">
                            @endif
                            <div class="card-body" style="height: 160px;">
                                <a href="{{url('/sub/'.$slug.'/profile/'.$item->no_author)}}" class="text-decoration-none text-black"><h6 style="height:40px;overflow:hidden;"><b>{{$item->nama_depan." ".$item->nama_tengah." ".$item->nama_belakang}}</b></h6></a>
                                <p class="mb-0" style="font-size: 14px;color: rgba(0,0,0,.6);max-height:45px;overflow:hidden;"><?= $item->institusi; ?></p>
                                <p class="mb-0" style="font-size: 14px;color: rgba(0,0,0,.6);max-height:40px;overflow:hidden;"><?= $item->negara; ?></p>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-sm-12 text-center mt-5">
                    {{ $data->links('sub.custom_paginate') }}
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-list').addClass("active");
            $('#form-search').show();
        });
    </script>
@endsection
