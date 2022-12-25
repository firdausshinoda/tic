@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
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
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>USERNAME</b></small><br/>
                                <div id="tx_firstname" class="h-min-formaccount">{{Session::get('username')}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>NAME</b></small><br/>
                                <div id="tx_midleame" class="h-min-formaccount">{{Session::get('nama_admin')}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-12 col-sm-4">
                                <p>
                                    <small><b>E-MAIL</b></small><br/>
                                <div id="tx_lastname" class="h-min-formaccount">{{Session::get('email')}}</div>
                                <hr class="mt-1">
                                </p>
                            </div>
                            <div class="col-sm-12 mt-2 text-right">
                                <a href="{{url('/admin/account/password')}}" class="btn btn-sm btn-primary" onclick="modal('account-password')"><i class="fas fa-pencil-alt"></i> CHANGE PASSWORD</a>
                                <a href="{{url('/admin/account/edit')}}" class="btn btn-sm btn-primary"><i class="fas fa-pencil-alt"></i> CHANGE PROFILE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
