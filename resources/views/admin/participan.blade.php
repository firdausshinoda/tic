@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Participan</li>
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
                                <th>Name</th>
                                <th>Event</th>
                                <th>Last Education</th>
                                <th>Institution</th>
                                <th>Payment</th>
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
            setAktifItem('participan');
            getData();
        });
        function getData() {
            $('#dt_table').DataTable({
                processing: true,responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: "{{ url('/api/dtTableParticipan') }}",language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/admin/participan/detail?atr=')}}'+row.no_participan+'">'+setName_author(row.nama_depan,row.nama_tengah,row.nama_belakang)+'</a>';
                        }, "className": "dt-justify"
                    },
                    {data: 'event', name: 'event'},
                    {data: 'pddk_terakhir', name: 'pddk_terakhir'},
                    {data: 'institusi', name: 'institusi'},
                    {data: 'stt_pembayaran_konfirmasi', name: 'stt_pembayaran_konfirmasi', "className": "dt-center"},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'participan\',\''+row.id_participan+'\')">DELETE</button>'
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
