@extends('reviewer.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/reviewer')}}">Dashboard</a></li>
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
                                    <img id="foto" class="rounded-circle border rounded w-100" src="{{empty(Session::get('foto_reviewer'))?asset('img/user_default.jpg'):asset('upload/reviewer/'.Session::get('foto_reviewer'))}}">
                                    <button class="btn btn-default shadow rounded-circle position-absolute" onclick="modal('account-photo')" style="bottom: 40px;margin-left:-50px"><i class="fas fa-camera"></i></button>
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
                            <div class="col-12 col-sm-6">
                                <p>
                                    <small><b>GENDER</b></small><br/>
                                <div id="tx_sex" class="h-min-formaccount">{{Session::get('jenis_kelamin')}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-6">
                                <p>
                                    <small><b>E-MAIL</b></small><br/>
                                <div id="tx_email" class="h-min-formaccount">{{Session::get('email')}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-sm-12 mt-2 text-right">
                                <button type="button" class="btn btn-sm btn-primary" onclick="modal('account-password')"><i class="fas fa-pencil-alt"></i> CHANGE PASSWORD</button>
                                <a href="{{url('/reviewer/account/edit')}}" type="button" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> CHANGE PROFILE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
