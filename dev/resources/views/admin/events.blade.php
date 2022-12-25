@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Events</li>
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
                                <th>Event</th>
                                <th>Year</th>
                                <th>Pamphlet</th>
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
    <a href="{{url('/admin/event/add')}}" class="btn btn-default btn-lg btn-floating shadow rounded-circle">
        <i class="fa fa-plus floating-icon"></i>
    </a>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            setAktifItem('events');
            $('#dt_table').DataTable({
                processing: true,responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: "{{ url('/api/dtTableEvents') }}",language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                createdRow: function(row, data, dataIndex) {
                    if (data.stt_view === 0) {
                        $(row).addClass("bg-silver");
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/admin/event')}}/'+row.slug_event+'">'+row.event+'</a>';
                        }, "className": "dt-justify"
                    },
                    {data: 'tahun_event', name: 'tahun_event', className : "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            if (row.pamflet===null||row.pamflet==="null"){
                                return '<div class="text-danger">NOT AVAILABLE</div>';
                            } else {
                                return '<div class="text-success">AVAILABLE</div><a href="{{url('download?type=event&file=')}}'+row.pamflet+'&name='+row.event+'" class="btn btn-primary btn-sm btn-block text-white">DOWNLOAD</a>';
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            if (row.stt_aktif === 0){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NOT ACTIVE</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> ACTIVE</div>';
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            var view = "";
                            if (row.stt_aktif === 0){
                                view = '<button type="button" class="btn btn-sm btn-warning m-1 btn-block" onclick="activate(\''+row.id_event+'\')">ACTIVATE</button>';
                            }
                            return view +'<a href="{{url('/admin/event/edit?id=')}}'+row.id_event+'" class="btn btn-sm btn-info m-1 btn-block">EDIT</a>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'events\',\''+row.id_event+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        });

        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }

        function activate(id_event) {
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
                            type: "POST",data:{id_event:id_event}, url: "{{ url('/api/updateEventActivate') }}",
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
