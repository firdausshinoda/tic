@extends('admin.template')

@section('konten')
    <style type="text/css">
        /*.dt-buttons{*/
        /*    display: none;*/
        /*}*/
    </style>
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/journal')}}">Journal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Process</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card mb-3">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="pills-proses-tab" data-toggle="pill" href="#pills-proses" role="tab" aria-controls="pills-proses" aria-selected="true">PROCESS</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-progres-tab" data-toggle="pill" href="#pills-progres" role="tab" aria-controls="pills-progres" aria-selected="false">PROGRESS</a></li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-proses" role="tabpanel" aria-labelledby="pills-proses-tab">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Filter</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label>Sub</label>
                                            <select class="form-control" id="s-sub">
                                                <option value="ALL">All</option>
                                                @foreach($sub as $item)
                                                    <option value="{{$item->id_sub}}">{{$item->sub}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label>Payment</label>
                                            <select class="form-control" id="s-payment">
                                                <option value="ALL">All</option>
                                                <option value="NOT PAID YET">Not Paid Yet</option>
                                                <option value="PAID">Paid</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label>Full Paper</label>
                                            <select class="form-control" id="s-paper">
                                                <option value="ALL">All</option>
                                                <option value="0">No</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label>Reviewer</label>
                                            <select class="form-control" id="s-reviewer">
                                                <option value="ALL">All</option>
                                                @foreach($reviewer as $item)
                                                    <option value="{{$item->id_reviewer}}">{{$item->nama_depan." ".$item->nama_tengah." ".$item->nama_belakang}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label>Action</label>
                                            <button type="button" class="btn btn-primary btn-block" onclick="reloadTableProcess()">Search</button>
                                        </div>
                                    </div>
                                    <div class="col-12 d-none">
                                        <hr/>
                                    </div>
                                    <div class="col-12 col-sm-6 d-none">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-outline-primary btn-block" onclick="return $('.buttons-excel').click()">Download Excel</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 d-none">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-outline-primary btn-block" onclick="return $('.buttons-pdf').click()">Download PDF</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-sm mt-2">
                            <div class="card-body">
                                <table id="dt_tableProcess" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>No Abstract</th>
                                        <th>Title</th>
                                        <th>Name</th>
                                        <th>Institution</th>
                                        <th>Sub</th>
                                        <th>Scope</th>
                                        <th>Full Paper</th>
                                        <th>Payment</th>
                                        <th>Reviewer</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-progres" role="tabpanel" aria-labelledby="pills-progres-tab">
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Filter</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label>FULL PAPER</label>
                                            <select class="form-control" id="ps-paper">
                                                <option value="ALL">All</option>
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label>FULL PAPER STATUS</label>
                                            <select class="form-control" id="ps-paperstt">
                                                <option value="ALL">All</option>
                                                <option value="EMPTY">EMPTY</option>
                                                <option value="REVISION REQUIRED">REVISION REQUIRED</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label>REVISED PAPER</label>
                                            <select class="form-control" id="ps-paperrevised">
                                                <option value="ALL">All</option>
                                                <option value="YES">YES</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3">
                                        <div class="form-group">
                                            <label>PROGRESS</label>
                                            <select class="form-control" id="ps-progress">
                                                <option value="ALL">All</option>
                                                <option value="EMPTY">EMPTY</option>
                                                <option value="WAITING REVISED PAPER ">WAITING REVISED PAPER</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group">
                                            <label>Action</label>
                                            <button type="button" class="btn btn-primary btn-block" onclick="reloadTableProgress()">Search</button>
                                        </div>
                                    </div>
                                    <div class="col-12 d-none">
                                        <hr/>
                                    </div>
                                    <div class="col-12 col-sm-6 d-none">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-outline-primary btn-block" onclick="return $('.buttons-excel').click()">Download Excel</button>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 d-none">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-outline-primary btn-block" onclick="return $('.buttons-pdf').click()">Download PDF</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-sm mt-2">
                            <div class="card-body">
                                <table id="dt_tableProgress" class="table table-hover w-100">
                                    <thead class="text-center">
                                    <tr>
                                        <th>No.</th>
                                        <th>User</th>
                                        <th>Abstract</th>
                                        <th>Presenter</th>
                                        <th>Full Paper</th>
                                        <th>Full Paper Status</th>
                                        <th>Revised Paper</th>
                                        <th>Reviewer</th>
                                        <th>Progress</th>
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
        var stt_progres = true;
        $(document).ready(function() {
            setAktifItem("journal_process");
            getDataProcess();
        });
        function getDataProcess() {
            $('#dt_tableProcess').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excel', messageTop: 'Data Journal Process',
                        exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10 ]},
                        title: 'Data Journal Process',
                    },
                    {
                        extend: 'pdf', messageTop: 'Data Journal Process', messageBottom: null,
                        exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10 ] },
                        title: 'Data Journal Process',
                    }
                ],
                ajax: {
                    url: "{{ url('/api/dtTableJournalProcess') }}",
                    data: function (d) {
                        d.sub = $('#s-sub').val();
                        d.payment = $('#s-payment').val();
                        d.paper = $('#s-paper').val();
                        d.reviewer = $('#s-reviewer').val();
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        if (stt_progres) {
                            stt_progres = false;
                            getDataProgress();
                        }
                        return response
                    },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', "className": "dt-center"},
                    { data: 'no_abstrak', name: 'no_abstrak', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/admin/journal/detail?abs=')}}'+row.no_abstrak+'">'+row.judul_jurnal+'</a>';
                        }, "className": "dt-justify"
                    },
                    { "render": function ( data, type, row )
                        {
                            return setName_author(row.nama_depan_a,row.nama_tengah_a,row.nama_belakang_a);
                        }, "className": "dt-center"
                    },
                    { data: 'institusi', name: 'institusi', "className": "dt-center"},
                    { data: 'sub', name: 'sub', "className": "dt-center"},
                    { data: 'scope', name: 'scope', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            var view = "";
                            if (row.file_nama === null){
                                view += '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                view += '<div class="text-success"><i class="fas fa-check"></i> YA</div>';
                            }
                            return view;
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            var view = '';
                            if (row.stt_pembayaran === "NOT PAID YET"){
                                view += '<span class="badge badge-danger">NOT PAID YET</span>';
                                view += '<button type="button" class="btn btn-block btn-sm btn-primary" onclick="modal(\'payment-journal\',\''+row.no_abstrak+'\')">UPLOAD</button>';
                            } else {
                                view += '<span class="badge badge-success">PAID</span>';
                                view += '<button type="button" class="btn btn-block btn-sm btn-primary m-1" onclick="modal(\'payment-journal\',\''+row.no_abstrak+'\')">UPLOAD</button>';
                                view += '<button type="button" class="btn btn-block btn-sm btn-info m-1" onclick="modal(\'payment-view\',\''+row.no_abstrak+'\')">VIEW</button>';
                                view += '<a href="{{url('/download_payment_receipt?abs=')}}'+row.no_abstrak+'" class="btn btn-sm btn-primary btn-block m-1" target="_blank">DOWNLOAD</a>';
                            }
                            return view;
                        }, "className": "dt-center"
                    },
                       { "render": function ( data, type, row ) {
                            if (row.nama_depan!==null) {
                                return setName_author(row.nama_depan,row.nama_tengah,row.nama_belakang)+
                                    '<br/><button type="button" class="btn btn-primary btn-sm btn-block" onclick="modal(\'journal-add-reviewer\',\''+row.no_abstrak+'\',\''+row.id_reviewer+'\')"><i class="fa fa-pencil-alt"></i> Change</button>';
                            }
                        }, "className": "dt-center"
                    },
                    { data: 'stt_jurnal', name: 'stt_jurnal', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/download_loa?abs=')}}'+row.no_abstrak+'" class="btn btn-sm btn-primary m-1 btn-block" target="_blank"><i class="far fa-file-pdf"></i> LOA</a>'+
                                '<a href="{{url('/export/journal_doc?abs=')}}'+row.no_abstrak+'" class="btn btn-sm btn-primary m-1 btn-block" target="_blank"><i class="fas fa-file-word"></i> Abstract</a>'
                        }
                    },
                ]
            });
        }

        function getDataProgress() {
            $('#dt_tableProgress').DataTable({
                dom: 'Blfrtip',
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                buttons: [
                    {
                        extend: 'excel', messageTop: 'Data Progres Report',
                        exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ]},
                        title: 'Data Progres Report',
                    },
                    {
                        extend: 'pdf', messageTop: 'Data Progres Report', messageBottom: null,
                        exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ] },
                        title: 'Data Progres Report',
                    }
                ],
                ajax: {
                    url: "{{ url('/api/dtTableProgressReport') }}",
                    data: function (d) {
                        d.paper = $('#ps-paper').val();
                        d.paperstt = $('#ps-paperstt').val();
                        d.paperrevised = $('#ps-paperrevised').val();
                        d.progress = $('#ps-progress').val();
                        d.page = "JOURNAL-PROCESS";
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        if (stt_progres) {
                            stt_progres = false;
                            getDataProgress();
                        }
                        return response
                    },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', "className": "dt-center"},
                    { data: 'no_author', name: 'scope', "className": "dt-center"},
                    { data: 'no_abstrak', name: 'no_abstrak', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            var coressponden_author = "";
                            if (row.nama_depan !== null){coressponden_author += row.nama_depan;}
                            if (row.nama_tengah !== null){coressponden_author += ' '+row.nama_tengah;}
                            if (row.nama_belakang !== null){coressponden_author += ' '+row.nama_belakang;}
                            return coressponden_author;
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            if (row.file_nama === null){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div>';
                            }
                        }, "className": "dt-center"
                    },
                    { data: 'stt_full_paper', name: 'stt_full_paper', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            if (row.stt_revisi_paper === "EMPTY"){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div>';
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            var coressponden_author = "";
                            if (row.nama_depan_reviewer !== null){coressponden_author += row.nama_depan_reviewer;}
                            if (row.nama_tengah_reviewer !== null){coressponden_author += ' '+row.nama_tengah_reviewer;}
                            if (row.nama_belakang_reviewer !== null){coressponden_author += ' '+row.nama_belakang_reviewer;}
                            return coressponden_author;
                        }, "className": "dt-center"
                    },
                    { data: 'stt_progres_paper', name: 'stt_progres_paper', "className": "dt-center"},
                ]
            });
        }
        function reloadTableProcess() {
            $('#dt_tableProcess').DataTable().ajax.reload();
        }
        function reloadTableProgress() {
            $('#dt_tableProgress').DataTable().ajax.reload();
        }
    </script>
@endsection
