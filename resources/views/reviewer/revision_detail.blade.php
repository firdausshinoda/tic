@extends('reviewer.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/reviewer')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/reviewer/revision')}}">Revision</a></li>
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
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="no_abstrac" class="form-label"><b>Code Abstrac</b></label>
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
                                    <label for="abstrac" class="form-label"><b>ABSTRAC</b></label>
                                    <div class="form-control rounded h-auto" id="tx_abstrac"></div>
                                </div>
                                <div class="form-group">
                                    <label for="full_paper" class="form-label mb-0"><b>FULL PAPER</b><small> (DOC/DOCX)</small></label><br/>
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
                        <div class="card">
                            <div class="card-body">
                                <table id="dt_table" class="table w-100">
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
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var no_abs = getUrlVars()["abs"];
        var stt_paper;
        $(document).ready(function () {
            setAktifItem("revision");
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
                        var link_video = dt_jurnal.link_video;
                        if (link_video!==null){
                            $('#iframe').attr('src',setEmbed(link_video)).show();
                        } else {
                            $('#iframe').hide();
                        }
                        var file_nama = dt_jurnal.file_nama;
                        var file__ = file_nama.length > 15 ? file_nama.substring(0, 12)+"..." : file_nama;
                        $('#tx_file_nama').html('<i class="fas fa-paperclip"></i> '+file__);
                        $('#a_file_download').attr('href',"{{ url('download?type=jurnal') }}"+'&file='+file_nama+"&abs="+no_abs);
                        $('#no_abstrac').html(dt_jurnal.no_abstrak);
                        $('#tx_scope').html(dt_jurnal.scope);
                        $('#tx_title').html(dt_jurnal.judul_jurnal);
                        $('#tx_abstrac').html(dt_jurnal.abstrak_jurnal);
                        $('#tx_keyword').html(dt_jurnal.keyword_jurnal);
                        $('#tx_corresponding_author').html(setName_author(dt_jurnal.nama_depan,dt_jurnal.nama_tengah,dt_jurnal.nama_belakang));
                        $('#tx_stt_journal').html(dt_jurnal.stt_jurnal);
                        $('#tx_link_video_youtube').html(dt_jurnal.link_video);

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
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div><a href="{{url('download?type=revision_author_reviewer&file=')}}'+row.file_revisi_reviewer+'&abs='+no_abs+'" class="btn btn-primary btn-sm btn-block text-white"><i class="fas fa-cloud-download-alt"></i> DOWNLOAD</a>';
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            stt_paper = row.stt_revisi;
                            if (row.file_revisi_author === null){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div><a href="{{url('download?type=revision_author_reviewer&file=')}}'+row.file_revisi_author+'&abs='+no_abs+'" class="btn btn-primary btn-sm btn-block"><i class="fas fa-cloud-download-alt"></i> DOWNLOAD</a>';
                            }
                        }, "className": "dt-center"
                    },
                    {data: 'stt_revisi', name: 'stt_revisi', "className": "dt-center"},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                ]
            });
        }
        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }
    </script>
@endsection
