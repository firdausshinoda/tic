@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-2" style="margin-top: 20px">
                <div class="card shadow card-dashboard-text text-default">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-7 col-lg-8">
                                <h5 style="line-height: 1.5;">
                                    <b>
                                        Welcome Back<br>
                                        ADMIN TIC!
                                    </b>
                                </h5>
                                <p class="pt-2 pt-md-3">Use your access rights to manage each data.</p>
                            </div>
                            <div class="col-sm-12 col-md-5 col-lg-4">
                                <img src="{{ asset('img/bg-icon-dasbor.png') }}" style="width: 90%;margin-top: -9.5vh;">
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
        setAktifItem('dashboard');
    </script>
@endsection
