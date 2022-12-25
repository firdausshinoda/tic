@extends('reviewer.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/reviewer')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/reviewer/my_question')}}">My Question</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12 row">
                <div class="col-12 col-sm-10 offset-sm-1">
                    <div class="card mb-3 shadow">
                        <div class="card-body">
                            <p class="text-center" id="tx_event"></p>
                            <hr class="mt-0"/>
                            <iframe id="link_video_embed" class="w-100" style="height: 50vh"></iframe>
                            <p class="text-center">
                                <a target="_blank" id="link_video">Video Direct Link</a> | <a href="javascript:void(0)" id="btn_abstract">Abstract</a>
                            </p>
                            <table>
                                <tbody>
                                <tr>
                                    <td colspan="2" id="tx_event"></td>
                                </tr>
                                <tr>
                                    <td valign="top" id="tx_no_abstrac" class="w-25"></td>
                                    <td valign="top"><a href="javascript:void(0)" id="tx_judul_jurnal"></a>
                                        <br><i id="tx_nama_author"></i>
                                        <br>Corresponding Author: <a id="tx_corresponding"></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </p>
                        </div>
                    </div>
                    <div class="card mb-3 shadow">
                        <div class="card-body">
                            <table class="w-100">
                                <tbody>
                                <tr>
                                    <td>
                                        <table class="w-100">
                                            <tbody>
                                            <tr>
                                                <td width="70" valign="top" class="p-2">
                                                    <img id="imv_author" class="w-100 img-circle">
                                                </td>
                                                <td valign="top" class="p-2 font-forum-comment">
                                                    <p class="font-forum-comment">Question from <a id="a_nama_comment"></a><br><i id="tx_cdate" style="font-size: 12px"></i></p>
                                                    <p id="tx_question"></p>
                                                    <hr class="mb-1 mt-1">
                                                    <b>Replies:</b>
                                                    <div id="view_qa_sub"></div>
                                                    <form id="formExecute" class="formExecute cmxform">
                                                        <div class="form-group">
                                                            <textarea class="form-control" id="et_question" name="et_question" rows="2" placeholder="Please fill in"></textarea>
                                                            <input type="hidden" id="tx_kd" name="tx_kd">
                                                            <input type="hidden" id="tx_abs" name="tx_abs">
                                                        </div>
                                                        <button type="submit" class="btn btn-primary float-right">SEND</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table></p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
        var no_abs = getUrlVars()["abs"];
        var kd = getUrlVars()["kd"];
        $(document).ready(function () {
            setAktifItem("my_question");
            getJurnal();
        });
        function getJurnal() {
            loader_show();
            $.ajax({
                type: "GET", data:{no_abs:no_abs,kd:kd},
                url: "{{url('api/detailQAForum')}}", dataType: 'json',
                success: function(response)
                {
                    loader_hide();
                    if (response.status==="OK"){
                        var dt_jurnal = response.jurnal;

                        $('#tx_event').html(dt_jurnal.event+" - "+dt_jurnal.tahun_event);
                        $('#link_video_embed').attr('src',setEmbed(dt_jurnal.link_video));
                        $('#btn_abstract').attr('href',"{{url('/author/videos/abstract?abs=')}}"+dt_jurnal.no_abstrak);
                        $('#link_video').attr('href',dt_jurnal.link_video);

                        $('#tx_corresponding').attr('href',"{{url('/sub')}}/"+dt_jurnal.slug+"/profile/"+dt_jurnal.no_author);
                        $('#tx_corresponding').html(setName_author(dt_jurnal.nama_depan,dt_jurnal.nama_tengah,dt_jurnal.nama_belakang));
                        $('#tx_nama_author').html(dt_jurnal.nama_author);
                        $('#tx_nama_author').html(dt_jurnal.nama_author);
                        $('#tx_judul_jurnal').html(dt_jurnal.judul_jurnal);
                        $('#tx_no_abstrac').html('<b>Abstract<br>'+dt_jurnal.no_abstrak+'</b>')

                        var stt_user = "";
                        if (dt_jurnal.stt_user==="AUTHOR"){
                            $('#a_nama_comment').attr('href',"{{url('/sub')}}/"+dt_jurnal.slug+"/profile/"+dt_jurnal.qa_no_author);
                        } else {
                            $('#a_nama_comment').attr('href',"javascript:void(0)");
                            stt_user = " (Reviewer)";
                        }
                        $('#a_nama_comment').html(setName_author(dt_jurnal.qa_nama_depan,dt_jurnal.qa_nama_tengah,dt_jurnal.qa_nama_belakang))+stt_user;
                        var img_com = "{{asset('/img/user_default.jpg')}}";
                        if (dt_jurnal.qa_foto_author !== null){
                            if (dt_jurnal.stt_user === "AUTHOR"){
                                img_com = "{{asset('/upload/author')}}/"+dt_jurnal.qa_foto_author
                            } else {
                                img_com = "{{asset('/upload/reviewer')}}/"+dt_jurnal.qa_foto_author
                            }
                        }
                        $('#imv_author').attr('src',img_com);
                        $('#tx_question').html(dt_jurnal.pertanyaan);
                        $('#tx_cdate').html(moment(dt_jurnal.created_at).fromNow());
                        $('#tx_kd').val(kd);
                        $('#tx_abs').val(dt_jurnal.kode_abs);

                        var view_qa_sub = "";
                        $.each(response.qa, function (index,element) {
                            var qa_sub_img_com = "{{asset('/img/user_default.jpg')}}";
                            var qa_sub_link_profile = "";
                            var nama_qa_sub = "";
                            if (element.stt_user === "AUTHOR"){
                                qa_sub_link_profile = "{{url('/sub')}}/"+element.sub+"/profile/"+element.no_author;
                                nama_qa_sub = setName_author(element.nama_depan,element.nama_tengah,element.nama_belakang);
                                if (element.foto_author !== null){
                                    qa_sub_img_com = "{{asset('/upload/author')}}/"+element.foto_author;
                                }
                            } else {
                                qa_sub_link_profile = "javascript:void(0)";
                                nama_qa_sub = setName_author(element.r_nama_depan,element.r_nama_tengah,element.r_nama_belakang)+" (Reviewer)";
                                if (element.foto_reviewer !== null){
                                    qa_sub_img_com = "{{asset('/upload/reviewer')}}/"+element.foto_reviewer;
                                }
                            }
                            view_qa_sub += '<table width="100%" cellpadding="5" border="0">' +
                                '                                        <tbody>' +
                                '                                        <tr>' +
                                '                                            <td width="50" valign="top">' +
                                '                                                <img src="'+qa_sub_img_com+'" class="w-100 img-circle">' +
                                '                                            </td>' +
                                '                                            <td valign="top">' +
                                '                                                <p class="mb-0">' +
                                '                                                    Reply from <a href="'+qa_sub_link_profile+'">'+nama_qa_sub+'</a>' +
                                '                                                    <br><i class="font-forum-comment-time"><i class="far fa-clock"></i> '+moment(element.created_at).fromNow()+'</i>' +
                                '                                                </p>' +element.pertanyaan+
                                '                                            </td>' +
                                '                                        </tr>' +
                                '                                    </tbody>' +
                                '                                </table><hr class="mt-1 mb-1"/>';
                        });
                        $('#view_qa_sub').html(view_qa_sub);
                    } else {
                        swall_failed_text(response.message);
                    }
                },
                error:function(data){
                    loader_hide();
                    swall_error();
                }
            });
        }
        $(function() {
            $('#formExecute').validate({
                rules: {et_question:{ required:true,},},
                messages: {et_question:{required:'Please fill in',},},
                submitHandler: function(form) {
                    swalWithBootstrapButtons.fire({
                        text: 'Are you sure?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        showLoaderOnConfirm: true,
                        preConfirm: function () {
                            return new Promise(function (resolve) {
                                loader_show();
                                var values = $('#formExecute').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/insertQAForumSub') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    $('#et_question').val('');
                                                    getJurnal()();
                                                }
                                            });
                                        } else {
                                            swall_failed_text(response.message);
                                        }
                                    },
                                    error:function(response){
                                        loader_hide();
                                        swall_error();
                                    }
                                });
                            })
                        },
                        allowOutsideClick: false,
                    });
                }
            });
        });
    </script>
@endsection
