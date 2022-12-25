@extends('admin.template')

@section('konten')
    <style type="text/css">
        .dt-buttons{
            display: none;
        }
        .select2-container .select2-selection--single {
            height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }
    </style>
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Authors</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Filter</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-sm-5">
                                <div class="form-group">
                                    <label>Educational Background</label>
                                    <select class="form-control" id="s-education">
                                        <option value="ALL">All</option>
                                        <option value="SMA">SMA (High School)</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                        <option value="S3">S3</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-5">
                                <div class="form-group">
                                    <label>Institution</label>
                                    <select class="form-control" id="s-institution">
                                        <option value="ALL">All</option>
                                        @foreach($institusi as $item)
                                            <option value="{{$item->institusi}}">{{$item->institusi}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="form-group">
                                    <label>Action</label>
                                    <button type="button" class="btn btn-primary btn-block" onclick="reloadTable()">Search</button>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr/>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-primary btn-block" onclick="return $('.buttons-excel').click()">Download Excel</button>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-outline-primary btn-block" onclick="return $('.buttons-pdf').click()">Download PDF</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow-sm mt-1">
                    <div class="card-body">
                        <table id="dt_table" class="table table-striped" width="100%">
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Name</th>
                                <th>Last Education</th>
                                <th>Institution</th>
                                <th>E-mail</th>
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
            setAktifItem('authors');
            getData();
            $("#s-institution").select2({"language": "en", placeholder: "Please select and search...",});
        });
        function getData() {
            $('#dt_table').DataTable({
                processing: true,responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excel', messageTop: 'Data Author',
                        exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5 ]},
                        title: 'Data Author',
                    },
                    {
                        extend: 'pdf', messageTop: 'Data Author', messageBottom: null,
                        exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5 ] },
                        title: 'Data Author',
                    }
                ],
                ajax: {
                    url: "{{ url('/api/dtTableAuthors') }}",
                    data: function (d) {
                        d.education = $('#s-education').val();
                        d.institution = $('#s-institution').val();
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
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/admin/authors/detail?atr=')}}'+row.no_author+'">'+setName_author(row.nama_depan,row.nama_tengah,row.nama_belakang)+'</a>';
                        }, "className": "dt-justify"
                    },
                    {data: 'pddk_terakhir', name: 'pddk_terakhir'},
                    {data: 'institusi', name: 'institusi'},
                    {data: 'email', name: 'email'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'author\',\''+row.id_author+'\')">DELETE</button>'
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
