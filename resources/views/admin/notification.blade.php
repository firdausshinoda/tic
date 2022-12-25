@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Notification</li>
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
                                <th>Judul</th>
                                <th>Pesan</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
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
            setAktifItem('notification');
            var table = $('#dt_table').DataTable({
                processing: true,responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: "{{ url('/api/dtTableNotifAdmin') }}",language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                createdRow: function(row, data, dataIndex) {
                    if (data.stt_view === "0") {
                        $(row).addClass("bg-silver");
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            if (row.stt_notif === "JURNAL"){
                                return '<a href="{{url('/admin/journal/detail?abs=')}}'+row.no_abstrak+'">'+row.judul+'</a>';
                            } else if (row.stt_notif === "REVISION"){
                                return '<a href="{{url('/admin/revision/detail?abs=')}}'+row.no_abstrak+'">'+row.judul+'</a>';
                            } else if (row.stt_notif === "PAYMENT"){
                                return '<a href="{{url('/admin/payment_journal')}}">'+row.judul+'</a>';
                            } else if (row.stt_notif === "PAYMENT-PARTICIPAN"){
                                return '<a href="{{url('/admin/payment_participan')}}">'+row.judul+'</a>';
                            } else {
                                return row.judul;
                            }
                        }, "className": "dt-justify"
                    },
                    { "render": function ( data, type, row )
                        {
                            return stripTags(row.pesan);
                        }, "className": "dt-justify"
                    },
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            var view = '';
                            if (row.stt_view==="0"){
                                view += '<button type="button" class="btn btn-sm btn-success m-1 btn-block" onclick="confirm_notif(\''+row.id_notif_admin+'\')"><i class="fas fa-check"></i></button>';
                            }
                            return view + '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'notification_admin\',\''+row.id_notif_admin+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        });

        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }

        function confirm_notif(id) {
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
                            type: "POST",data:{id:id}, url: "{{ url('/api/updateNotifAdmin') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            dataType: 'json',
                            success: function(response) {
                                loader_hide();
                                if (response.status === "OK"){
                                    swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                        if (result.value) {
                                            reloadTable();
                                            getNotif();
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
