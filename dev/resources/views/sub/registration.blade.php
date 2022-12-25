@extends('sub.template')

@section('konten')
    <style type="text/css">
        .text-orange:hover, .text-orange {
            color: #ee8519;
        }
        .border-orange {
            border-color: #ee8519 !important;
        }
    </style>
    <section style="padding: 15vh 0;">
        <div class="container">
            <h3 class="text-center pt-5"><b>REGISTRATION</b></h3>
            <hr class="hr-title"/>
            <div class="card shadow" style="border-left-style: solid;border-left-color: #ee8519;border-left-width: 5px;">
                <div class="card-body">
                    <h4><b>REGISTRATION PROCEDURE </b></h4>
                    <ul>
                        <li>User fill in the registration form and click the register button</li>
                        <li>Automail will be sent to the user, then user has to open activation link sent in the email</li>
                        <li>User can login and submit abstract, payment, full paper, etc</li>
                    </ul>
                </div>
            </div>
            <div class="card shadow mt-5">
                <form id="formExecute" class="formExecute">
                    <div class="hr-custom"></div>
                    <div class="card-header">
                        <h3 class="card-title mt-3 mb-3">Form Registration</h3>
                    </div>
                    <div class="card-body row">
                        <div class="col-sm-12 col-md-4 form-group">
                            <label><code>*)</code>FIRST NAME</label>
                            <input type="text" class="form-control" id="nama_depan" name="nama_depan" placeholder="Please fill in..." autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-4 form-group">
                            <label>MIDDLE NAME</label>
                            <input type="text" class="form-control" id="nama_tengah" name="nama_tengah" placeholder="Please fill in..." autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-4 form-group">
                            <label><code>*)</code>LAST NAME</label>
                            <input type="text" class="form-control" id="nama_belakang" name="nama_belakang" placeholder="Please fill in..." autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-6 form-group">
                            <label><code>*)</code>STATUS</label>
                            <select class="form-control" id="sebagai" name="sebagai">
                                <option value="" selected="">--CHOOSE--</option>
                                <option value="AUTHOR">PRESENTER/AUTHOR</option>
                                <option value="PARTICIPAN">PARTICIPANT</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 form-group">
                            <label><code>*)</code>GENDER</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                                <option value="" selected="">--CHOOSE--</option>
                                <option value="MALE">MALE</option>
                                <option value="FEMALE">FEMALE</option>
                            </select>
                        </div>
                        <div class="col-sm-12 col-md-6 form-group">
                            <label><code>*)</code>DATE OF BIRTH</label>
                            <input type="text" class="form-control w-100 datepicker" id="tgl_lahir" name="tgl_lahir"/>
                        </div>
                        <div class="col-sm-12 col-md-6 form-group">
                            <label><code>*)</code>EDUCATIONAL BACKGROUND</label>
                            <select class="form-control" id="pddk_terakhir" name="pddk_terakhir">
                                <option value="" selected="">--Choose--</option>
                                <option value="SMA">SMA (HIGH SCHOOLS)</option>
                                <option value="S1">S1 (UNDERGRADUATE)</option>
                                <option value="S2">S2 (POST GRADUATE)</option>
                                <option value="S3">S3 (DOCTORAL)</option>
                            </select>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label><code>*)</code>INSTITUTION</label>
                            <textarea class="form-control" id="institusi" name="institusi" placeholder="Please fill in..." rows="3" autocomplete="off"></textarea>
                        </div>
                        <div class="col-sm-12 col-md-4 form-group">
                            <label>RESEARCH</label>
                            <input type="text" class="form-control" id="research" name="research" placeholder="Your research area or expertise..." autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-4 form-group">
                            <label>ORCID ID</label>
                            <input type="text" class="form-control" id="orcid_id" name="orcid_id" placeholder="Please fill in..." autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-4 form-group">
                            <label><code>*)</code>E-MAIL</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Please fill in..." autocomplete="off">
                            <small>One email address only. Activation link will be sent to your email. This email will be used in ALL correspondence.</small>
                        </div>
                        <div class="col-sm-12 form-group">
                            <label><code>*)</code>ADDRESS</label>
                            <div class="row">
                                <div class="col-sm-12 mb-1">
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Address..." rows="3" autocomplete="off"></textarea>
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" class="form-control" id="kota" name="kota" placeholder="City..." autocomplete="off">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <input type="text" class="form-control" id="kode_pos" name="kode_pos" placeholder="Postal Code..." autocomplete="off">
                                </div>
                                <div class="col-sm-12 col-md-4">
                                    <select class="form-control w-100 select2" name="negara" id="negara">
                                        @foreach($dt_negara as $item_negara)
                                            <option value="{{$item_negara->id_negara}}">{{$item_negara->negara}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6 form-group">
                            <label><code>*)</code>PHONE NUMBER</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Please fill in..." autocomplete="off">
                        </div>
                        <div class="col-sm-12 col-md-6 form-group">
                            <label>FAX NUMBER</label>
                            <input type="text" class="form-control" id="no_fax" name="no_fax" placeholder="Please fill in..." autocomplete="off">
                        </div>
                        <div class="col-sm-12 form-group">
                            <label>OTHER INFORMATION</label>
                            <textarea class="form-control" id="informasi_lain" name="informasi_lain" placeholder="Please fill in..." rows="3" autocomplete="off"></textarea>
                        </div>
                        <div class="col-sm-12">
                            <div class="card" style="border-left-style: solid;border-left-color: orange;border-left-width: 5px;">
                                <div class="card-body">
                                    <h6 class="mb-0"><b>FAQ FOR PRESENTER/AUTHOR</b></h6>
                                    <table class="w-100 mb-0">
                                        <tbody>
                                        <tr class="bg-success">
                                            <td class="font-weight-bold text-light">Q</td>
                                            <td class="text-light">:</td>
                                            <td class="text-light">I woud like to submit more than one abstract/manuscript titles, do I have to make more than one accounts?</td>
                                        </tr>
                                        <tr class="bg-dark">
                                            <td class="font-weight-bold text-light">A</td>
                                            <td class="text-light">:</td>
                                            <td class="text-light">No, you just make one account. After you logging in, you can submit more than one titles.</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <hr/>
                            <div class="text-center mb-3">
                                <button type="submit" class="btn btn-light btn-lg border border-orange text-orange" style="border-radius: 30px;">REGISTER</button>
                            </div>
                            <p style="font-size: 14px;color: rgba(0,0,0,.5)">*) When you click REGISTER, you are declared to have officially registered and please wait for the E-mail for the password and confirmation to be sent.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-registration').addClass("active");
            $(".select2").select2({"language": "en", placeholder: "Please select and search...",});
            $('#negara').val("100");
            $('#negara').trigger('change');
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                autoclose: true,
                autoPick: true
            }).css({"cursor":"pointer", "background":"white"});
        });
        $(function() {
            $('#formExecute').validate({
                rules: {
                    nama_depan: { required: true, lettersonlys: true, }, nama_tengah: { lettersonlys: true, },
                    nama_belakang: { required: true, lettersonlys: true, },
                    sebagai: { required: true, }, jenis_kelamin: { required: true, }, pddk_terakhir: { required: true, },
                    negara: { required: true, }, institusi: { required: true, lettersonlys: true, }, tgl_lahir: { required: true, },
                    email: { required: true, emailfull: true, },alamat: { required: true, },kota: { required: true, },
                    kode_pos: { required: true, },no_hp: { required: true, digits: true, minlength: 8, maxlength: 14, },
                },
                messages: {
                    nama_depan: { required: "Please fill in", lettersonlys: "Only alphabet and space only", },
                    nama_tengah: { lettersonlys: "Only alphabet and space only", },
                    nama_belakang: { required: "Please fill in", lettersonlys: "Only alphabet and space only", },
                    sebagai: { required: "Please fill in", }, jenis_kelamin: { required: "Please fill in", }, pddk_terakhir: { required: "Please fill in", },
                    negara: { required: "Please fill in", }, institusi: { required: "Please fill in", },
                    tgl_lahir: { required: "Please fill in", }, email: { required: "Please fill in", emailfull: "E-mail invalid" },
                    alamat: { required: "Please fill in", }, kota: { required: "Please fill in", },
                    kode_pos: { required: "Please fill in", },
                    no_hp: { required: "Please fill in", digits: "Only numbers", minlength: "Minimum 8 digits", maxlength: "Max 14 digits", },
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
                            return new Promise(function (resolve) {
                                var values = $('#formExecute').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/jsonRegistrasi') }}",
                                    dataType: 'json', headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    success: function(response) {
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({ icon: 'success', title: '', text: response.message}).then((result) => {
                                                if (result.value) {location.reload();}
                                            });
                                        } else {
                                            swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: response.message});
                                        }
                                    },
                                    error:function(data){
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
