@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Journal</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm mt-2">
                    <div class="card-body">
                        <table id="dt_table" class="table table-striped" width="100%">
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
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            setAktifItem("journal");
            getData();
        });
        function getData() {
            $('#dt_table').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excel', messageTop: 'Data Journal Final',
                        exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10 ]},
                        title: 'Data Journal Process',
                    },
                    {
                        extend: 'pdf', messageTop: 'Data Journal Final', messageBottom: null,
                        exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8, 9, 10 ] },
                        title: 'Data Journal Process',
                    }
                ],
                ajax: {
                    url: "{{ url('/api/dtTableJournalFinal') }}",
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
                            } else {
                                view += '<span class="badge badge-success">PAID</span>';
                                view += '<button type="button" class="btn btn-block btn-sm btn-info m-1" onclick="modal(\'payment-view\',\''+row.no_abstrak+'\')">VIEW</button>';
                                view += '<a href="{{url('/download_payment_receipt?abs=')}}'+row.no_abstrak+'" class="btn btn-sm btn-primary btn-block m-1" target="_blank">DOWNLOAD</a>';
                            }
                            return view;
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row ) {
                            if (row.nama_depan!==null) {
                                return setName_author(row.nama_depan,row.nama_tengah,row.nama_belakang)
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
        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }
    </script>
@endsection
