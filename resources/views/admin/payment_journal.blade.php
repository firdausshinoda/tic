@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment Journal</li>
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
                                <th>Author</th>
                                <th>Journal</th>
                                <th>Status Payment</th>
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
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            setAktifItem('payment_journal');
            $('#dt_table').DataTable({
                processing: true,responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: "{{ url('/api/dtTablePaymentJournal') }}",language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                createdRow: function(row, data, dataIndex) {
                    if (data.stt_pembayaran_konfirmasi === "WAITING FOR CONFIRMATION") {
                        $(row).addClass("bg-silver");
                    }
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            return row.nama_depan+" "+row.nama_belakang;
                        }, "className": "dt-justify"
                    },
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/admin/journal/detail?abs=')}}'+row.no_abstrak+'">'+row.judul_jurnal+'</a>';
                        }, "className": "dt-justify"
                    },
                    {data: 'stt_pembayaran_konfirmasi', name: 'stt_pembayaran_konfirmasi', "className": "dt-center"},
                    { "render": function ( data, type, row ) {return moment(row.stt_pembayaran_date_upload).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            var view = "";
                            if (row.tipe_pembayaran==="pdf"){
                                view += '<a class="btn btn-sm btn-info m-1 btn-block" href="{{ url('download?type=payment&file=') }}'+row.file_pembayaran+'&abs='+row.no_abstrak+'"><i class="fas fa-cloud-download-alt"></i></a>';
                            } else {
                                view += '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'payment-journal-view\',\''+row.no_abstrak+'\')"><i class="fas fa-eye"></i></button>';
                            }
                            if (row.stt_pembayaran_konfirmasi  === "WAITING FOR CONFIRMATION"){
                                view += '<button type="button" class="btn btn-sm btn-success m-1 btn-block" onclick="sendKonfirmasi(\''+row.no_abstrak+'\')"><i class="fas fa-check"></i></button>';
                            }
                            return view;
                        }
                    },
                ]
            });
        });

        function sendKonfirmasi(no_abs) {
            swalWithBootstrapButtons.fire({
                text: 'Are you sure you want to confirm the payment?',
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
                        var values = new FormData();
                        values.append("no_abs",no_abs);
                        $.ajax({
                            type: "POST",data:values, url: "{{ url('/api/updatePaymentJournal') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            dataType: 'json', processData: false, contentType: false,
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

        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }
    </script>
@endsection
