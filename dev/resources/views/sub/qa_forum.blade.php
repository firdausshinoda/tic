@extends('sub.template')

@section('konten')
    <section class="bg-partikel-3" style="padding: 15vh 0;">
        <div class="container">
            <h3 class="text-center pt-5"><b>QA FORUM</b></h3>
            <hr class="hr-title"/>
            <div class="row pt-5">
                <div class="col-sm-12 col-md-10">
                    <label class="select mb-5" for="slct">
                        <select id="order" name="order" onchange="changeOrder()">
                            <option value="DESC">LATEST</option>
                            <option value="ASC">OLDEST</option>
                        </select>
                        <svg><use xlink:href="#select-arrow-down"></use></svg>
                    </label>
                    <svg class="sprites">
                        <symbol id="select-arrow-down" viewbox="0 0 10 6">
                            <polyline points="1 1 5 5 9 1"></polyline>
                        </symbol>
                    </svg>
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
            $('#li-qa-forum').addClass("active");
            $('#form-search').show();
            getData();
        });
        $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() >= $(document).height()) {
                if (start < ttl_data) {
                    getData();
                }
            }
        });
        function changeOrder(){
            no_urut = 0;
            start = 0;
            ttl_data = 0;
            $('#viewDokumen').html('');
            getData();
        }
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
                data: {offset:start,search:$('#form-input-search').val(),order:$('#order').val()},
                url: "{{url('api/getForum')}}",
                beforeSend: function () {
                    $('#loading-info').fadeIn('slow');
                },
                success: function (response) {
                    if (response.status === "OK"){
                        var view_jurnal = "";
                        ttl_data = response.ttl;
                        start+=2;
                        if (response.data.length == 0) {
                            view_jurnal += '<div class="col-sm-12"><div class="text-center mt-5"><p style="color: #757575">No Forum</p></div></div>'
                        }
                        $.each(response.data, function (index,element) {
                            no_urut = no_urut+1;
                            var img = "{{\App\Helpers\Helpers::base64_encode_image(asset('img/user_default.jpg'))}}";
                            if (element.stt_user === "AUTHOR"){
                                if (element.foto_author_qa !== null){
                                    img = "{{asset('upload/author')}}/"+element.foto_author_qa;
                                }
                            } else {
                                if (element.foto_author_qa !== null){
                                    img = "{{asset('upload/reviewer')}}/"+element.foto_author_qa;
                                }
                            }
                            view_jurnal += '<div class="col-sm-12">' +
                                '               <div class="card shadow border-0 mb-2">' +
                                '                        <div class="card-body row">' +
                                '                            <div class="col-2 text-center">' +
                                '                                <img src="'+img+'" class="w-75 img-circle">' +
                                '                            </div>' +
                                '                            <div class="col-10">' +
                                '                                <h4 style="color: rgba(0,0,0,.6)"><b>'+setName_author(element.nama_depan_qa,element.nama_tengah_qa,element.nama_belakang_qa)+'</b></h4>' +
                                '                                <p style="color: rgba(0,0,0,.5);font-size: 13px">' +
                                '                                    <i class="fas fa-share"></i>' +element.judul_jurnal +
                                '                                     <a href="{{url('sub/'.$slug.'/profile')}}/'+element.no_author+'" class="text-decoration-none">'+setName_author(element.nama_depan,element.nama_tengah,element.nama_belakang)+'</a> <b>'+moment(element.created_at).fromNow()+'</b>' +
                                '                                </p>' +
                                '                                <p class="text-justify mt-2" style="color: rgba(0,0,0,.7)">' +element.pertanyaan+
                                '                                </p>' +
                                '                                <p style="color: rgba(0,0,0,.5);font-size: 13px;">' +
                                '                                    <a href="{{url('sub/'.$slug.'/qa-forum')}}/'+element.no_abstrak+'/'+element.id+'" class="text-decoration-none" style="color: rgba(0,0,0,.7);"><b><i class="far fa-comment"></i> '+element.ttl+' Comments</b></a>' +
                                '                                </p>' +
                                '                            </div>' +
                                '                        </div>' +
                                '                    </div>' +
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
