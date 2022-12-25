@extends('reviewer.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/reviewer')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/reviewer/my_review')}}">My Review</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card mb-2">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-paper-tab" data-toggle="pill" href="#pills-paper" role="tab" aria-controls="pills-paper" aria-selected="true">JOURNAL</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-video-tab" data-toggle="pill" href="#pills-video" role="tab" aria-controls="pills-video" aria-selected="false">VIDEO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-suplementari-tab" data-toggle="pill" href="#pills-suplementari" role="tab" aria-controls="pills-suplementari" aria-selected="false">SUPPLEMENTARY FILES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-revision-tab" data-toggle="pill" href="#pills-revision" role="tab" aria-controls="pills-revision" aria-selected="false">REVIEW RESULT</a>
                        </li>
                    </ul>
                </div>
                <div class="card shadow-sm mb-2">
                    <div class="card-body row">
                        <div class="col">
                            <p class="mb-0" id="p_text"></p>
                            <div class="countdown" id="countdown_review">
                                <ul>
                                    <li class="text-center"><span class="tx_countdown" id="days_review">:</span>DAYS</li>
                                    <li>:</li>
                                    <li class="text-center"><span class="tx_countdown" id="hours_review"></span>HOURS</li>
                                    <li>:</li>
                                    <li class="text-center"><span class="tx_countdown" id="minutes_review"></span>MINUTES</li>
                                    <li>:</li>
                                    <li class="text-center"><span class="tx_countdown" id="seconds_review"></span>SECONDS</li>
                                </ul>
                            </div>
                        </div>
                        <div class="col">
                            <p class="mb-0"><b><u>REVIEW DATE</u></b></p>
                            <h5>{{Helpers::setTglSurat($tgl_mulai)." - ".Helpers::setTglSurat($tgl_akhir)}}</h5>
                        </div>
                    </div>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-paper" role="tabpanel" aria-labelledby="pills-paper-tab">
                        <div class="card mb-2">
                            <div class="card-body row">
                                <div class="col-12 col-sm-3 border-right">
                                    <p class="mb-0"><b><u>FILE ABSTRACT</u></b></p>
                                    <a target="_blank" class="btn btn-info btn-sm text-light btn-block" id="a_file_abstract"><i class="fas fa-file-download"></i> DOWNLOAD ABSTRACT</a>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="no_abstrac" class="form-label"><b>Code Abstract</b></label>
                                    <div class="form-control rounded h-auto" id="no_abstrac"></div>
                                </div>
                                <div class="form-group">
                                    <label for="scope" class="form-label"><b>Scope</b></label>
                                    <div class="form-control rounded h-auto" id="tx_scope"></div>
                                </div>
                                <div class="form-group">
                                    <label for="title" class="form-label"><b>Title</b></label>
                                    <div class="form-control rounded h-auto" id="tx_title"></div>
                                </div>
                                <div class="form-group">
                                    <label for="abstrac" class="form-label"><b>Abstract</b></label>
                                    <div class="form-control rounded h-auto" id="tx_abstrac"></div>
                                </div>
                                <div class="form-group">
                                    <label for="full_paper" class="form-label mb-0"><b>Full Paper</b><small> (DOC/DOCX)</small></label><br/>
                                    <div class="display-none" id="v_full_paper">
                                        <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                            <li>
                                                <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>
                                                <div class="mailbox-attachment-info">
                                                    <a href="javascript:void(0)" class="mailbox-attachment-name text-decoration-none text-black" id="tx_file_nama"></a>
                                                    <a id="a_file_download" class="btn btn-default btn-sm float-right text-light">
                                                        <i class="fas fa-cloud-download-alt"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="form-control rounded h-auto display-none" id="v_full_paper_not">Full Paper Not Yet Available</div>
                                </div>
                                <div class="form-group">
                                    <label for="keyword" class="form-label mb-0"><b>Keywords</b></label><br/>
                                    <div class="form-control rounded h-auto" id="tx_keyword"></div>
                                </div>
                                <div class="form-group">
                                    <label for="keyword" class="form-label mb-0"><b>Corresponding Author</b></label><br/>
                                    <div class="form-control rounded h-auto h-min-textarea" id="tx_corresponding_author"></div>
                                </div>
                                <div class="form-group">
                                    <label for="keyword" class="form-label mb-0"><b>Status</b></label><br/>
                                    <div class="form-control rounded h-auto" id="tx_stt_journal"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                        <div class="card">
                            <div class="card-body">
                                <iframe class="w-100" style="height:50vh;" id="iframe"></iframe>
                                <div class="form-group">
                                    <label for="link_video_youtube" class="form-label mb-0"><b>Link Youtube</b></label><br/>
                                    <div class="form-control rounded h-auto h-min-textarea" id="tx_link_video_youtube"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-suplementari" role="tabpanel" aria-labelledby="pills-suplementari-tab">
                        <div class="card">
                            <div class="card-body">
                                <ul class="mailbox-attachments d-flex align-items-stretch clearfix" id="view_suplementari">
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-revision" role="tabpanel" aria-labelledby="pills-revision-tab">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="form-control rounded h-auto" id="tx_stt_journal2"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Action</label><br/>
                                        <button type="button" id="btn_acc" class="btn btn-success btn-block" onclick="process()"><i class="fas fa-check"></i> REVISED PAPER WILL BE PROCESSED FOR PUBLICATION</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header bg-white">
                                <button type="button" id="btn_revision" class="btn btn-primary btn-sm float-right"><i class="fas fa-pencil-alt"></i> Add Commentary</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table" class="table w-100">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>To</th>
                                        <th>Notes</th>
                                        <th>Review Result</th>
                                        <th>Revision Author</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
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
        var stt_time = "WAIT";
        var stt_paper;
        $(document).ready(function () {
            setAktifItem("my_review");
            getJurnal();
            setConfigTime();
        });
        function getJurnal() {
            loader_show();
            $.ajax({
                type: "GET",
                data:{no_abs:no_abs},
                url: "{{url('api/detailMyJournal')}}",
                dataType: 'json',
                success: function(response)
                {
                    loader_hide();
                    if (response.status==="OK"){
                        var dt_jurnal = response.data_journal;
                        var link_video = dt_jurnal.link_video;
                        stt_paper = dt_jurnal.stt_jurnal;
                        if (link_video!==null){
                            $('#iframe').attr('src',setEmbed(link_video)).show();
                        } else {
                            $('#iframe').hide();
                        }
                        var file_nama = dt_jurnal.file_nama;
                        var file__ = "";
                        if (file_nama !== null){
                            $('#v_full_paper_not').hide();
                            $('#v_full_paper').show();
                            file__ = file_nama.length > 15 ? file_nama.substring(0, 12)+"..." : file_nama;
                            $('#tx_file_nama').html('<i class="fas fa-paperclip"></i> '+file__);
                            $('#a_file_download').attr('href',"{{ url('download?type=jurnal') }}"+'&file='+file_nama+"&abs="+no_abs);
                            if (dt_jurnal.stt_full_paper === "WILL BE PROCESSED"){
                                $('#btn_revision').attr('disabled','disabled');
                            }
                        } else {
                            $('#v_full_paper_not').show();
                            $('#v_full_paper').hide();
                        }
                        if (stt_paper === "WILL BE PROCESSED") {
                            $('#btn_acc').attr('disabled',"disabled");
                        }
                        if (stt_paper === "WILL BE PROCESSED") {
                            $('#tx_stt_journal2').html('<p class="text-success mb-0"><i class="fas fa-check"></i> '+stt_paper+'</p>');
                        } else {
                            $('#tx_stt_journal2').html(stt_paper);
                        }
                        $('#btn_revision').attr('onclick','modal(\'revision-reviewer\',\''+dt_jurnal.no_abstrak+'\')');
                        $('#no_abstrac').html(dt_jurnal.no_abstrak);
                        $('#tx_scope').html(dt_jurnal.scope);
                        $('#tx_title').html(dt_jurnal.judul_jurnal);
                        $('#tx_abstrac').html(dt_jurnal.abstrak_jurnal);
                        $('#tx_keyword').html(dt_jurnal.keyword_jurnal);
                        $('#tx_corresponding_author').html(setName_author(dt_jurnal.nama_depan,dt_jurnal.nama_tengah,dt_jurnal.nama_belakang));
                        $('#tx_stt_journal').html(stt_paper);
                        $('#tx_link_video_youtube').html(dt_jurnal.link_video);
                        $('#a_file_abstract').attr('href',"{{ url('/export/journal_doc?abs=') }}"+no_abs);

                        var view_suplementari = "";
                        $.each(response.data_suplementari, function (index,element) {
                            var html_file = "";
                            var file_icon = "";
                            var htmlView = "";
                            var fileName = element.file_nama;
                            if (fileName !== null){
                                if (fileName.length > 15) {
                                    fileName = fileName.substring(0, 15)+"...";
                                }
                            }
                            if (element.file_tipe==="jpg"||element.file_tipe==="jpeg"||element.file_tipe==="png"){
                                html_file = '<span class="mailbox-attachment-icon has-img"><img src="{{ asset('/upload/jurnal_pendukung') }}/'+element.file_pendukung+'" alt="Attachment"></span><div class="mailbox-attachment-info">';
                                file_icon = "fas fa-camera";
                                htmlView = '<button type="button" onclick="modal(\'viewIMG\',\'jurnal_pendukung/'+element.file_pendukung+'\')" class="btn btn-default btn-sm float-right mr-1" target="_blank"><i class="fas fa-eye"></i></button>';
                            } else if (element.file_tipe==="pdf"){
                                html_file = '<span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span><div class="mailbox-attachment-info">';
                                file_icon = "fas fa-paperclip";
                                htmlView = '<a href="{{ asset('plugins/pdfjs-2.3.200-dist/web/viewerFull.html?file=').asset('upload/jurnal_pendukung').'/'}}'+element.file_pendukung+'" class="btn btn-default btn-sm float-right mr-1" target="_blank"><i class="fas fa-eye"></i></a>';
                            } else if (element.file_tipe==="doc"||element.file_tipe==="docx"){
                                html_file = '<span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span><div class="mailbox-attachment-info">';
                                file_icon = "fas fa-paperclip";
                            }
                            view_suplementari += '<li>'+html_file+'<a href="javascript:void(0)" class="mailbox-attachment-name text-decoration-none text-black"><i class="'+file_icon+'"></i> '+fileName+'</a><span class="mailbox-attachment-size clearfix mt-1"><span>('+element.file_tipe.toUpperCase()+')</span><a href="{{ url('download?type=jurnal_pendukung&file=') }}'+element.file_pendukung+'" class="btn btn-default btn-sm float-right text-light"><i class="fas fa-cloud-download-alt"></i></a>'+htmlView+'</span></div></li>';
                        });
                        $('#view_suplementari').html(view_suplementari);
                        getRevision();
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
        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }
        function getRevision() {
            $('#dt_table').DataTable({
                processing: true,
                responsive:true,
                pagingType: "full_numbers",
                serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableRevisionDetail') }}",
                    data: function (d) {
                        d.no_abs = no_abs;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        return response
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', "className": "dt-center"},
                    {data: 'revisi_ke', name: 'revisi_ke', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            return stripTags(row.revisi);
                        }, "className": "dt-justify"
                    },
                    { "render": function ( data, type, row )
                        {
                            if (row.file_revisi_reviewer === null){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div><a href="{{url('download?type=revision_author_reviewer&file=')}}'+row.file_revisi_reviewer+'&abs='+no_abs+'" class="btn btn-primary btn-sm btn-block text-white">DOWNLOAD</a>';
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            if (row.file_revisi_author === null){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div><a href="{{url('download?type=revision_author_reviewer&file=')}}'+row.file_revisi_author+'&abs='+no_abs+'" class="btn btn-primary btn-sm btn-block">DOWNLOAD</a>';
                            }
                        }, "className": "dt-center"
                    },
                    {data: 'stt_revisi', name: 'stt_revisi', "className": "dt-center"},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            var view = '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" disabled>DELETE</button>';
                            if (row.DT_RowIndex === 1){
                                if (row.stt_revisi !== "WILL BE PROCESSED" && row.file_revisi_author === null){
                                    if (stt_paper === "WILL BE PROCESSED") {
                                        return view;
                                    } else {
                                        return '<button type="button" class="btn btn-sm btn-danger m-1 btn-block review-btn-delete" onclick="ajaxDelete(\'jurnal_revisi\',\''+row.id_jurnal_revisi+'\')">DELETE</button>';
                                    }
                                } else {
                                    return view;
                                }
                            } else {
                                return '';
                            }
                        }
                    },
                ]
            });
        }
        function setConfigTime() {
            var today = new Date();
            var tgl_start = new Date("{{$tgl_mulai}} 00:00:00");
            var tgl_end = new Date("{{$tgl_akhir}} 23:59:59");

            if (today.getTime() < tgl_start.getTime()) {
                stt_time = "WAIT";
            } else if (today.getTime() >= tgl_start.getTime() && today.getTime() <= tgl_end.getTime()) {
                stt_time = "START";
            } else {
                stt_time = "CLOSED";
            }

            $("#btn_revision").attr("disabled", true);
            if (stt_time === "WAIT") {
                $('#p_text').html('<b><u>REVIEW TIME OPEN</u></b>');
                setTimeStartReview('{{$tgl_mulai}} 00:00:00');
            } else if (stt_time === "START") {
                $('#p_text').html('<b><u>REVIEW TIME CLOSED</u></b>');
                $("#btn_revision").attr("disabled", false);
                setTimeStartReview('{{$tgl_akhir}} 23:59:59');
            } else {
                $('#countdown_review').html('<b>REVIEW TIME IS CLOSED</b>');
            }
        }
        function setTimeStartReview(str) {
            const second = 1000, minute = second * 60, hour = minute * 60, day = hour * 24;
            let countDown = new Date(str).getTime(), x_time = setInterval(function() {
                let now = new Date().getTime(), distance = countDown - now;
                document.getElementById("days_review").innerText = Math.floor(distance / (day)),
                    document.getElementById("hours_review").innerText = Math.floor((distance % (day)) / (hour)),
                    document.getElementById("minutes_review").innerText = Math.floor((distance % (hour)) / (minute)),
                    document.getElementById("seconds_review").innerText = Math.floor((distance % (minute)) / second);
                if (distance < 0) {
                    clearInterval(x_time);
                    if (stt_time === "WAIT") {
                        stt_time = "START";
                    } else if (stt_time === "START") {
                        stt_time = "CLOSED";
                    }
                    setConfigTime();
                }
            }, 0);
        }
        function process() {
            swalWithBootstrapButtons.fire({
                text: 'Are you sure want to processed paper?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        loader_show();
                        $.ajax({
                            type: "POST", data:{no_abs:no_abs}, url: "{{url('api/processJournal')}}",
                            dataType: 'json', headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            success: function(response)
                            {
                                loader_hide();
                                if (response.status==="OK"){
                                    swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                        if (result.value) {
                                            getJurnal();
                                        }
                                    });
                                } else {
                                    swall_failed_text(response.message);
                                }
                            },
                            error:function(data){
                                loader_hide();
                                swall_error();
                            }
                        });
                    })
                },
                allowOutsideClick: false,
            });
        }
    </script>
@endsection
