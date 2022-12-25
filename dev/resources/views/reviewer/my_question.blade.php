@extends('reviewer.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/reviewer')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">My Question</li>
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
                                <th>Journal</th>
                                <th>Question</th>
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
        $(document).ready(function () {
            setAktifItem("my_question");
            getData();
        });
        function getData() {
            $('#dt_table').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableMyQuestionReviewer') }}",
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
                            return '<a href="{{url('/reviewer/my_question/detail?abs=')}}'+row.no_abstrak+'&kd='+row.id_jurnal_qa+'">'+row.judul_jurnal+'</a>';
                        }
                    },
                    {data: 'pertanyaan', name: 'pertanyaan'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/reviewer/my_question/edit?abs=')}}'+row.no_abstrak+'" class="btn btn-sm btn-info m-1 btn-block">CHANGE</a>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'my_question\',\''+row.id_jurnal_qa+'\')">DELETE</button>'
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
