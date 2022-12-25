@extends('author.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/author')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/my_journal')}}">My Journal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <form id="formExecute" class="formExecute cmxform" enctype="multipart/form-data">
                        <div class="card-body">
                            <h5 class="card-title py-3 text-brown text-center">ADD JOURNAL</h5>
                            <hr>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5><b>SCOPE</b></h5><hr/>
                                    <div class="form-group mb-0">
                                        <label for="scope" class="form-label"><b><code>*)</code>Scopes</b></label>
                                        <select class="form-control w-100 select2" id="scope" name="scope" autocomplete="off">
                                            <?= $dt_scope; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5><b>METADATA</b></h5><hr/>
                                    <h5>AUTHOR</h5>
                                    <div id="form_author">
                                        <div class="card mb-1 form-author-0">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 col-sm-4 form-group">
                                                        <label for="first_name" class="form-label"><b><code>*)</code>FIRST NAME</b></label>
                                                        <input type="text" class="form-control" id="first_name_0" name="first_name[]" placeholder="FIRST NAME..." value="{{Session::get('nama_depan')}}" autocomplete="off">
                                                    </div>
                                                    <div class="col-12 col-sm-4 form-group">
                                                        <label for="midle_name" class="form-label"><b>MIDLE NAME</b></label>
                                                        <input type="text" class="form-control" id="midle_name_0" name="midle_name[]" placeholder="MIDLE NAME..." value="{{Session::get('nama_tengah')}}" autocomplete="off">
                                                    </div>
                                                    <div class="col-12 col-sm-4 form-group">
                                                        <label for="last_name" class="form-label"><b>LAST NAME</b></label>
                                                        <input type="text" class="form-control" id="last_name_0" name="last_name[]" onblur="setCorresponding()" placeholder="LAST NAME..." value="{{Session::get('nama_belakang')}}" autocomplete="off">
                                                    </div>
                                                    <div class="col-12 col-sm-4 form-group">
                                                        <label for="email" class="form-label"><b><code>*)</code>E-MAIL</b></label>
                                                        <input type="text" class="form-control" id="email_0" name="email[]" onblur="setCorresponding()" placeholder="E-MAIL..." value="{{Session::get('email')}}" autocomplete="off">
                                                    </div>
                                                    <div class="col-12 col-sm-4 form-group">
                                                        <label for="orcid_id" class="form-label"><b>ORCID ID</b></label>
                                                        <input type="text" class="form-control" id="orcid_id_0" name="orcid_id[]" placeholder="ORCID ID..." value="{{Session::get('orcid_id')}}" autocomplete="off">
                                                    </div>
                                                    <div class="col-12 col-sm-4 form-group">
                                                        <label for="country" class="form-label"><b><code>*)</code>COUNTRY</b></label>
                                                        <select class="form-control w-100 select2" name="country[]" id="country_0" autocomplete="off">
                                                            @foreach($dt_negara as $item_negara)
                                                                <option value="{{$item_negara->id_negara}}">{{$item_negara->negara}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label for="institution" class="form-label"><b><code>*)</code>INSTITUTION</b></label>
                                                        <textarea class="form-control" id="institution_0" name="institution[]" placeholder="INSTITUTION..." rows="2" autocomplete="off">{{Session::get('institusi')}}</textarea>
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label for="bio" class="form-label mb-0"><b>BIO STATEMENT</b></label><br/>
                                                        <small>(E.g., Departement and Rank)</small>
                                                        <textarea class="form-control" id="bio_0" name="bio[]" placeholder="BIO..." autocomplete="off"></textarea>
                                                    </div>
                                                    <div class="col-12 text-right">
                                                        <button type="button" onclick="del_author(this.id)" id="btn_del_author_0" class="btn btn-danger mt-2 display-none"><i class="fas fa-times"></i> Remove Author</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-info mt-2 btn-add-author"><i class="fas fa-user-plus"></i> Added The Author</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5><b>CORRESPONDING</b></h5><hr/>
                                    <div class="form-group">
                                        <label for="title" class="form-label"><b><code>*)</code>Author Metada</b></label>
                                        <select class="form-control rounded" id="corresponding" name="corresponding"></select>
                                        <small>*) Please choose one</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5><b>PAPER</b></h5><hr/>
                                    <div class="form-group">
                                        <label for="title" class="form-label"><b><code>*)</code>Title</b></label>
                                        <textarea class="form-control rounded" id="title" name="title" rows="2" placeholder="TITLE..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="abstrac" class="form-label"><b><code>*)</code>Abstract</b> <code>(Only abstract content in English)</code></label>
                                        <textarea class="form-control" id="abstrac" name="abstrac" placeholder="ABSTRACT..."></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="full_paper" class="form-label mb-0"><b>Full Paper</b><small>(DOC/DOCX)</small></label><br/>
                                        <small>(Optional)</small>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="full_paper" name="full_paper">
                                            <label class="custom-file-label text-default" for="ful_paper">Choose File</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="keyword" class="form-label mb-0"><b><code>*)</code>Keywords</b></label><br/>
                                        <small>Provide terms for keywords; separate terms with a semi-colon (term1;term2).</small>
                                        <textarea class="form-control" id="keyword" name="keyword" placeholder="Keywords..." rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5><b>SUPLEMENTARI FILES</b></h5>
                                    <small>(Optional)</small>
                                    <hr/>
                                    <div class="add-controls-suplementari">
                                        <div id="form-suplementari" role="form">
                                            <div class="card add-entry-suplementari">
                                                <div class="card-body p-0">
                                                    <div class="row">
                                                        <div class="col-sm-11">
                                                            <div class="row m-2">
                                                                <div class="col-12 col-sm-6">
                                                                    <div class="form-group">
                                                                        <label for="document_name" class="form-label"><b>DOCUMENT NAME</b></label>
                                                                        <input type="text" class="form-control" id="document_name_0" name="document_name[]" placeholder="DOCUMENT NAME..."/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-sm-6">
                                                                    <label for="document_name" class="form-label"><b>DOCUMENT FILE</b><small>(JPEG/JPG/PNG/PDF/DOC/DOCX)</small></label>
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input" id="document_file_0" name="document_file[]">
                                                                        <label class="custom-file-label text-default" for="ful_paper">CHOOSE FILE</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <button type="button" class="add-colum-suplementari btn btn-primary btn-block h-100" style="border-radius: unset"><i class="fas fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-2">
                                <div class="card-body">
                                    <h5><b>Status Journal</b></h5>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select class="form-control" id="stt_journal" name="stt_journal">
                                            <option value="DRAFT">DRAFT</option>
                                            <option value="COMPLETED FOR A REVIEW">COMPLETED FOR A REVIEW</option>
                                        </select>
                                        <code><small>Please select COMPLETED FOR A REVIEW if your abstract is ready for review before of ABSTRACT SUBMISSION DEADLINE for review.</small></code>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{url('/author/my_journal')}}" type="button" class="btn btn-danger">CANCEL</a>
                            <button type="submit" class="btn btn-primary">SAVE</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var num_author = 0;
        $(document).ready(function () {
            setAktifItem('my_journal');
            CKEDITOR.replace('bio_0',{height: '150px', width: 'auto'});
            CKEDITOR.replace('abstrac',{height: '200px', width: 'auto'});
            $(".select2").select2({"language": "en", placeholder: "Please select and search...",});
            setCorresponding();
        });
        function setCorresponding() {
            var first_name = document.getElementsByName("first_name[]");
            var midle_name = document.getElementsByName("midle_name[]");
            var last_name = document.getElementsByName("last_name[]");
            var email = document.getElementsByName("email[]");
            $('#corresponding').empty();
            for (var i = 0; i < first_name.length; i++) {
                var name_metadata = setName_author(first_name[i].value, midle_name[i].value, last_name[i].value);
                $('#corresponding').append($('<option>', {value: email[i].value, text : name_metadata}));
            }
        }
        $(document).on('click', '.add-colum-suplementari', function(e) {
            e.preventDefault();
            var controlForm = $('.add-controls-suplementari #form-suplementari:first'),
                currentEntry = $(this).parents('.add-entry-suplementari:first'),
                newEntry = $(currentEntry.clone()).appendTo(controlForm);
            // select2 select2-container select2-container--default
            newEntry.find('input').val('');
            newEntry.find('.add-colum-suplementari')
                .removeClass('add-colum-suplementari').addClass('del-colum-suplementari')
                .removeClass('btn-primary').addClass('btn-danger')
                .html('<i class="fas fa-minus"></i>');
        }).on('click', '.del-colum-suplementari', function(e) {
            $(this).parents('.add-entry-suplementari:first').remove();
            e.preventDefault();
            return false;
        });
        $(document).on('click', '.btn-add-author', function (e) {
            e.preventDefault();
            var controlForm = $(".form-author-0").clone();

            if (num_author > 2) {
                swall_failed_text("Max 4 metadata");
            } else {
                num_author++;
                controlForm.find('input').val('');
                controlForm.find('textarea').val('');
                controlForm.find('.cke_1').remove();
                controlForm.find('#first_name_0').removeAttr("id").attr("id","first_name_"+num_author);
                controlForm.find('#midle_name_0').removeAttr("id").attr("id","midle_name_"+num_author);
                controlForm.find('#last_name_0').removeAttr("id").attr("id","last_name_"+num_author);
                controlForm.find('#email_0').removeAttr("id").attr("id","email_"+num_author);
                controlForm.find('#orcid_id_0').removeAttr("id").attr("id","orcid_id_"+num_author);
                controlForm.find('#country_0').removeAttr("id").attr("id","country_"+num_author);
                controlForm.find('#institution_0').removeAttr("id").attr("id","institution_"+num_author);
                controlForm.find('#document_name_0').removeAttr("id").attr("id","document_name_"+num_author);
                controlForm.find('#document_file_0').removeAttr("id").attr("id","document_file_"+num_author);
                controlForm.find('#bio_0').removeAttr("style");
                controlForm.find('#bio_0').removeAttr("id").attr("id","bio_"+num_author);
                controlForm.find('#btn_del_author_0').removeClass('display-none');
                controlForm.find('#btn_del_author_0').removeAttr('id').attr('id','btn_del_author_'+num_author);
                controlForm.removeClass('form-author-0').addClass('form-author-'+num_author);
                controlForm.find('.select2-container').remove();
                controlForm.find('#country_'+num_author).removeClass("select2-hidden-accessible").removeClass("valid");
                controlForm.find('#country_'+num_author).removeAttr("data-select2-id");
                var newEntry = $("#form_author").append(controlForm);
                var name_ck = 'bio_'+num_author;
                CKEDITOR.replace(name_ck,{height: '150px', width: 'auto'});
                $('.select2').select2({"language": "en", placeholder: "Please select and search...",});
            }
        });
        function del_author(id) {
            num_author--;
            $('.form-author-'+id.replace('btn_del_author_',"")).remove();
        }
        $(function() {
            $('#formExecute').validate({
                rules: {
                    scope:{ required:true,},'first_name[]':{required: true,},
                    'email[]':{required: true,email:true,},'country[]':{ required:true,},
                    'institution[]':{required: true,},title:{ required:true,},keyword:{ required:true,},
                    full_paper:{extension: 'doc|docx',},
                    'document_file[]':{extension: 'png|jpeg|jpg|PNG|JPEG|JPG|pdf|doc|docx',},
                },
                messages: {
                    scope:{required:'Please select',},'first_name[]':{required:'Please fill in',},
                    'email[]':{required:'Please fill in',email:'Invalid email'},
                    'country[]':{required:'Please select',},'institution[]':{required:'Please fill in',},title:{required:'Please fill in',},
                    keyword:{required:'Please fill in',},
                    full_paper:{extension: 'Only document files of type DOC and DOCX are allowed',},
                    'document_file[]':{extension: 'Only document files of type PNG , JPEG , JPG, PDF, DOC and DOCX are allowed',},
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
                                loader_show_upload();
                                var values = new FormData();
                                values.append("scope",$('#scope').val());
                                var first_name = document.getElementsByName("first_name[]");
                                var midle_name = document.getElementsByName("midle_name[]");
                                var last_name = document.getElementsByName("last_name[]");
                                var email = document.getElementsByName("email[]");
                                var orcid_id = document.getElementsByName("orcid_id[]");
                                var country = document.getElementsByName("country[]");
                                var institution = document.getElementsByName("institution[]");
                                var bio = document.getElementsByName("bio[]");
                                for (var i = 0; i < first_name.length; i++) {
                                    values.append("first_name[]",first_name[i].value);
                                    values.append("midle_name[]",midle_name[i].value);
                                    values.append("last_name[]",last_name[i].value);
                                    values.append("email[]",email[i].value);
                                    values.append("orcid_id[]",orcid_id[i].value);
                                    values.append("country[]",country[i].value);
                                    values.append("institution[]",institution[i].value);
                                    values.append("bio[]",bio[i].value);
                                }
                                values.append("corresponding",$('#corresponding').val());
                                values.append("title",$('#title').val());
                                values.append("abstrac",CKEDITOR.instances.abstrac.getData());
                                values.append('full_paper', $("#full_paper")[0].files[0]);
                                values.append("keyword",$('#keyword').val());
                                var document_name = document.getElementsByName("document_name[]");
                                var document_file = document.getElementsByName("document_file[]");
                                for (var i = 0; i < document_name.length; i++) {
                                    values.append("document_name[]",document_name[i].value);
                                    values.append("document_file[]",document_file[i].files[0]);
                                }
                                values.append("stt_journal",$('#stt_journal').val());
                                $.ajax({
                                    xhr : function() {
                                        var xhr = new window.XMLHttpRequest();
                                        xhr.upload.addEventListener('progress', function(e){
                                            if(e.lengthComputable){
                                                var percent = Math.round((e.loaded / e.total) * 100);
                                                $('#progressBar-determinate').css('width', percent + '%');
                                            }
                                        });
                                        return xhr;
                                    },
                                    type: "POST",data:values, url: "{{ url('/api/insertMyJournal') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: response.message, icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    window.location.replace("{{url('/author/my_journal')}}");
                                                }
                                            });
                                        } else {
                                            swall_failed_text(response.message);
                                        }
                                    },
                                    error:function(response){
                                        loader_hide_upload();
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
