@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/participan')}}">Participan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="row text-dark">
                            <div class="col-sm-12 text-center pb-5">
                                <div style="width: 100px; margin-right: auto;margin-left: auto">
                                    <img id="foto" class="rounded-circle border rounded w-100" src="{{empty($data->foto_participan) ? asset('img/user_default.jpg') : asset('upload/participan/'.$data->foto_participan)}}">
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>FIRST NAME</b></small><br/>
                                <div id="tx_firstname" class="h-min-formaccount">{{$data->nama_depan}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>MIDLE NAME</b></small><br/>
                                <div id="tx_midleame" class="h-min-formaccount">{{$data->nama_tengah}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>LAST NAME</b></small><br/>
                                <div id="tx_lastname" class="h-min-formaccount">{{$data->nama_belakang}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-3">
                                <p>
                                    <small><b>GENDER</b></small><br/>
                                <div id="tx_sex" class="h-min-formaccount">{{$data->jenis_kelamin}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-3">
                                <p>
                                    <small><b>BIRTHDAY</b></small><br/>
                                <div id="tx_birthday" class="h-min-formaccount">{{$data->tgl_lahir}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-3">
                                <p>
                                    <small><b>LAST EDUCATION</b></small><br/>
                                <div id="tx_lasteducation" class="h-min-formaccount">{{$data->pddk_terakhir}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-3">
                                <p>
                                    <small><b>BACHELOR'S DEGREE</b></small><br/>
                                <div id="tx_bachelor_degree" class="h-min-formaccount">{{$data->gelar}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>E-MAIL</b></small><br/>
                                <div id="tx_email" class="h-min-formaccount">{{$data->email}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>PHONE NUMBER</b></small><br/>
                                <div id="tx_phonenumber" class="h-min-formaccount">{{$data->no_hp}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>FAX NUMBER</b></small><br/>
                                <div id="tx_faxnumber" class="h-min-formaccount">{{$data->no_fax}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-12">
                                <p>
                                    <small><b>ADDRESS</b></small><br/>
                                <div id="tx_address" class="h-min-formaccount">{{$data->alamat}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>CITY</b></small><br/>
                                <div id="tx_city" class="h-min-formaccount">{{$data->kota}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>POSTAL CODE</b></small><br/>
                                <div id="tx_postal_code" class="h-min-formaccount">{{$data->kode_pos}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>COUNTRY</b></small><br/>
                                <div id="tx_country" class="h-min-formaccount">{{$data->negara}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-12">
                                <p>
                                    <small><b>INSTITUTION (FULL NAME)</b></small><br/>
                                <div id="tx_institution" class="h-min-formaccount">{{$data->institusi}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>
                                    <small><b>RESEARCH</b></small><br/>
                                <div id="tx_research" class="h-min-formaccount">{{$data->research}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>
                                    <small><b>ORCID ID</b></small><br/>
                                <div id="tx_orcidid" class="h-min-formaccount">{{$data->orcid_id}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-12">
                                <p>
                                    <small><b>OTHER INFORMATION</b></small><br/>
                                <div id="tx_other_information" class="h-min-formaccount">{{$data->informasi_lain}}</div>
                                <hr class="mt-1">
                                </p>
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
        $(document).ready(function() {
            setAktifItem('participan');
        });
    </script>
@endsection
