@extends('sub.template')

@section('konten')
    <section class="bg-partikel-2" style="padding: 15vh 0;">
        <div class="container">
            <div class="row pt-5">
                <div class="col-sm-12">
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
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-list').addClass("active");
        });
    </script>
@endsection
