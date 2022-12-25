@extends('reviewer.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/reviewer')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Review</li>
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
                            <p class="mb-0"><b><u>REVIEW DATE</u></b></p>
                            <h5>{{Helpers::setTglSurat($tgl_mulai)." - ".Helpers::setTglSurat($tgl_akhir)}}</h5>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table id="dt_table" class="table" width="100%">
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Code Abstract</th>
                                <th>Title</th>
                                <th>Full Paper</th>
                                <th>Status Paper</th>
                                <th>Revised Paper</th>
                                <th>Prosgress</th>
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
        var stt_time = "WAIT";
        $(document).ready(function () {
            setAktifItem("my_review");
            getData();
            setConfigTime();
        });
        function getData() {
            $('#dt_table').DataTable({
                processing: true, 
                paging : false,
                ordering : false,
                info : false,
                responsive:true, 
                serverSide: true,
                destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableMyReviewReviewer') }}",
                    data: function (d) {
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        return response
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('reviewer/my_review/detail?abs=')}}'+row.no_abstrak+'">'+row.no_abstrak+'</a>';
                        }, "className": "dt-justify"
                    },
                    {data: 'judul_jurnal', name: 'judul_jurnal'},
                    { "render": function ( data, type, row )
                        {
                            if (row.file_nama === null){
                                return '<div class="text-danger"><i class="fas fa-times"></i></div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i></div>';
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            if (row.stt_full_paper === "EMPTY"){
                                return '-';
                            } else {
                                return row.stt_full_paper;
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            if (row.stt_revisi_paper  === "EMPTY"){
                                return '-';
                            } else {
                                return row.stt_revisi_paper ;
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            if (row.stt_progres_paper   === "EMPTY"){
                                return '-';
                            } else {
                                return row.stt_progres_paper  ;
                            }
                        }, "className": "dt-center"
                    },
                ]
            });
        }
        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }
        function setConfigTime() {
            var today = new Date();
            var tgl_start = new Date("{{$tgl_mulai}}");
            var tgl_end = new Date("{{$tgl_akhir}}");
            if (today < tgl_start) {
                stt_time = "WAIT";
            } else if (today >= tgl_start && today <= tgl_end) {
                stt_time = "START";
            } else {
                stt_time = "CLOSED";
            }

            if (stt_time === "WAIT") {
                $('#p_text').html('<b><u>REVIEW TIME OPEN</u></b>');
                setTimeStartReview('{{$tgl_mulai}} 00:00:00');
            } else if (stt_time === "START") {
                $('#p_text').html('<b><u>REVIEW TIME CLOSED</u></b>');
                setTimeStartReview('{{$tgl_akhir}} 23:59:59');
            } else {
                $('#countdown_review').html('<b>REVIEW TIME IS CLOSED</b>');
            }
        }
        function setTimeStartReview(str) {
            console.log(str);
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
    </script>
@endsection
