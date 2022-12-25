@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Videos</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12 row">
                <div class="col-12 col-sm-10 offset-sm-1">
                    <div id="viewDokumen" class="row"></div>
                </div>
                <div class="col-sm-12">
                    <div id="loading-info" class="display-none">
                        <center>
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            setAktifItem('videos');
        });

        var no_urut = 0;
        var start = 0;
        var search = "";
        var ttl_data = 0;
        var delay_ajax = 1000;
        $(function() {
            getData();
        });
        $(window).scroll(function() {
            if(Math.round($(window).scrollTop()) >= $(document).height() - $(window).height()) {
                if (start < ttl_data) {
                    getData();
                }
            }
        });
        $("#form-btn-search").click(function(){
            no_urut = 0;
            start = 0;
            ttl_data = 0;
            $('#viewDokumen').html('');
            getData();
        });
        function getData() {
            $.ajax({
                type: "GET", dataType: 'json',
                data: {offset:start,search:$('#form-input-search').val()},
                url: "{{url('api/getVideo')}}",
                beforeSend: function () {
                    $('#loading-info').fadeIn('slow');
                },
                success: function (response) {
                    if (response.status === "OK"){
                        var view_jurnal = "";
                        ttl_data = response.ttl;
                        start+=2;
                        if (response.data.length == 0) {
                            view_jurnal += '<div class="col-sm-12"><div class="text-center mt-5"><p style="color: #757575">No Videos</p></div></div>'
                        }
                        $.each(response.data, function (index,element) {
                            view_jurnal += '<div class="col-sm-12">' +
                                '               <div class="card mb-3 shadow">' +
                                '                        <div class="card-body">' +
                                '                            <table class="w-100 table table-hover">' +
                                '                                <tbody>' +
                                '                                <tr>' +
                                '                                    <td class="text-center p-1" colspan="3"><b>'+element.event+' - '+element.tahun_event+'</b></td>' +
                                '                                </tr>' +
                                '                                <tr>' +
                                '                                    <td class="text-center"><b>'+(index+1)+'</b></td>' +
                                '                                    <td class="text-center"><b>'+element.scope+'</b></td>' +
                                '                                    <td class="text-center"><b>'+element.no_abstrac+'</b></td>' +
                                '                                </tr>' +
                                '                                <tr>' +
                                '                                    <td colspan="3">' +
                                '                                        <p class="text-center">' +
                                '                                            <b>'+element.title+'</b>' +
                                '                                            <br><i>'+element.author_nama+'</i>' +
                                '                                            <br>Corresponding Author: <a href="{{url('sub')}}/'+element.slug+'/profile/'+element.no_author+'">'+setName_author(element.nama_depan,element.nama_tengah,element.nama_belakang)+'</a>' +
                                '                                        </p>' +
                                '                                        <div class="text-center">' +
                                '                                            <iframe src="'+setEmbed(element.link_video)+'" class="w-100" style="height:50vh;"></iframe>' +
                                '                                        </div>' +
                                '                                        <p class="text-center">' +
                                '                                            <a target="_blank" href="'+element.link_video+'">Video Direct Link</a>' +
                                '                                            | <a href="{{url('/admin/videos/abstract?abs=')}}'+element.no_abstrac+'">Abstract</a>' +
                                '                                            | <a href="{{url('/admin/videos/forum?abs=')}}'+element.no_abstrac+'">Q&amp;A Forum ('+element.ttl_qa+')</a>' +
                                '                                        </p>' +
                                '                                    </td>' +
                                '                                </tr>' +
                                '                                </tbody>' +
                                '                            </table>' +
                                '                        </div>' +
                                '                    </div>' +
                                '               </div>';
                        });
                        setTimeout(function(){
                            $('#viewDokumen').append(view_jurnal);
                            $('#loading-info').fadeOut('slow');
                        }, delay_ajax);
                    } else {
                        swall_failed_text(response.message);
                    }
                },
                error: function (data) {
                    $('#loading-info').fadeOut('slow');
                    swall_error();
                }
            });
        }
    </script>
@endsection
