@extends('author.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/author')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/author/my_journal')}}">My Journal</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Metadata</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <form id="formExecute" class="formExecute cmxform">
                        <div class="card-body">
                            <div id="view_metadata"></div>
                            <hr/>
                            <h4 class="text-center">ADD METADATA</h4>
                            <div id="form_author">
                                <div class="card mb-1 form-author-0 d-none">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="first_name" class="form-label"><b><code>*)</code>FIRST NAME</b></label>
                                                <input type="text" class="form-control" id="first_name_0" name="first_name[]" placeholder="FIRST NAME..." autocomplete="off">
                                            </div>
                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="midle_name" class="form-label"><b>MIDLE NAME</b></label>
                                                <input type="text" class="form-control" id="midle_name_0" name="midle_name[]" placeholder="MIDLE NAME..." autocomplete="off">
                                            </div>
                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="last_name" class="form-label"><b>LAST NAME</b></label>
                                                <input type="text" class="form-control" id="last_name_0" name="last_name[]" placeholder="LAST NAME..." autocomplete="off">
                                            </div>
                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="email" class="form-label"><b><code>*)</code>E-MAIL</b></label>
                                                <input type="text" class="form-control" id="email_0" name="email[]" placeholder="E-MAIL..." autocomplete="off">
                                            </div>
                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="orcid_id" class="form-label"><b>ORCID ID</b></label>
                                                <input type="text" class="form-control" id="orcid_id_0" name="orcid_id[]" placeholder="ORCID ID..." autocomplete="off">
                                            </div>
                                            <div class="col-12 col-sm-4 form-group">
                                                <label for="country" class="form-label w-100"><b><code>*)</code>COUNTRY</b></label>
                                                <select class="form-control select2" name="country[]" id="country_0" autocomplete="off" style="width: 100%">
                                                    @foreach($dt_negara as $item_negara)
                                                        <option value="{{$item_negara->id_negara}}">{{$item_negara->negara}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-12 form-group">
                                                <label for="institution" class="form-label"><b><code>*)</code>INSTITUTION</b></label>
                                                <textarea class="form-control" id="institution_0" name="institution[]" placeholder="INSTITUTION..." rows="2" autocomplete="off"></textarea>
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
                        <div class="card-footer text-right">
                            <button type="button" class="btn btn-danger">CANCEL</button>
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
        var no_abs = getUrlVars()["abs"];
        var selCountryBio_old = [];
        var num_author = 0;
        $(document).ready(function () {
            setAktifItem('my_journal');
            getMetadata();
        });
        function getMetadata() {
            loader_show();
            $.ajax({
                type: "GET", data:{no_abs:no_abs},
                url: "{{url('api/detailMyJournal')}}", dataType: 'json',
                success: function(response) {
                    loader_hide();
                    if (response.status==="OK"){
                        var view_metadata = "";
                        var form_delete = "";
                        $.each(response.data_metadata, function (index,element) {
                            form_delete = "";
                            if (element.email === "{{Session::get('email')}}") {
                                form_delete = 'd-none';
                            }
                            view_metadata += '<div class="card mb-1">' +
                                '                                <div class="card-body">' +
                                '                                    <div class="row">' +
                                '                                        <div class="col-12 col-sm-4 form-group">' +
                                '                                            <label for="first_name" class="form-label"><b><code>*)</code>FIRST NAME</b></label>' +
                                '                                            <input type="text" class="form-control rounded" id="first_name_old" name="first_name_old[]" value="'+element.nama_depan+'"/>' +
                                '                                            <input type="hidden" name="id_old[]" value="'+element.id_jurnal_author+'"/>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 col-sm-4 form-group">' +
                                '                                            <label for="midle_name" class="form-label"><b>MIDLE NAME</b></label>' +
                                '                                            <input type="text" class="form-control rounded" id="midle_name_old" name="midle_name_old[]" value="'+checkNull(element.nama_tengah,true)+'"/>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 col-sm-4 form-group">' +
                                '                                            <label for="last_name" class="form-label"><b>LAST NAME</b></label>' +
                                '                                            <input type="text" class="form-control rounded" id="last_name_old" name="last_name_old[]" value="'+checkNull(element.nama_belakang,true)+'"/>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 col-sm-5 form-group">' +
                                '                                            <label for="email" class="form-label"><b><code>*)</code>E-MAIL</b></label>' +
                                '                                            <input type="text" class="form-control rounded" id="email_old" name="email_old[]" value="'+element.email+'"/>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 col-sm-3 form-group">' +
                                '                                            <label for="orcid_id" class="form-label"><b>ORCID ID</b></label>' +
                                '                                            <input type="text" class="form-control rounded" id="orcid_id_old" name="orcid_id_old[]" value="'+checkNull(element.orcid_id, true)+'"/>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 col-sm-4 form-group">' +
                                '                                            <label for="country" class="form-label"><b><code>*)</code>COUNTRY</b></label>' +
                                '                                            <select class="form-control rounded w-100" id="country-old-'+index+'" name="country_old[]">' +
                                '                                                <option value="'+element.id_negara+'" selected>'+element.negara+'</option>' +
                                '                                            </select>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 form-group">' +
                                '                                            <label for="institution" class="form-label"><b><code>*)</code>INSTITUTION</b></label>' +
                                '                                            <textarea class="form-control rounded" id="institution_old" name="institution_old[]" rows="3">'+element.institusi+'</textarea>' +
                                '                                        </div>' +
                                '                                        <div class="col-12 form-group">' +
                                '                                            <label for="bio" class="form-label mb-0"><b>BIO STATEMENT</b></label><br/>' +
                                '                                            <textarea class="form-control rounded ckeditor" id="bio-old-'+index+'" name="bio_old[]">'+checkNull(element.biodata, true)+'</textarea>' +
                                '                                        </div>' +
                                '                                    </div>' +
                                '                                </div>' +
                                '<div class="card-footer bg-danger text-white text-center '+form_delete+'">' +
                                '   <div class="form-group form-check mb-0">' +
                                '       <input type="checkbox" class="form-check-input" name="delete_old[]" value="'+element.id_jurnal_author+'">' +
                                '       <label class="form-check-label" for="exampleCheck1">Check if you want to delete the metadata author </label>' +
                                '   </div>' +
                                '</div>' +
                                '                            </div>';
                            selCountryBio_old.push('-old-'+index);
                        });
                        $('#view_metadata').html(view_metadata);
                        $.each(selCountryBio_old, function(key,value) {
                            setSelCKOld(value);
                        });
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

        function setSelCKOld(id) {
            $("#country"+id).select2({
                ajax: {
                    url: "{{ url('/api/selectNegara') }}", type: "POST", dataType: 'json', delay: 250,
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: function (params) {return { q: $.trim(params.term) };},
                    processResults: function (data) {return {results: data};}, cache: true
                }
            });
            CKEDITOR.replace('bio'+id,{height: '150px', width: 'auto'});
        }

        $(document).on('click', '.btn-add-author', function (e) {
            e.preventDefault();
            var controlForm = $(".form-author-0").clone();

            if (num_author == 0) {
                $('.form-author-0').removeClass('d-none');
                $('.select2').select2({"language": "en", placeholder: "Please select and search...",});
                $('#country_0').val("100");
                $('#country_0').trigger('change');
                num_author++;
            } else if (num_author > 2) {
                swall_failed_text("Max 4 metadata");
            } else {
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
                $('#country_'+num_author).val("100");
                $('#country_'+num_author).trigger('change');
                controlForm.removeClass('d-none');
                num_author++;
            }
        });
        function del_author(id) {
            num_author--;
            $('.form-author-'+id.replace('btn_del_author_',"")).remove();
        }

        $(function() {
            $('#formExecute').validate({
                rules: {
                    'first_name_old[]':{required: true,},
                    'email_old[]':{required: true,email:true,},'country_old[]':{ required:true,},
                    'institution_old[]':{required: true,},
                    'first_name[]':{required: true,},
                    'email[]':{required: true,email:true,},'institution[]':{required: true,},
                },
                messages: {
                    'first_name_old[]':{required:'Please fill in',},
                    'email_old[]':{required:'Please fill in',email:'Invalid email'}, 'country_old[]':{required:'Please select',},
                    'institution_old[]':{required:'Please fill in',},
                    'first_name[]':{required:'Please fill in',},
                    'email[]':{required:'Please fill in',email:'Invalid email'}, 'institution[]':{required:'Please fill in',},
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
                                var first_name_old = document.getElementsByName("first_name_old[]");
                                var midle_name_old = document.getElementsByName("midle_name_old[]");
                                var last_name_old = document.getElementsByName("last_name_old[]");
                                var email_old = document.getElementsByName("email_old[]");
                                var orcid_id_old = document.getElementsByName("orcid_id_old[]");
                                var country_old = document.getElementsByName("country_old[]");
                                var institution_old = document.getElementsByName("institution_old[]");
                                var bio_old = document.getElementsByName("bio_old[]");
                                var id_old = document.getElementsByName("id_old[]");
                                var delete_old = document.getElementsByName("delete_old[]");
                                for (var i = 0; i < first_name_old.length; i++) {
                                    if (delete_old[i].checked) {
                                        values.append("delete_old[]",id_old[i].value);
                                    }
                                    values.append("first_name_old[]",first_name_old[i].value);
                                    values.append("midle_name_old[]",midle_name_old[i].value);
                                    values.append("last_name_old[]",last_name_old[i].value);
                                    values.append("email_old[]",email_old[i].value);
                                    values.append("orcid_id_old[]",orcid_id_old[i].value);
                                    values.append("country_old[]",country_old[i].value);
                                    values.append("institution_old[]",institution_old[i].value);
                                    values.append("bio_old[]",bio_old[i].value);
                                    values.append("id_old[]",id_old[i].value);
                                }
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
                                values.append("no_abs",no_abs);
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
                                    type: "POST",data:values, url: "{{ url('/api/updateMyJournalMetadata') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
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
