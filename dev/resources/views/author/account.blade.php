@extends('author.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/author')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Account</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <center><h5 class="card-title text-dark py-3">ACCOUNT</h5></center>
                        <hr>
                        <div class="row text-dark">
                            <div class="col-sm-12 text-center pb-5">
                                <div style="width: 150px; margin-right: auto;margin-left: auto">
                                    <img id="foto" class="rounded-circle border rounded w-100">
                                    <button class="btn btn-default shadow rounded-circle position-absolute" id="btn_foto" style="bottom: 40px;margin-left:-50px"><i class="fas fa-camera"></i></button>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>FIRST NAME</b></small><br/>
                                <div id="tx_firstname" class="h-min-formaccount">{{Session::get('nama_depan')}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>MIDDLE NAME</b></small><br/>
                                <div id="tx_middleame" class="h-min-formaccount">{{Session::get('nama_tengah')}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>LAST NAME</b></small><br/>
                                <div id="tx_lastname" class="h-min-formaccount">{{Session::get('nama_belakang')}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-3">
                                <p>
                                    <small><b>GENDER</b></small><br/>
                                <div id="tx_sex" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-3">
                                <p>
                                    <small><b>BIRTHDAY</b></small><br/>
                                <div id="tx_birthday" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-3">
                                <p>
                                    <small><b>LAST EDUCATION</b></small><br/>
                                <div id="tx_lasteducation" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-3">
                                <p>
                                    <small><b>BACHELOR'S DEGREE</b></small><br/>
                                <div id="tx_bachelor_degree" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>E-MAIL</b></small><br/>
                                <div id="tx_email" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>PHONE NUMBER</b></small><br/>
                                <div id="tx_phonenumber" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>FAX NUMBER</b></small><br/>
                                <div id="tx_faxnumber" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-12">
                                <p>
                                    <small><b>ADDRESS</b></small><br/>
                                <div id="tx_address" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>CITY</b></small><br/>
                                <div id="tx_city" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>POSTAL CODE</b></small><br/>
                                <div id="tx_postal_code" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>COUNTRY</b></small><br/>
                                <div id="tx_country" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-12">
                                <p>
                                    <small><b>INSTITUTION (FULL NAME)</b></small><br/>
                                <div id="tx_institution" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>
                                    <small><b>RESEARCH</b></small><br/>
                                <div id="tx_research" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>
                                    <small><b>ORCID ID</b></small><br/>
                                <div id="tx_orcidid" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-12">
                                <p>
                                    <small><b>OTHER INFORMATION</b></small><br/>
                                <div id="tx_other_information" class="h-min-formaccount"></div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-sm-12 mt-2 text-right">
                                <button type="button" class="btn btn-sm btn-primary" onclick="modal('account-password')"><i class="fas fa-pencil-alt"></i> CHANGE PASSWORD</button>
                                <a href="{{url('/author/account/edit')}}" type="button" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> CHANGE PROFILE</a>
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
                        $('#tx_sex').html(dt.jenis_kelamin);
                        $('#tx_birthday').html(dt.tgl_lahir);
                        $('#tx_lasteducation').html(dt.pddk_terakhir);
                        $('#tx_bachelor_degree').html(dt.gelar);
                        $('#tx_email').html(dt.email);
                        $('#tx_phonenumber').html(dt.no_hp);
                        $('#tx_faxnumber').html(dt.no_fax);
                        $('#tx_address').html(dt.alamat);
                        $('#tx_city').html(dt.kota);
                        $('#tx_postal_code').html(dt.kode_pos);
                        $('#tx_country').html(dt.negara);
                        $('#tx_institution').html(dt.institusi);
                        $('#tx_research').html(dt.research);
                        $('#tx_orcidid').html(dt.orcid_id);
                        $('#tx_other_information').html(dt.informasi_lain);
                        $('#btn_foto').attr('onclick','modal(\'account-photo\')');
                        if (dt.foto_author===null||dt.foto_author===""){
                            $('#foto').attr('src','{{asset('img/user_default.jpg')}}');
                        } else {
                            $('#foto').attr('src','{{asset('upload/author')}}/'+dt.foto_author);
                        }
                    } else {
                        swall_failed_text(response.message);
                    }
                }, error:function(response) {
                    loader_hide();
                    swall_error();
                }
            })
        }
    </script>
@endsection
