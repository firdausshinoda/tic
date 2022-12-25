@extends('sub.template')

@section('konten')
    <section class="bg-partikel-2" style="padding: 15vh 0;">
        <div class="container">
            <div class="row pt-5">
                <div class="col-sm-12">
                    <div class="card border-0 mb-3 shadow">
                        <div class="card-body row">
                            <div class="col-12 col-sm-3">
                                @if(empty($data->foto_author))
                                    <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/img/user_default.jpg'))}}" class="w-100">
                                @else
                                    <img src="{{\App\Helpers\Helpers::base64_encode_image(asset('/upload/author/'.$data->foto_author))}}" class="w-100">
                                @endif
                            </div>
                            <div class="col-12 col-sm-9 row">
                                <div class="col-sm-12 form-group">
                                    <label>Name</label>
                                    <div class="form-control h-auto">{{$data->nama_depan." ".$data->nama_tengah." ".$data->nama_belakang}}</div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>Institusion</label>
                                    <div class="form-control h-auto">{{$data->institusi}}</div>
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Last Education</label>
                                    <div class="form-control">{{$data->pddk_terakhir}}</div>
                                </div>
                                <div class="col-sm-12 col-md-6 form-group">
                                    <label>Research</label>
                                    <div class="form-control">{{$data->reserach}}</div>
                                </div>
                                <div class="col-sm-12 form-group">
                                    <label>Abstract</label>
                                    <div class="form-control h-auto">
                                        @if(empty($jurnal))
                                            NOTHING
                                        @else
                                            <ol class="text-justify">
                                                @foreach($jurnal as $item)
                                                    <li><a href="{{url('/sub/'.$slug.'/abstract/'.$item->no_abstrak)}}">{{$item->judul_jurnal}}</a></li>
                                                @endforeach
                                            </ol>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-list').addClass("active");
        });
    </script>
@endsection
