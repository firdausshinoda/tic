@extends('author.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/author')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/author/revision')}}">Revision</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
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
                            <p class="mb-0"><b><u>REVISION DATE</u></b></p>
                            <h5>{{Helpers::setTglSurat($tgl_mulai)." - ".Helpers::setTglSurat($tgl_akhir)}}</h5>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm mb-2">
                    <div class="card-body text-danger">
                        *) If your paper or abstract has more than one comment from the reviewer, please upload it on the upload button in the top comments with a full paper that has been revised according to all comments.
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table id="dt_table" class="table w-100">
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Revision To</th>
                                <th>Notes</th>
                                <th>Review Result</th>
                                <th>Revision Author</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                        </table>
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
        var stt_time = "WAIT";
        $(document).ready(function () {
            setAktifItem("revision");
            getRevision();
            setConfigTime();
        });
        function getRevision() {
            $('#dt_table').DataTable({
                processing: true,
                responsive:true,
                pagingType: "full_numbers",
                serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableRevisionAuthorDetail') }}",
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
                    { "render": function ( data, type, row )
                        {
                            stt_paper = row.stt_revisi;
                            if (row.stt_revisi === "WILL BE PROCESSED"){
                                return '<div class="text-success"><i class="fas fa-check"></i> '+row.stt_revisi+'</div>';
                            } else {
                                return row.stt_revisi;
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            if (row.DT_RowIndex===1){
                                if (stt_paper !== "WILL BE PROCESSED"){
                                    return '<button type="button" class="btn btn-sm btn-info m-1 btn-block d-none btn_upload" onclick="modal(\'revision-author\',\''+no_abs+'\',\''+row.id_jurnal_revisi+'\')"><i class="fas fa-cloud-upload-alt"></i>UPLOAD</button>'
                                } else {
                                    return '<button type="button" class="btn btn-sm btn-info m-1 btn-block d-none btn_upload" disabled><i class="fas fa-cloud-upload-alt"></i>UPLOAD</button>'
                                }
                            } else {
                                return '';
                            }
                        }
                    },
                ]
            });
        }
        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
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
                check_upload();
            }

            $("#btn_revision").attr("disabled", true);
            if (stt_time === "WAIT") {
                $('#p_text').html('<b><u>REVISION TIME OPEN</u></b>');
                setTimeStartReview('{{$tgl_mulai}} 00:00:00');
            } else if (stt_time === "START") {
                $('#p_text').html('<b><u>REVISION TIME CLOSED</u></b>');
                $(".btn_revision").attr("disabled", false);
                setTimeStartReview('{{$tgl_akhir}} 23:59:59');
            } else {
                $('#countdown_review').html('<b>REVISION TIME IS CLOSED</b>');
                check_upload();
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
                check_upload();
            }, 0);
        }
        function check_upload() {
            if (stt_time==="START") {
                $(".btn_upload").removeClass("d-none");
            } else {
                $(".btn_upload").addClass("d-none");
            }
        }
    </script>
@endsection
