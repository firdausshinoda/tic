@extends('reviewer.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/reviewer')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/reviewer/abstract')}}">Abstract</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card mb-3">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-paper-tab" data-toggle="pill" href="#pills-paper" role="tab" aria-controls="pills-paper" aria-selected="true">JOURNAL</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-metadata-tab" data-toggle="pill" href="#pills-metadata" role="tab" aria-controls="pills-metadata" aria-selected="false">METADATA</a>
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
                                    <label for="abstrac" class="form-label"><b>ABSTRACT</b></label>
                                    <div class="form-control rounded h-auto" id="tx_abstrac"></div>
                                </div>
                                <div class="form-group">
                                    <label for="full_paper" class="form-label mb-0"><b>FULL PAPER</b><small> (DOC/DOCX)</small></label><br/>
                                    <div id="view_file">
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
                                    <div class="form-control rounded h-auto" id="view_upload_paper">Full Paper Not Found</div>
                                </div>
                                <div class="form-group">
                                    <label for="keyword" class="form-label mb-0"><b>KEYWORD</b></label><br/>
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
                    <div class="tab-pane fade" id="pills-metadata" role="tabpanel" aria-labelledby="pills-metadata-tab">
                        <div id="view_metadata"></div>
                    </div>
                    <div class="tab-pane fade" id="pills-video" role="tabpanel" aria-labelledby="pills-video-tab">
                        <div class="card mt-3">
                            <div class="card-body">
                                <iframe class="w-100 display-none" style="height:50vh;" id="iframe"></iframe>
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
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <table id="dt_table" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>To</th>
                                        <th>Notes</th>
                                        <th>Revision Reviewer</th>
                                        <th>Revision Author</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card display-none mt-3" id="view_konfirmasi">
                    <div class="card-header">
                        <h6><b>Confirmation Journal</b></h6>
                    </div>
                    <div class="card-body text-right">
                        <button type="button" class="btn btn-success btn-sm" onclick="alertAcc()"><i class="fas fa-check"></i> ACCEPTED ABSTRACT</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="alertNoAcc()"><i class="fas fa-times"></i> NOT ACCEPTED</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var no_abs = getUrlVars()["abs"];
        $(document).ready(function() {
            setAktifItem('journal');
            getJurnal();
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
                        kd_payment = dt_jurnal.no_abstrak;
                        id_payment = dt_jurnal.id_jenis_pembayaran;
                        stt_payment = dt_jurnal.stt_pembayaran_konfirmasi;
                        type_payment = dt_jurnal.jenis_pembayaran;
                        file_payment = dt_jurnal.file_pembayaran;
                        file_type = dt_jurnal.tipe_pembayaran;
                        $('#tr_kode_abstrak').html(dt_jurnal.no_abstrak);
                        $('#no_abstrac').html(dt_jurnal.no_abstrak);
                        $('#tx_scope').html(dt_jurnal.scope);
                        $('#tx_title').html(dt_jurnal.judul_jurnal);
                        $('#tx_abstrac').html(dt_jurnal.abstrak_jurnal);
                        $('#tx_keyword').html(dt_jurnal.keyword_jurnal);
                        $('#tx_corresponding_author').html(setName_author(dt_jurnal.nama_depan,dt_jurnal.nama_tengah,dt_jurnal.nama_belakang));
                        $('#tx_stt_journal').html(dt_jurnal.stt_jurnal);
                        $('#tx_link_video_youtube').html(dt_jurnal.link_video);
                        $('#a_file_abstract').attr('href',"{{ url('/export/journal_doc?abs=') }}"+no_abs);
                        var link_video = dt_jurnal.link_video;
                        if (link_video!==null){
                            var link_embed = "";
                            if (link_video.includes("https://www.youtube.com/watch?v=")){
                                var substr = "https://www.youtube.com/watch?v=";
                                link_embed = link_video.slice(link_video.indexOf(substr) + substr.length, link_video.length);
                            } else {
                                var substr = "https://youtu.be/";
                                link_embed = link_video.slice(link_video.indexOf(substr) + substr.length, link_video.length);
                            }
                            $('#iframe').attr('src','https://www.youtube.com/embed/'+link_embed).show();
                        } else {
                            $('#iframe').hide();
                        }

                        if (dt_jurnal.stt_jurnal==="COMPLETED FOR A REVIEW"){
                            $('#view_konfirmasi').show();
                        } else {
                            $('#view_konfirmasi').hide();
                        }
                        var file_nama = dt_jurnal.file_nama;
                        if (file_nama === null){
                            $('#view_file').hide();
                            $('#view_upload_paper').show();
                        } else {
                            $('#view_file').show();
                            $('#view_upload_paper').hide();
                            var file__ = file_nama.length > 15 ? file_nama.substring(0, 12)+"..." : file_nama;
                            $('#tx_file_nama').html('<i class="fas fa-paperclip"></i> '+file__);
                            $('#a_file_download').attr('href',"{{ url('download?type=jurnal') }}"+'&file='+file_nama+"&abs="+no_abs);
                        }

                        var view_metadata = "";
                        $.each(response.data_metadata, function (index,element) {
                            view_metadata += '<div class="card mb-1">' +
                                '                                <div class="card-body">' +
                                '                                    <div class="row">' +
                                '                                        <div class="col-12 col-sm-4 form-group">' +
                                '                                            <label for="first_name" class="form-label"><b>FIRST NAME</b></label>' +
                                '                                            <div class="form-control rounded h-auto" id="tx_first_name">'+element.nama_depan+'</div>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 col-sm-4 form-group">' +
                                '                                            <label for="midle_name" class="form-label"><b>MIDLE NAME</b></label>' +
                                '                                            <div class="form-control rounded h-auto" id="tx_midle_name">'+checkNull(element.nama_tengah)+'</div>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 col-sm-4 form-group">' +
                                '                                            <label for="last_name" class="form-label"><b>LAST NAME</b></label>' +
                                '                                            <div class="form-control rounded h-auto" id="tx_last_name">'+element.nama_belakang+'</div>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 col-sm-5 form-group">' +
                                '                                            <label for="email" class="form-label"><b>E-MAIL</b></label>' +
                                '                                            <div class="form-control rounded h-auto" id="tx_email">'+element.email+'</div>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 col-sm-3 form-group">' +
                                '                                            <label for="orcid_id" class="form-label"><b>ORCID ID</b></label>' +
                                '                                            <div class="form-control rounded h-auto" id="tx_orcid_id">'+checkNull(element.orcid_id)+'</div>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 col-sm-4 form-group">' +
                                '                                            <label for="country" class="form-label"><b>COUNTRY</b></label>' +
                                '                                            <div class="form-control rounded h-auto" id="tx_country">'+element.negara+'</div>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 form-group">' +
                                '                                            <label for="institution" class="form-label"><b>INSTITUTION</b></label>' +
                                '                                            <div class="form-control rounded h-auto" id="tx_institution">'+element.institusi+'</div>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 form-group">' +
                                '                                            <label for="bio" class="form-label mb-0"><b>BIO STATEMENT</b></label><br/>' +
                                '                                            <div class="form-control rounded h-auto" id="tx_bio">'+element.biodata+'</div>' +
                                '                                        </div>' +
                                '                                    </div>' +
                                '                                </div>' +
                                '                            </div>';
                        });
                        $('#view_metadata').html(view_metadata);

                        var view_suplementari = "";
                        $.each(response.data_suplementari, function (index,element) {
                            var html_file = "";
                            var file_icon = "";
                            var htmlView = "";
                            var fileName = element.file_nama;
                            if (fileName.length > 15) {
                                fileName = fileName.substring(0, 15)+"...";
                            }
                            if (element.file_tipe==="jpg"||element.file_tipe==="jpeg"||element.file_tipe==="png"){
                                html_file = '<span class="mailbox-attachment-icon has-img"><img src="{{ asset('/upload/jurnal_pendukung') }}/'+element.file_pendukung+'" alt="Attachment"></span><div class="mailbox-attachment-info">';
                                file_icon = "fas fa-camera";
                                htmlView = '<button type="button" onclick="modal(\'viewIMG\',\'jurnal_pendukung/'+element.file_pendukung+'\')" class="btn btn-default btn-sm float-right mr-1" target="_blank"><i class="fas fa-eye"></i></button>';
                            } else if (element.file_tipe==="pdf"){
                                html_file = '<span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span><div class="mailbox-attachment-info">';
                                file_icon = "fas fa-paperclip";
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
        function getRevision() {
            $('#dt_table').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableJournalRevision') }}",
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
                            stt_paper = row.stt_revisi;
                            if (row.file_revisi_author === null){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div><a href="{{url('download?type=revision_author_reviewer&file=')}}'+row.file_revisi_author+'&abs='+no_abs+'" class="btn btn-primary btn-sm btn-block">DOWNLOAD</a>';
                            }
                        }, "className": "dt-center"
                    },
                    {data: 'stt_revisi', name: 'stt_revisi', "className": "dt-center"},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                ]
            });
        }
        function alertAcc() {
            swalWithBootstrapButtons.fire({
                text: 'Are you sure you want to confirm accepted abstract and send email the LOA attachment?',
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
                        sendKonfirmasi("TERIMA")
                    })
                },
                allowOutsideClick: false,
            });
        }
        function alertNoAcc() {
            swalWithBootstrapButtons.fire({
                text: 'Are you sure you want to confirm rejected?',
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
                        sendKonfirmasi("TOLAK")
                    })
                },
                allowOutsideClick: false,
            });
        }
        function sendKonfirmasi(type) {
            loader_show();
            var values = new FormData();
            values.append("no_abs",no_abs);
            values.append("type",type);
            $.ajax({
                type: "POST",data:values, url: "{{ url('/api/updateJournalConfirmation') }}",
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'json', processData: false, contentType: false,
                success: function(response) {
                    loader_hide();
                    if (response.status === "OK"){
                        swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                            if (result.value) {
                                getJurnal();
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
        }
    </script>
@endsection
