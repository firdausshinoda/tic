@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Reviewers</li>
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
                                <th>Photo</th>
                                <th>Name</th>
                                <th>E-mail</th>
                                <th>Sex</th>
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
    <a href="{{url('/admin/reviewers/add')}}" class="btn btn-default btn-lg btn-floating shadow rounded-circle">
        <i class="fa fa-plus floating-icon"></i>
    </a>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function() {
            setAktifItem('reviewers');
            $('#dt_table').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableReviewers') }}",
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
                    { "render": function ( data, type, row )
                        {
                            var vw = "";
                            if (row.foto_reviewer === null){
                                vw += '<img src="{{asset('/img/user_default.jpg')}}" style="max-width:5vw" class="img-circle"/>';
                            } else {
                                vw += '<img src="{{asset('/upload/reviewer')}}/'+row.foto_reviewer+'" style="max-width:5vw" class="img-circle"/>';
                            }
                            return vw + '<button class="btn btn-sm btn-default shadow rounded-circle position-relative" id="btn_foto" style="bottom: 3vh;margin-left:3vw" onclick="modal(\'reviewers-photo\',\''+row.id_reviewer+'\')"><i class="fas fa-camera"></i></button>';
                        }
                    },
                    { "render": function ( data, type, row )
                        {return setName_author(row.nama_depan,row.nama_tengah,row.nama_belakang)}
                    },
                    {data: 'email', name: 'email'},
                    {data: 'jenis_kelamin', name: 'jenis_kelamin'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/admin/reviewers/edit?id=')}}'+row.id_reviewer+'" class="btn btn-sm btn-info m-1 btn-block">EDIT</a>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'reviewers\',\''+row.id_reviewer+'\')"><i class="far fa-trash-alt"></i></button>'
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
