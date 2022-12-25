@extends('author.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/author')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/author/account')}}">Account</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <center><h5 class="card-title text-dark py-3">ACCOUNT</h5></center>
                        <hr>
                        <form id="formExecute" class="formExecute">
                            <div class="row text-dark">
                                <div class="col-sm-12 text-center pb-5">
                                    <div style="width: 150px; margin-right: auto;margin-left: auto">
                                        <img id="foto" class="rounded-circle border rounded w-100" src="<?= empty(Session::get('foto_author')) ? asset('img/user_default.jpg') : asset('/upload/author/'.Session::get('foto_author')); ?>">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>FIRST NAME</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="first_name" name="first_name" value="{{Session::get('nama_depan')}}" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b>MIDDLE NAME</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="middle_name" name="middle_name" value="{{Session::get('nama_tengah')}}" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>LAST NAME</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="last_name" name="last_name" value="{{Session::get('nama_belakang')}}" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <div class="form-group">
                                        <label><b><code>*)</code>GENDER</b></label><br/>
                                        <select class="form-control" id="sex" name="sex">
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <div class="form-group">
                                        <label><b><code>*)</code>BIRTHDAY</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount datepicker" id="birthday" name="birthday" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <div class="form-group">
                                        <label><b><code>*)</code>LAST EDUCATION</b></label><br/>
                                        <select class="form-control" id="last_education" name="last_education">
                                            <option value="SMA">SMA (HIGH SCHOOLS)</option>
                                            <option value="S1">S1 (UNDERGRADUATE)</option>
                                            <option value="S2">S2 (POST GRADUATE)</option>
                                            <option value="S3">S3 (DOCTORAL)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <div class="form-group">
                                        <label><b><code>*)</code>BACHELOR'S DEGREE</b></label><br/>
                                        <select class="form-control select2" id="bachelor_degree" name="bachelor_degree">
                                            @foreach($dt_gelar as $item_gelar)
                                                <option value="{{\App\Helpers\Helpers::enkrip($item_gelar->id_gelar)}}">{{$item_gelar->gelar}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>E-MAIL</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="email" name="email" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>PHONE NUMBER</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="phone_number" name="phone_number" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b>FAX NUMBER</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="fax_number" name="fax_number" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label><b><code>*)</code>ADDRESS</b></label><br/>
                                        <textarea class="form-control h-min-formaccount" id="address" name="address" placeholder="Please fill in..." rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>CITY</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="city" name="city" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>POSTAL CODE</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="postal_code" name="postal_code" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>COUNTRY</b></label><br/>
                                        <select class="form-control select2" id="country" name="country">
                                            @foreach($dt_negara as $item_negara)
                                                <option value="{{\App\Helpers\Helpers::enkrip($item_negara->id_negara)}}">{{$item_negara->negara}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label><b><code>*)</code>INSTITUTION (FULL NAME)</b></label><br/>
                                        <textarea class="form-control h-min-formaccount" id="institution" name="institution" placeholder="Please fill in..." rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label><b>RESEARCH</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="research" name="research" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label><b>ORCID ID</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="orcid_id" name="orcid_id" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <div class="form-group">
                                        <label><b>OTHER INFORMATION</b></label><br/>
                                        <textarea class="form-control h-min-formaccount" id="other_information" name="other_information" placeholder="Please fill in..." rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2 text-right">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="history.back()">CANCEL</button>
                                    <button type="submit" class="btn btn-sm btn-primary">SAVE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            getData();
        });
        function getData() {
            loader_show();
            $.ajax({
                type: "GET",
                url: "{{ url('/api/getAccountAuthor') }}",
                success: function(response) {
                    loader_hide();
                    if (response.status === "OK"){
                        var dt = response.data;
                        $('#birthday').val(dt.tgl_lahir);
                        $('#email').val(dt.email);
                        $('#phone_number').val(dt.no_hp);
                        $('#fax_number').val(dt.no_fax);
                        $('#address').val(dt.alamat);
                        $('#city').val(dt.kota);
                        $('#postal_code').val(dt.kode_pos);
                        $('#institution').val(dt.institusi);
                        $('#research').val(dt.research);
                        $('#orcid_id').val(dt.orcid_id);
                        $('#other_information').val(dt.informasi_lain);
                        $("select[name='sex'] > option").each(function () {
                            if (this.value === dt.jenis_kelamin){$("#sex").val(this.value).change();}
                        });
                        $("select[name='last_education'] > option").each(function () {
                            if (this.value === dt.pddk_terakhir){$("#last_education").val(this.value).change();}
                        });
                        $("select[name='bachelor_degree'] > option").each(function () {
                            if (this.value === dt.id_gelar.toString()){$("#bachelor_degree").val(this.value).change();}
                        });
                        $("select[name='country'] > option").each(function () {
                            if (this.value === dt.id_negara.toString()){$("#country").val(this.value).change();}
                        });
                        $(".select2").select2({"language": "en", placeholder: "Please select and search...",});
                        $(".datepicker").datepicker({
                            format: "yyyy-mm-dd",
                            todayHighlight: true,
                            autoclose: true
                        }).attr("readonly", "readonly").css({"cursor":"pointer", "background":"white"});
                    } else {
                        swall_failed_text(response.message);
                    }
                }, error:function(response) {
                    loader_hide();
                    swall_error();
                }
            })
        }
        $(function() {
            $('#formExecute').validate({
                rules: {
                    first_name: { required: true, lettersonlys: true, }, middle_name: {lettersonlys: true,}, last_name: { required: true, lettersonlys: true, },
                    institution: { required: true, }, birthday: { required: true, }, email: { required: true, emailfull: true, },
                    address: { required: true, }, city: { required: true, }, postal_code: { required: true, },
                    phone_number: { required: true, digits: true, minlength: 8, maxlength: 14, },
                },
                messages: {
                    first_name: { required: "Please fill in", lettersonlys: "Only alphabet and space only", },
                    middle_name: { lettersonlys: "Only alphabet and space only", },
                    last_name: { required: "Please fill in", lettersonlys: "Only alphabet and space only", },
                    institution: { required: "Please fill in", }, birthday: { required: "Please fill in", },
                    email: { required: "Please fill in", emailfull: "E-mail invalid" }, address: { required: "Please fill in", },
                    city: { required: "Please fill in", }, postal_code: { required: "Please fill in", },
                    phone_number: { required: "Please fill in", digits: "Only numbers", minlength: "Minimum 8 digits", maxlength: "Max 14 digits", },
                },
                errorElement : 'div',
                errorPlacement: function(error, element) {
                    var placement = $(element).data('error');
                    if (placement) {
                        $(placement).append(error)
                    } else {
                        error.insertAfter(element);
                    }
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
                            loader_show();
                            return new Promise(function (resolve) {
                                var values = $('#formExecute').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/updateAccountAuthor') }}",
                                    dataType: 'json', headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: response.message, icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    window.location.replace("{{url('/author/account')}}");
                                                }
                                            });
                                        } else {
                                            swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: response.message});
                                        }
                                    },
                                    error:function(data){
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
