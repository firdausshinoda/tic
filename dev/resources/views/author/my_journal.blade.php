@extends('author.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/author')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Journal</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm mb-2">
                    <div class="card-body">
                        <p class="mb-0"><b><u>ABSTRACK SUBMISSION DEADLINE</u></b></p>
                        <div class="countdown" id="countdown_abstract">
                            <ul>
                                <li class="text-center"><span class="tx_countdown" id="days_abstract">:</span>DAYS</li>
                                <li>:</li>
                                <li class="text-center"><span class="tx_countdown" id="hours_abstract"></span>HOURS</li>
                                <li>:</li>
                                <li class="text-center"><span class="tx_countdown" id="minutes_abstract"></span>MINUTES</li>
                                <li>:</li>
                                <li class="text-center"><span class="tx_countdown" id="seconds_abstract"></span>SECONDS</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table id="dt_table" class="table" width="100%">
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>No Abstract</th>
                                <th>Title</th>
                                <th>Scope</th>
                                <th>Full Paper</th>
                                <th>Payment</th>
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
    @if($abstract_button)
        <a href="{{url('/author/my_journal/add')}}" class="btn btn-default btn-lg btn-floating shadow rounded-circle">
            <i class="fa fa-plus floating-icon"></i>
        </a>
    @endif
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            setAktifItem("my_journal");
            getData();
            setTimeAbstract('{{$abstract_tgl}}');
        });
        function setTimeAbstract(str) {
            const second = 1000, minute = second * 60, hour = minute * 60, day = hour * 24;
            let countDown = new Date(str+" 23:59:59").getTime(), x_time = setInterval(function() {
                let now = new Date().getTime(), distance = countDown - now;
                document.getElementById("days_abstract").innerText = Math.floor(distance / (day)),
                    document.getElementById("hours_abstract").innerText = Math.floor((distance % (day)) / (hour)),
                    document.getElementById("minutes_abstract").innerText = Math.floor((distance % (hour)) / (minute)),
                    document.getElementById("seconds_abstract").innerText = Math.floor((distance % (minute)) / second);
                if (distance < 0) {
                    clearInterval(x_time);
                    $('#countdown_abstract').html('<b>ABSTRACT SUBMISSION HAS BEEN CLOSED</b>');
                }
            }, 0);
        }
        function getData() {
            $('#dt_table').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableMyJournal') }}",
                    data: function (d) {
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        return response
                    },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', "className": "dt-center"},
                    { data: 'no_abstrak', name: 'no_abstrak', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/author/my_journal/detail?abs=')}}'+row.no_abstrak+'">'+row.judul_jurnal+'</a>';
                        }, "className": "dt-justify"
                    },
                    { data: 'scope', name: 'scope', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            if (row.file_nama === null){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div>';
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            if (row.stt_pembayaran === "NOT PAID YET"){
                                return '<span class="badge badge-danger">NOT PAID YET</span>';
                            } else {
                                return '<span class="badge badge-success">PAID</span>';
                            }
                        }, "className": "dt-center"
                    },
                    { data: 'stt_jurnal', name: 'stt_jurnal', "className": "dt-center"},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}, "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            if (row.stt_jurnal === "DRAFT"){
                                return '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'my_journal\','+row.id_jurnal+')"><i class="far fa-trash-alt"></i></button>';
                            } else {
                                return '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" disabled><i class="far fa-trash-alt"></i></button>';
                            }
                        }
                    },
                ]
            });
        }
        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }
    </script>
@endsection
