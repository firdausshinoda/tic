@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Country</li>
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
    <a href="{{url('/admin/country/add')}}" class="btn btn-default btn-lg btn-floating shadow rounded-circle">
        <i class="fa fa-plus floating-icon"></i>
    </a>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            setAktifItem('country');
            $('#dt_table').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableCountry') }}",
                    data: function (d) {
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        return response
                    },
                },
                language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'negara', name: 'negara'},
                    {data: 'stt_data', name: 'stt_data'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/admin/country/edit?id=')}}'+row.id_negara+'" class="btn btn-sm btn-info m-1 btn-block">EDIT</a>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'country\',\''+row.id_negara+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        });

        function reloadTable() {
            $('#dt_table').DataTable().ajax.reload();
        }
    </script>
@endsection
