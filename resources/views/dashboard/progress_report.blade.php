@extends('dashboard.template')

@section('konten')
    <style type="text/css">
        th.dt-center, td.dt-center { text-align: center; }
    </style>
    <section class="inner-header parallax-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><b>PROGRESS REPORT</b></h2>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div style="margin: 15vh 5vw;">
            <h2 class="font-weight-bold text-uppercase mb-5 text-center">Progress</h2>
            <table id="dt_table" class="table table-hover w-100">
                <thead class="text-center">
                <tr>
                    <th>No.</th>
                    <th>User</th>
                    <th>Abstract</th>
                    <th>Presenter</th>
                    <th>Full Paper</th>
                    <th>Full Paper Status</th>
                    <th>Revised Paper</th>
                    <th>Reviewer</th>
                    <th>Progress</th>
                </tr>
                </thead>
            </table>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-progress-report').addClass("active");
            $('#dt_table').DataTable({
                dom: 'Blfrtip',
                processing: true, responsive:true, pagingType: "full_numbers", serverSide: true,destroy: true,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                buttons: [
                    {
                        extend: 'excel', messageTop: 'Data Progres Report',
                        exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ]},
                        title: 'Data Progres Report',
                    },
                    {
                        extend: 'pdf', messageTop: 'Data Progres Report', messageBottom: null,
                        exportOptions: { columns: [ 0, 1, 2 ,3, 4, 5, 6, 7, 8 ] },
                        title: 'Data Progres Report',
                    }
                ],
                ajax: {
                    url: "{{ url('/api/dtTableProgressReport') }}",
                    data: function (d) {
                        d.paper = "ALL";
                        d.paperstt = "ALL";
                        d.paperrevised = "ALL";
                        d.progress = "ALL";
                        d.page = "PROGRESS-REPORT";
                    },
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', "className": "dt-center"},
                    { data: 'no_author', name: 'scope', "className": "dt-center"},
                    { data: 'no_abstrak', name: 'no_abstrak', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            var coressponden_author = "";
                            if (row.nama_depan !== null){coressponden_author += row.nama_depan;}
                            if (row.nama_tengah !== null){coressponden_author += ' '+row.nama_tengah;}
                            if (row.nama_belakang !== null){coressponden_author += ' '+row.nama_belakang;}
                            return coressponden_author;
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            if (row.file_nama === null){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div>';
                            }
                        }, "className": "dt-center"
                    },
                    { data: 'stt_full_paper', name: 'stt_full_paper', "className": "dt-center"},
                    { "render": function ( data, type, row )
                        {
                            if (row.stt_revisi_paper === "EMPTY"){
                                return '<div class="text-danger"><i class="fas fa-times"></i> NO</div>';
                            } else {
                                return '<div class="text-success"><i class="fas fa-check"></i> YA</div>';
                            }
                        }, "className": "dt-center"
                    },
                    { "render": function ( data, type, row )
                        {
                            var coressponden_author = "";
                            if (row.nama_depan_reviewer !== null){coressponden_author += row.nama_depan_reviewer;}
                            if (row.nama_tengah_reviewer !== null){coressponden_author += ' '+row.nama_tengah_reviewer;}
                            if (row.nama_belakang_reviewer !== null){coressponden_author += ' '+row.nama_belakang_reviewer;}
                            return coressponden_author;
                        }, "className": "dt-center"
                    },
                    { data: 'stt_progres_paper', name: 'stt_progres_paper', "className": "dt-center"},
                ]
            });
        });
    </script>
@endsection
