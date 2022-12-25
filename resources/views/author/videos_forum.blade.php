@extends('author.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/author')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/author/videos')}}">Videos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Forum</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12 row">
                <div class="col-12 col-sm-10 offset-sm-1">
                    <div class="card mb-3 shadow">
                        <div class="card-body">
                            <p class="text-center">{{$detail->event." - ".$detail->tahun_event}}</p>
                            <hr class="mt-0"/>
                            <iframe id="frame_video" class="w-100" style="height: 50vh"></iframe>
                            <p class="text-center">
                                <a target="_blank" id="link_video">Video Direct Link</a> | <a href="javascript:void(0)" id="btn_abstract">Abstract</a>
                            </p>
                            <table>
                                <tbody>
                                <tr>
                                    <td valign="top" class="w-25" id="no_abstrac"></td>
                                    <td valign="top"><a href="javascript:void(0)"  id="judul_jurnal"></a>
                                        <br><i>{{$author_nama}}</i>
                                        <?php $corresponding = "";!empty($detail->nama_depan)?$corresponding .= $detail->nama_depan:'';!empty($detail->nama_tengah)?$corresponding .= ' '.$detail->nama_tengah:'';!empty($detail->nama_belakang)?' '.$corresponding .= ' '.$detail->nama_belakang:'';?>
                                        <br>Corresponding Author: <a href="{{url('/sub/'.$detail->slug.'/profile/'.$detail->no_author)}}">{{$corresponding}}</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <hr class="my-0"/>
                        <div class="card-body" id="view_qa">
                        </div>
                        <hr class="my-0"/>
                        <div class="card-body">
                            <h6><b>Any Question?</b></h6>
                            <form id="formExecute" class="formExecute cmxform row">
                                <div class="col-8 col-sm-9 col-md-10 pr-0">
                                    <div class="form-group">
                                        <textarea class="form-control" id="et_question" name="et_question" rows="1" placeholder="Please fill in"></textarea>
                                        <input type="hidden" id="no_abs" name="no_abs">
                                        <input type="hidden" id="kd_author" name="kd_author">
                                    </div>
                                </div>
                                <div class="col-4 col-sm-3 col-md-2 pl-0">
                                    <button type="submit" class="btn btn-primary btn-block">SEND</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var slug = "<?= $detail->slug; ?>";
        var no_abs = getUrlVars()["abs"];
        $(document).ready(function () {
            setAktifItem("videos");
            getJurnal();
            autosize($('#et_question'));
        });
        function getJurnal() {
            loader_show();
            $.ajax({
                type: "GET", data:{no_abs:no_abs},
                url: "{{url('api/detailJournal')}}", dataType: 'json',
                success: function(response)
                {
                    loader_hide();
                    if (response.status==="OK"){
                        var data = response.data;
                        $('#frame_video').attr('src',setEmbed(data.link_video));
                        $('#btn_abstract').attr('href',"{{url('/author/videos/abstract?abs=')}}"+data.no_abstrak);
                        $('#link_video').attr('href',data.link_video);
                        $('#judul_jurnal').html(data.judul_jurnal);
                        $('#no_abstrac').html('<b>Abstract<br>'+data.no_abstrak+'</b>');
                        $('#no_abs').val(data.kode_abs);
                        $('#et_judul').val(data.judul_jurnal);
                        $('#kd_author').val(data.id_author);
                        getQA();
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
        function getQA() {
            loader_show();
            $.ajax({
                type: "GET", data:{no_abs:no_abs},
                url: "{{url('api/getJournalQAForum')}}", dataType: 'json',
                success: function(response) {
                    loader_hide();
                    if (response.status==="OK"){
                        var view_qa = "";
                        if (response.data.length === 0) {
                            view_qa = "<p class='text-center'><small>No Questions Yet</small></p>";
                        }
                        $.each(response.data, function (index,element) {
                            var view_qa_sub = "";
                            $.each(element.sub, function (index2,element2) {
                                var qa_sub_img_com = "{{asset('/img/user_default.jpg')}}";
                                var qa_sub_link_profile = "{{url('/sub')}}/"+element2.sub+"/profile/"+element2.no_author;
                                if (element2.foto_author !== null){
                                    if (element2.stt_user === "AUTHOR"){
                                        qa_sub_img_com = "{{asset('/upload/author')}}/"+element2.foto_author;
                                    } else {
                                        qa_sub_img_com = "{{asset('/upload/reviewer')}}/"+element2.foto_author;
                                    }
                                }
                                if (element2.stt_user === "REVIEWER"){
                                    qa_sub_link_profile = "javascript:void(0)";
                                }
                                view_qa_sub += '<table width="100%">' +
                                    '               <tbody>' +
                                    '                   <tr>' +
                                    '                       <td width="60" valign="top">' +
                                    '                           <img src="'+qa_sub_img_com+'" class="w-100 img-circle">' +
                                    '                       </td>' +
                                    '                       <td valign="top">' +
                                    '                           <p class="mb-0 p-2" style="background-color: #E4E6EB; border-radius: 20px;">' +
                                    '                               <b>Reply from</b> <a href="'+qa_sub_link_profile+'">'+element2.nama_author+'</a>' +
                                    '                               </br>'+element2.pertanyaan+
                                    '                           </p>'+
                                    '                           <i class="font-forum-comment-time"><i class="far fa-clock"></i> '+moment(element2.created_at).fromNow()+'</i>' +
                                    '                       </td>' +
                                    '                   </tr>' +
                                    '               </tbody>' +
                                    '       </table>';
                            });
                            var qa_img_com = "{{asset('/img/user_default.jpg')}}";
                            var qa_link_profile = "{{url('/sub')}}/"+slug+"/profile/"+element.no_author;
                            if (element.foto_author !== null){
                                if (element.stt_user === "AUTHOR"){
                                    qa_img_com = "{{asset('/upload/author')}}/"+element.foto_author;
                                } else {
                                    qa_img_com = "{{asset('/upload/reviewer')}}/"+element.foto_author;
                                }
                            }
                            if (element.stt_user === "REVIEWER"){
                                qa_link_profile = "javascript:void(0)";
                            }
                            view_qa += '<table class="w-100">' +
                                '           <tbody>' +
                                '               <tr>' +
                                '                   <td width="60" valign="top" class="p-2">' +
                                '                       <img id="imv_author" src="'+qa_img_com+'" class="w-100 img-circle border border-dark">' +
                                '                   </td>' +
                                '                   <td valign="top" class="p-2 font-forum-comment">' +
                                '                       <p class="mb-0 p-2" style="background-color: #E4E6EB; border-radius: 20px;">' +
                                '                           <b>Question from</b> <a href="'+qa_link_profile+'" target="_blank">'+element.nama_author+'</a>' +
                                '                           </br>'+element.pertanyaan+
                                '                       </p>' +
                                '                       <i class="font-forum-comment-time"><i class="far fa-clock"></i> '+moment(element.created_at).fromNow()+'</i>' +
                                '                       </br><small><b>Replies:</b></small><br/>'+view_qa_sub+
                                '                   </td>' +
                                '               </tr>' +
                                '           </tbody>' +
                                '       </table>';
                        });
                        $('#view_qa').html(view_qa);
                    } else {
                        swall_failed_text(response.message);
                    }
                }, error:function(data){
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
                                    type: "POST",data:values, url: "{{ url('/api/insertQAForum') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    $('#et_question').val('');
                                                    getQA();
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
