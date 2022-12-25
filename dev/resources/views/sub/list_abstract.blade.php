@extends('sub.template')

@section('konten')
    <section class="bg-partikel-3" style="padding: 15vh 0;">
        <div class="container">
            <h3 class="text-center pt-5"><b>LIST ABSTRACT</b></h3>
            <hr class="hr-title"/>
            <div class="row pt-5">
                <div class="col-sm-12 col-md-10 offset-md-1">
                    <div id="viewDokumen" class="row"></div>
                </div>
                <div class="col-sm-12">
                    <div id="loading-info" style="display: none">
                        <center>
                            <div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        var no_urut = 0;
        var start = 0;
        var search = "";
        var ttl_data = 0;
        var delay_ajax = 1000;
        $(document).ready(function () {
            $('#li-list').addClass("active");
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
                url: "{{url('api/journal')}}",
                beforeSend: function () {
                    $('#loading-info').fadeIn('slow');
                },
                success: function (response) {
                    if (response.status === "OK"){
                        var view_jurnal = "";
                        ttl_data = response.ttl;
                        start+=2;
                        if (ttl_data == 0) {
                            view_jurnal += '<div class="col-sm-12"><div class="text-center mt-5"><p style="color: #757575">No Journal</p></div></div>'
                        }
                        $.each(response.data, function (index,element) {
                            no_urut = no_urut+1;
                            view_jurnal += '<div class="col-sm-12">' +
                                '               <div class="card mb-3 shadow">' +
                                '                    <div class="card-body">' +
                                '                        <table class="table table-hover">' +
                                '                           <tbody>' +
                                '                           <tr class="text-center">' +
                                '                               <td colspan="3" class="p-1"><b>'+element.event+' - '+element.tahun_event+'</b></td>' +
                                '                           </tr>' +
                                '                            <tr class="text-center">' +
                                '                                <td><b>'+no_urut+'</b></td>' +
                                '                                <td><b>'+element.scope+'</b></td>' +
                                '                                <td><b>'+element.no_abstrak+'</b></td>' +
                                '                            </tr>' +
                                '                            <tr>' +
                                '                                <td colspan="3">' +
                                '                                    <p class="text-center"><b>'+element.title+'</b><br><i>'+element.author_nama+'</i></p>' +
                                '                                    <p class="text-center">'+element.author_email+'<br>'+element.author_institusi+'</p>' +
                                '                                    <br>' +
                                '                                    <p class="text-center"><b>Abstract</b></p>'+element.abstrac+
                                '                                    <p><b>Keywords:</b> '+element.keyword+'</p>' +
                                '                                    <p>' +
                                '                                        <a href="{{url('/sub')}}/'+element.slug+'/abstract/'+element.no_abstrak+'">Share Link</a>' +
                                '                                        | <a href="{{url('/sub')}}/'+element.slug+'/profile/'+element.no_author+'">Corresponding Author ('+setName_author(element.nama_depan,element.nama_tengah,element.nama_belakang)+')'+
                                '                                        </a>' +
                                '                                    </p>' +
                                '                                </td>' +
                                '                            </tr>' +
                                '                            </tbody>' +
                                '                        </table>' +
                                '                    </div>' +
                                '                </div>' +
                                '           </div>';
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
