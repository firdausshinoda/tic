@extends('reviewer.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/reviewer')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Abstract</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table id="dt_table" class="table table-striped" width="100%">
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>No Abstract</th>
                                <th>Title</th>
                                <th>Scope</th>
                                <th>Sub</th>
                                <th>Full Paper</th>
                                <th>Status</th>
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
        $(document).ready(function() {
            setAktifItem("abstract");
            getData();
        });
        function getData() {
            $('#dt_table').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableAbstract') }}",
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
                            return '<a href="{{url('/reviewer/journal/detail?abs=')}}'+row.no_abstrak+'">'+row.judul_jurnal+'</a>';
                        }, "className": "dt-justify"
                    },
                    { data: 'scope', name: 'scope', "className": "dt-center"},
                    { data: 'sub', name: 'sub', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            if (row.file_nama === null){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div>';
                            }
                        }, "className": "dt-center"
                    },
                    { data: 'stt_jurnal', name: 'stt_jurnal', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-success m-1 btn-block" onclick="alertAcc(\''+row.no_abstrak+'\')"><i class="fas fa-check"></i></button>'+
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="alertNoAcc(\''+row.no_abstrak+'\')"><i class="fas fa-times"></i></button>'+
                                '<a href="{{url('/export/journal_doc?abs=')}}'+row.no_abstrak+'" class="btn btn-sm btn-primary m-1 btn-block" target="_blank"><i class="fas fa-file-word"></i></a>'
                        }
                    },
                ]
            });
        }
        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }
        function alertAcc(no_abs) {
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
                        sendKonfirmasi(no_abs,"TERIMA")
                    })
                },
                allowOutsideClick: false,
            });
        }
        function alertNoAcc(no_abs) {
            swalWithBootstrapButtons.fire({
                text: 'Are you sure you want to confirm rejected abstract?',
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
                        sendKonfirmasi(no_abs,"TOLAK")
                    })
                },
                allowOutsideClick: false,
            });
        }
        function sendKonfirmasi(no_abs,type) {
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
                                reloadTable();
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
