@extends('author.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/author')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/author/my_journal')}}">My Journal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <form id="formExecute" class="formExecute cmxform">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="scope" class="form-label"><b>Scope</b></label>
                                <div class="form-control" id="scope"></div>
                            </div>
                            <div class="form-group">
                                <label for="title" class="form-label"><b><code>*)</code>Title</b></label>
                                <textarea class="form-control rounded" id="title" name="title" rows="2" placeholder="Title..."></textarea>
                            </div>
                            <div class="form-group">
                                <label for="abstrac" class="form-label"><b><code>*)</code>Abstract</b> <code>(Only abstract content in English)</code></label>
                                <textarea class="form-control" id="abstrac" name="abstrac" placeholder="Abstract..."></textarea>
                            </div>
                            <div class="form-group">
                                <label for="keyword" class="form-label mb-0"><b><code>*)</code>Keywords</b></label><br/>
                                <textarea class="form-control" id="keyword" name="keyword" placeholder="KEYWORD..." rows="2"></textarea>
                                <small>Provide terms for keywords; separate terms with a semi-colon (term1;term2).</small>
                            </div>
                            <div class="form-group">
                                <label for="stt_journal" class="form-label mb-0"><b>STATUS</b></label><br/>
                                <select class="form-control border rounded" id="stt_journal" name="stt_journal">
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="COMPLETED FOR A REVIEW">COMPLETED FOR A REVIEW</option>
                                </select>
                                <code><small>Please select COMPLETED FOR A REVIEW if your abstract is ready for review before of ABSTRACT SUBMISSION DEADLINE for review.</small></code>
                            </div>
                            <hr/>
                            <div class="text-right">
                                <a id="btn_cancel" class="btn btn-danger">CANCEL</a>
                                <button type="submit" class="btn btn-primary">SAVE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var no_abs = getUrlVars()["abs"];
        $(document).ready(function () {
            setAktifItem('my_journal');
            getJurnal();
        });
        function getJurnal() {
            loader_show();
            $.ajax({
                type: "GET", data:{no_abs:no_abs},
                url: "{{url('api/detailMyJournal')}}", dataType: 'json',
                success: function(response) {
                    loader_hide();
                    if (response.status==="OK"){
                        var dt_jurnal = response.data_journal;
                        $('#title').val(dt_jurnal.judul_jurnal);
                        $('#abstrac').val(dt_jurnal.abstrak_jurnal);
                        $('#keyword').val(dt_jurnal.keyword_jurnal);
                        $("#scope").html(dt_jurnal.scope);
                        CKEDITOR.replace('abstrac',{height: '200px', width: 'auto'});
                        if (dt_jurnal.stt_jurnal !== "DRAFT"){
                            $("select[name='stt_journal'] > option").each(function () {
                                if (this.value === "PUBLISH"){$("#stt_journal").val(this.value).change();}
                            });
                        }
                        $('#btn_cancel').attr('href',"{{url('/author/my_journal/detail?abs=')}}"+dt_jurnal.no_abstrak);
                    } else {
                        swall_failed_text(response.message);
                    }
                },
                error:function(data){
                    loader_hide();
                    swall_error();
                }
            });
        }
        $(function() {
            $('#formExecute').validate({
                rules: {
                    title:{ required:true,},keyword:{ required:true,},
                },
                messages: {
                    title:{required:'Please fill in',},keyword:{required:'Please fill in',},
                },
                submitHandler: function(form) {
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
                                var values = new FormData();
                                values.append("no_abs",no_abs);
                                values.append("title",$('#title').val());
                                values.append("abstrac",CKEDITOR.instances.abstrac.getData());
                                values.append("keyword",$('#keyword').val());
                                values.append("stt_journal",$('#stt_journal').val());
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/updateMyJournal') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    window.location.replace("{{url('/author/my_journal/detail?abs=')}}"+no_abs);
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
            });
        });
    </script>
@endsection
