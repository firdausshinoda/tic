@extends('reviewer.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/reviewer')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Revision</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <table id="dt_table" class="table" width="100%">
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Code Abstract</th>
                                <th>Title</th>
                                <th>Status Paper</th>
                                <th>Revised Paper</th>
                                <th>Prosgress</th>
                                <th>Reviewer</th>
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
        $(document).ready(function () {
            setAktifItem("revision");
            getData();
        });
        function getData() {
            $('#dt_table').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableRevision') }}",
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
                            return '<a href="{{url('reviewer/revision/detail?abs=')}}'+row.no_abstrak+'">'+row.no_abstrak+'</a>';
                        }, "className": "dt-justify"
                    },
                    {data: 'judul_jurnal', name: 'judul_jurnal'},
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
                    { "render": function ( data, type, row )
                        {
                            if (row.nama_depan !== null){
                                return setName_author(row.nama_depan,row.nama_tengah,row.nama_belakang);
                            } else {
                                return "-";
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            var view = '';
                            if (row.id_reviewer===null){
                                view += '<button type="button" class="btn btn-sm btn-success m-1 btn-block" onclick="add_my_revision(\''+row.id_jurnal+'\')">ADD TO MY REVISION</button>';
                            }
                            return view;
                        }
                    },
                ]
            });
        }
        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }
        function add_my_revision(id) {
            swalWithBootstrapButtons.fire({
                text: 'Are you sure?',
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
                            type: "POST",data:{id:id}, url: "{{ url('/api/updateRevisionAdd') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            dataType: 'json',
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
                    })
                },
                allowOutsideClick: false,
            });
        }
    </script>
@endsection
