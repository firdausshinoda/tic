@extends('participan.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/participan')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/participan/videos')}}">Videos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Abstract</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12 row">
                <div class="col-12 col-sm-10 offset-sm-1">
                    <div class="card mb-3 shadow">
                        <div class="card-body">
                            <table class="table table-hover">
                                <tbody>
                                <tr class="text-center">
                                    <td class="p-1" colspan="2"><b>{{$detail->event." - ".$detail->tahun_event}}</b></td>
                                </tr>
                                <tr class="text-center">
                                    <td><b>{{$detail->scope}}</b></td>
                                    <td><b>{{$detail->no_abstrak}}</b></td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <p class="text-center"><b>{{$detail->judul_jurnal}}</b><br><i>{{$author_nama}}</i></p>
                                        <p class="text-center">{{$author_email}}<br>{{$author_institusi}}</p>
                                        <br>
                                        <p class="text-center"><b>Abstract</b></p>
                                        <?= $detail->abstrak_jurnal; ?>
                                        <p><b>Keywords:</b> {{$detail->keyword_jurnal}}</p>
                                        <p>
                                            <a href="{{url('/sub/'.$detail->slug.'/abstract/'.$detail->no_abstrak)}}">Share Link</a>
                                            <a target="_blank" href="https://confgate.net/2020/bismas/kfz/abstract.plain/ztfEpeRWM" class="d-none">Plain Format</a>
                                            <?php $corresponding = "";!empty($detail->nama_depan)?$corresponding .= $detail->nama_depan:'';!empty($detail->nama_tengah)?$corresponding .= ' '.$detail->nama_tengah:'';!empty($detail->nama_belakang)?' '.$corresponding .= $detail->nama_belakang:'';?>
                                            | <a href="{{url('/sub/'.$detail->slug.'/profile/'.$detail->no_author)}}">Corresponding Author (<?= $corresponding; ?>)
                                            </a>
                                        </p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            setAktifItem("videos");
        });
    </script>
@endsection
