@extends('admin.template')

@section('konten')
    <style type="text/css">
        .nav-link{
            padding: .5rem .9rem;
        }
    </style>
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/events')}}">Events</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card mb-3">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="pills-cohost-tab" data-toggle="pill" href="#pills-cohost" role="tab" aria-controls="pills-cohost" aria-selected="true">CO HOST</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-indexing-tab" data-toggle="pill" href="#pills-indexing" role="tab" aria-controls="pills-indexing" aria-selected="false">INDEXING</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-payment-tab" data-toggle="pill" href="#pills-payment" role="tab" aria-controls="pills-payment" aria-selected="false">TYPE PAYMENT</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-collaboration-tab" data-toggle="pill" href="#pills-collaboration" role="tab" aria-controls="pills-collaboration" aria-selected="false">COLLABORATION</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-keynote-speaker-tab" data-toggle="pill" href="#pills-keynote-speaker" role="tab" aria-controls="pills-keynote-speaker" aria-selected="false">KEYNOTE SPEAKER</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-invited-speaker-tab" data-toggle="pill" href="#pills-invited-speaker" role="tab" aria-controls="pills-invited-speaker" aria-selected="false">INVITED SPEAKER</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#pills-setting" role="tab" aria-controls="pills-setting" aria-selected="false">SETTING</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-sub-tab" data-toggle="pill" href="#pills-sub" role="tab" aria-controls="pills-sub" aria-selected="false">SUB</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-scope-tab" data-toggle="pill" href="#pills-scope" role="tab" aria-controls="pills-scope" aria-selected="false">SCOPE</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-vc-tab" data-toggle="pill" href="#pills-vc" role="tab" aria-controls="pills-vc" aria-selected="false">VC</a></li>
                        <li class="nav-item"><a class="nav-link" id="pills-timeline-tab" data-toggle="pill" href="#pills-timeline" role="tab" aria-controls="pills-timeline" aria-selected="false">TIMELINE</a></li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-cohost" role="tabpanel" aria-labelledby="pills-paper-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="modal('cohost-add','{{$slug}}')"><i class="fas fa-pencil-alt"></i> ADD</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_cohost" class="table table-striped w-100">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Link</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-indexing" role="tabpanel" aria-labelledby="pills-indexing-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="modal('indexing-add','{{$slug}}')"><i class="fas fa-pencil-alt"></i> ADD</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_indexing" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Link</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-payment" role="tabpanel" aria-labelledby="pills-payment-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="modal('type-payment-add','{{$slug}}')"><i class="fas fa-pencil-alt"></i> ADD</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_payment" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Type Payment</th>
                                        <th>Payment Type Name</th>
                                        <th>Number</th>
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
                    <div class="tab-pane fade" id="pills-collaboration" role="tabpanel" aria-labelledby="pills-collaboration-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="modal('collaboration-add','{{$slug}}')"><i class="fas fa-pencil-alt"></i> ADD</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_collaboration" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Logo</th>
                                        <th>Link</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-keynote-speaker" role="tabpanel" aria-labelledby="pills-keynote-speaker-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="modal('keynote-speaker-add','{{$slug}}')"><i class="fas fa-pencil-alt"></i> ADD</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_keynote_speaker" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Sub</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Institution</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-invited-speaker" role="tabpanel" aria-labelledby="pills-invited-speaker-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="modal('invited-speaker-add','{{$slug}}')"><i class="fas fa-pencil-alt"></i> ADD</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_invited_speaker" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Sub</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Institution</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-setting" role="tabpanel" aria-labelledby="pills-setting-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="reloadTableSetting()"><i class="fas fa-sync-alt"></i> REFRESH</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_setting" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-sub" role="tabpanel" aria-labelledby="pills-sub-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="modal('sub-add','{{$slug}}')"><i class="fas fa-pencil-alt"></i> ADD</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_sub" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>File Template</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-scope" role="tabpanel" aria-labelledby="pills-scope-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="modal('scope-add','{{$slug}}')"><i class="fas fa-pencil-alt"></i> ADD</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_scope" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Sub Name</th>
                                        <th>Scope</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-vc" role="tabpanel" aria-labelledby="pills-vc-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="modal('vc-add','{{$slug}}')"><i class="fas fa-pencil-alt"></i> ADD</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_vc" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Sub Name</th>
                                        <th>VC Name</th>
                                        <th>Icon</th>
                                        <th>Link</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-timeline" role="tabpanel" aria-labelledby="pills-timeline-tab">
                        <div class="card">
                            <div class="card-body text-right">
                                <button type="button" class="btn btn-default btn-sm" onclick="modal('timeline-add','{{$slug}}')"><i class="fas fa-pencil-alt"></i> ADD</button>
                            </div>
                            <div class="card-body">
                                <table id="dt_table_timeline" class="table table-striped" width="100%">
                                    <thead>
                                    <tr class="text-center">
                                        <th>No</th>
                                        <th>Timeline Name</th>
                                        <th>Timeline Date</th>
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
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var slug = "{{$slug}}";
        $(document).ready(function() {
            setAktifItem('events');
            dtTableCohost();
        });
        function dtTableCohost() {
            $('#dt_table_cohost').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableCoHost') }}",
                    data: function (d) {
                        d.slug = slug;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        dtTableIndexing();
                        return response
                    },
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama', name: 'nama'},
                    { "render": function ( data, type, row )
                        {return '<img src="{{asset('/upload/co_host')}}/'+row.thumbnail+'" style="max-width:5vw"/>'}
                    },
                    {data: 'link', name: 'link'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'cohost-edit\',\''+row.id_cohost+'\')">EDIT</a>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'co_host\',\''+row.id_cohost+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        }
        function dtTableIndexing() {
            $('#dt_table_indexing').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableIndexing') }}",
                    data: function (d) {
                        d.slug = slug;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        dtTablePayment();
                        return response
                    },
                },
                language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama', name: 'nama'},
                    { "render": function ( data, type, row )
                        {return '<img src="{{asset('/upload/index')}}/'+row.logo+'" style="max-width:10vw"/>'}
                    },
                    {data: 'link', name: 'link'},
                    {data: 'stt_data', name: 'stt_data'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'indexing-edit\',\''+row.id_indexing+'\')">EDIT</button>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'indexing\',\''+row.id_indexing+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        }
        function dtTablePayment() {
            $('#dt_table_payment').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableTypePayment') }}",
                    data: function (d) {
                        d.slug = slug;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        dtTableCollaboration();
                        return response
                    },
                },language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { "render": function ( data, type, row )
                        {
                            return '<a href="javascript:void(0)" onclick="modal(\'type-payment-detail\',\''+row.id_jenis_pembayaran+'\')">'+row.jenis_pembayaran+'</a>';
                        }, "className": "dt-justify"
                    },
                    {data: 'nama_jenis_pembayaran', name: 'nama_jenis_pembayaran'},
                    {data: 'nomor_jenis_pembayaran', name: 'nomor_jenis_pembayaran'},
                    {data: 'an_jenis_pembayaran', name: 'an_jenis_pembayaran'},
                    {data: 'stt_data', name: 'stt_data'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'type-payment-edit\',\''+row.id_jenis_pembayaran+'\')">EDIT</button>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'type_payment\',\''+row.id_jenis_pembayaran+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        }
        function dtTableCollaboration() {
            $('#dt_table_collaboration').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableCollaboration') }}",
                    data: function (d) {
                        d.slug = slug;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        dtTableKeynoteSpeaker();
                        return response
                    },
                },
                language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama', name: 'nama'},
                    { "render": function ( data, type, row )
                        {return '<img src="{{asset('/upload/kerjasama')}}/'+row.logo+'" style="max-width:5vw"/>'}
                    },
                    {data: 'link', name: 'link'},
                    {data: 'stt_data', name: 'stt_data'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'collaboration-edit\',\''+row.id_kerjasama+'\')">EDIT</button>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'kerjasama\',\''+row.id_kerjasama+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        }
        function dtTableKeynoteSpeaker(){
            $('#dt_table_keynote_speaker').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableKeynoteSpeaker') }}",
                    data: function (d) {
                        d.slug = slug;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        dtTableInvitedSpeaker();
                        return response
                    },
                },
                language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'sub', name: 'sub'},
                    { "render": function ( data, type, row )
                        {return '<a href="javascript:void(0)" onclick="modal(\'keynote-speaker-detail\',\''+row.id_keynote_speaker+'\')">'+row.nama+'</a>'}
                    },
                    { "render": function ( data, type, row )
                        {return '<img src="{{asset('/upload/keynote_speaker')}}/'+row.thumbnail+'" style="max-width:5vw"/>'}
                    },
                    {data: 'institusi', name: 'institusi'},
                    {data: 'stt_data', name: 'stt_data'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'keynote-speaker-edit\',\''+row.id_keynote_speaker+'\')">EDIT</button>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'keynote_speaker\',\''+row.id_keynote_speaker+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        }
        function dtTableInvitedSpeaker(){
            $('#dt_table_invited_speaker').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableInvitedSpeaker') }}",
                    data: function (d) {
                        d.slug = slug;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        dtTableSetting();
                        return response
                    },
                },
                language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'sub', name: 'sub'},
                    { "render": function ( data, type, row )
                        {return '<a href="javascript:void(0)" onclick="modal(\'invited-speaker-detail\',\''+row.id_invited_speaker+'\')">'+row.nama+'</a>'}
                    },
                    { "render": function ( data, type, row )
                        {return '<img src="{{asset('/upload/invited_speaker')}}/'+row.thumbnail+'" style="max-width:5vw"/>'}
                    },
                    {data: 'institusi', name: 'institusi'},
                    {data: 'stt_data', name: 'stt_data'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'invited-speaker-edit\',\''+row.id_invited_speaker+'\')">EDIT</button>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'invited_speaker\',\''+row.id_invited_speaker+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        }
        function dtTableSetting() {
            $('#dt_table_setting').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableSetting') }}",
                    data: function (d) {
                        d.slug = slug;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        dtTableSub();
                        return response
                    },
                },
                language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'nama', name: 'nama'},
                    { "render": function ( data, type, row )
                        {
                            if (row.key === "ketua_file_ttd" || row.key === "bendahara_file_ttd") {
                                if (row.deskripsi === null) {
                                    return "The file doesn't exist yet. Please add.";
                                } else {
                                    return '<img src="{{asset('/upload/ttd')}}/'+row.deskripsi+'" class="w-100 border"/>';
                                }
                            } else {
                                var deskripsi = row.deskripsi;
                                if (deskripsi !== null) {
                                    deskripsi = row.deskripsi.replace(/&amp;nbsp;/g,"").substr(0,300);
                                    if (row.deskripsi.length > 300) {
                                        deskripsi += " . . .";
                                    }
                                }
                                return deskripsi;
                            }
                        }
                    },
                    { "render": function ( data, type, row )
                        {
                            return '<a href="{{url('/admin/event')}}/'+slug+'/edit/'+row.id+'-'+row.stt_edit+"-"+row.key+'" class="btn btn-sm btn-info m-1 btn-block" target="_blank">EDIT</a>';
                        }
                    },
                ]
            });
        }
        function dtTableSub() {
            $('#dt_table_sub').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableSub') }}",
                    data: function (d) {
                        d.slug = slug;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        dtTableScope();
                        return response
                    },
                },
                language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    { "render": function ( data, type, row )
                        {return '<img src="{{asset('/upload/sub')}}/'+row.thumbnail+'" style="max-width:5vw"/>'}
                    },
                    {data: 'sub', name: 'sub'},
                    {data: 'deskripsi', name: 'deskripsi'},
                    { "render": function ( data, type, row )
                        {
                            if (row.template===null||row.template==="null"){
                                return '<div class="text-danger">NOT AVAILABLE</div>';
                            } else {
                                return '<div class="text-success">AVAILABLE</div><a href="{{url('download?type=sub_template&file=')}}'+row.template+'&name='+row.sub+'" class="btn btn-primary btn-sm btn-block text-white">DOWNLOAD</a>';
                            }
                        }, "className": "dt-center"
                    },
                    {data: 'stt_data', name: 'stt_data'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'sub-edit\',\''+row.id_sub+'\')">EDIT</button>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'sub\',\''+row.id_sub+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        }
        function dtTableScope() {
            $('#dt_table_scope').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableScope') }}",
                    data: function (d) {
                        d.slug = slug;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        dtTableVC();
                        return response
                    },
                },
                language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'sub', name: 'sub'},
                    {data: 'scope', name: 'scope'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'scope-edit\',\''+slug+'\',\''+row.id_scope+'\')">EDIT</button>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'scope\',\''+row.id_scope+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        }
        function dtTableVC() {
            $('#dt_table_vc').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableVC') }}",
                    data: function (d) {
                        d.slug = slug;
                        loader_show();
                    },
                    dataFilter: function(response){
                        loader_hide();
                        dtTableTimeline();
                        return response
                    },
                },
                language : {"url" : "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Indonesian.json"},
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'sub', name: 'sub'},
                    {data: 'vc', name: 'vc'},
                    { "render": function ( data, type, row )
                        {return '<i class="'+row.icon+'"></i>'}
                    },
                    {data: 'link', name: 'link'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'vc-edit\',\''+slug+'\',\''+row.id_vc+'\')">EDIT</button>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'vc\',\''+row.id_vc+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        }
        function dtTableTimeline() {
            $('#dt_table_timeline').DataTable({
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                ajax: {
                    url: "{{ url('/api/dtTableTimeline') }}",
                    data: function (d) {
                        d.slug = slug;
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
                    {data: 'timeline', name: 'timeline'},
                    {data: 'date', name: 'date'},
                    {data: 'stt_data', name: 'stt_data'},
                    { "render": function ( data, type, row ) {return moment(row.created_at).fromNow();}},
                    { "render": function ( data, type, row )
                        {
                            return '<button type="button" class="btn btn-sm btn-info m-1 btn-block" onclick="modal(\'timeline-edit\',\''+row.id_timeline+'\')">EDIT</button>' +
                                '<button type="button" class="btn btn-sm btn-danger m-1 btn-block" onclick="ajaxDelete(\'timeline\',\''+row.id_timeline+'\')"><i class="far fa-trash-alt"></i></button>'
                        }
                    },
                ]
            });
        }
        function reloadTableCoHost() {
            $('#dt_table_cohost').DataTable().ajax.reload();
        }
        function reloadTableIndexing() {
            $('#dt_table_indexing').DataTable().ajax.reload();
        }
        function reloadTablePayment() {
            $('#dt_table_payment').DataTable().ajax.reload();
        }
        function reloadTableCollaboration() {
            $('#dt_table_collaboration').DataTable().ajax.reload();
        }
        function reloadTableKeynoteSpeaker() {
            $('#dt_table_keynote_speaker').DataTable().ajax.reload();
        }
        function reloadTableInvitedSpeaker() {
            $('#dt_table_invited_speaker').DataTable().ajax.reload();
        }
        function reloadTableSetting() {
            $('#dt_table_setting').DataTable().ajax.reload();
        }
        function reloadTableSub() {
            $('#dt_table_sub').DataTable().ajax.reload();
        }
        function reloadTableScope() {
            $('#dt_table_scope').DataTable().ajax.reload();
        }
        function reloadTableVC() {
            $('#dt_table_vc').DataTable().ajax.reload();
        }
        function reloadTableTimeline() {
            $('#dt_table_timeline').DataTable().ajax.reload();
        }
    </script>
@endsection
