<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Tegal International Converence Politeknik Harapan Bersama">
    <meta name="author" content="Tegal International Converence">
    <meta name="keyword" content="Tegal International Converence Politeknik Harapan Bersama">
    <meta name="generator" content="Tegal International Converence Politeknik Harapan Bersama">
    <meta property="og:title" content="Tegal International Converence Politeknik Harapan Bersama">
    <meta property="og:site_name" content="Tegal International Converence Politeknik Harapan Bersama">
    <meta property="og:description" content="Tegal International Converence Politeknik Harapan Bersama">
    <meta property="og:type" content="website">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <title>TEGAL INTERNATIONAL CONFERENCE</title>

    <link rel="apple-touch-icon" sizes="57x57" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/apple-icon-57x57.png'))}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/apple-icon-60x60.png'))}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/apple-icon-72x72.png'))}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/apple-icon-76x76.png'))}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/apple-icon-114x114.png'))}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/apple-icon-120x120.png'))}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/apple-icon-144x144.png'))}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/apple-icon-152x152.png'))}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/apple-icon-180x180.png'))}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/android-icon-192x192.png'))}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/favicon-32x32.png'))}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/favicon-96x96.png'))}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{\App\Helpers\Helpers::base64_encode_image(asset('img/ico/favicon-16x16.png'))}}">

    <link href="{{asset('bootstrap-4.3.1/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('fontawesome-5.15.1/css/all.css')}}" rel="stylesheet">
    <link href="{{asset('fontawesome-5.15.1/css/fontawesome.css')}}" rel="stylesheet">
    <link href="{{asset('fontawesome-5.15.1/css/brands.css')}}" rel="stylesheet">
    <link href="{{asset('fontawesome-5.15.1/css/solid.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link href="{{asset('/plugins/dropzone-5.7.0/dist/dropzone.css')}}" rel="stylesheet">
    <link href="{{ asset('/custom/custom_user.css?').date('d')}}" rel="stylesheet">
    <link href="{{ asset('/plugins/DataTables/DataTables-1.10.20/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('/plugins/DataTables/AutoFill-2.3.4/css/autoFill.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{ asset('/plugins/DataTables/Buttons-1.6.1/css/buttons.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('/plugins/DataTables/Responsive-2.2.3/css/responsive.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('/plugins/DataTables/Scroller-2.0.1/css/scroller.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('/plugins/DataTables/SearchPanes-1.0.1/css/searchPanes.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('/plugins/sweetalert2-9.5.4/package/dist/sweetalert2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/plugins/Croppie-2.6.4/croppie.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('/plugins/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-md navbar-light bg-white fixed-top pl-sm-4 pr-sm-5" style="box-shadow: 0 5px 5px -5px #999,0 -1px 0 0 #fff;">
        <div class="navbar-brand pl-md-5">
            <img src="{{ asset('img/logo.png') }}" style="height: 30px;margin-top: -5px"/>
            <a class="text-dark text-decoration-none" href="{{ url('/reviewer') }}">
                <b>PARTICIPAN</b>
            </a>
            <a href="javascript:void(0);" id="sidebarCollapse" class="text-dark pl-3 pl-md-5 ml-md-3"><i class="fas fa-bars"></i></a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pr-5" id="navbarCollapse">
            <form class="form-inline form-inline-custom ml-5 display-none" id="form-search">
                <input class="mr-sm-2" type="text" id="form-input-search" placeholder="Search...">
                <button class="btn" type="button" id="form-btn-search"><i class="fas fa-search form-inline-custom-i"></i></button>
            </form>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle text-dark" href="javascript:void(0)" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-cog"></i>
                        </a>
                        <div class="dropdown-menu shadow shadow-sm" aria-labelledby="dropdownMenuButton" style="right: .5rem;left: unset;">
                            <a class="dropdown-item" href="{{url('/participan/account')}}">Account</a>
                            <a class="dropdown-item" href="{{ url('/participan/logout') }}">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="progress position-fixed" id="progress-nav" style="top: 48px;z-index: 2;">
        <div class="determinate bg-dark" id="progressBar-determinate" style="visibility: hidden;"></div>
        <div class="indeterminate bg-dark" id="progressBar-indeterminate" style="visibility: hidden;"></div>
    </div>
</header>

<div class="wrapper">
    <nav id="sidebar">
        <ul class="list-unstyled components pr-1 pt-5">
            <li id="i_dashboard"><a href="{{url('/participan')}}" class="pl-sidebar"><i class="fas fa-home fa-lg mr-3"></i> Dashboard</a></li>
            <li id="i_notification"><a href="{{url('/participan/notification')}}" class="pl-sidebar"><i class="far fa-bell fa-lg mr-3"></i>Notification <span class="badge badge-warning text-light right" id="ttl_notif" style="display: none">0</span></a></li>
            <li id="i_payment"><a href="{{url('/participan/payment')}}" class="pl-sidebar"><i class="fas fa-money-bill-wave fa-lg mr-3"></i> Payment</a></li>
            <li id="i_journal"><a href="{{url('/participan/journal')}}" class="pl-sidebar"><i class="far fa-copy fa-lg mr-3"></i> Journals</a></li>
            <li id="i_videos"><a href="{{url('/participan/videos')}}" class="pl-sidebar"><i class="far fa-file-video fa-lg mr-3"></i> Videos</a></li>
        </ul>
    </nav>

    <div id="content">
        <div id="Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
        <div class="content-view">
            @yield('konten')
        </div>
        <footer class="footer mt-auto py-3 shadow-sm-footer p-3 bg-white">
            <div class="container">
                <span class="text-dark">Tegal International Converence</span>
            </div>
        </footer>
    </div>
</div>
<script type="text/javascript" src="{{ asset('/plugins/jQuery/jQuery-3.5.1.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/bootstrap-4.3.1/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/bootstrap-4.3.1/js/bootstrap.bundle.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/fontawesome-5.15.1/js/all.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/dropzone-5.7.0/dist/dropzone.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/jquery-validation-1.19.2/dist/jquery.validate.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/jquery-validation-1.19.2/dist/additional-methods.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/sweetalert2-9.5.4/package/dist/sweetalert2.all.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/ckeditor-4.15.1/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/moment/locale/id.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/Croppie-2.6.4/croppie.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/select2/js/select2.full.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/select2/js/i18n/id.js')}}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/JSZip-2.5.0/jszip.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/pdfmake-0.1.36/pdfmake.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/pdfmake-0.1.36/vfs_fonts.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/DataTables-1.10.20/js/jquery.dataTables.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/DataTables-1.10.20/js/dataTables.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/AutoFill-2.3.4/js/dataTables.autoFill.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/AutoFill-2.3.4/js/autoFill.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/Buttons-1.6.1/js/dataTables.buttons.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/Buttons-1.6.1/js/buttons.bootstrap4.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/Buttons-1.6.1/js/buttons.flash.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/Buttons-1.6.1/js/buttons.html5.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/Buttons-1.6.1/js/buttons.print.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/Responsive-2.2.3/js/dataTables.responsive.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/Scroller-2.0.1/js/dataTables.scroller.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/DataTables/SearchPanes-1.0.1/js/dataTables.searchPanes.js')}}"></script>
<script type="text/javascript" src="{{asset('/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('/plugins/jquery.lazy-master/jquery.lazy.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/plugins/jquery.lazy-master/jquery.lazy.plugins.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('/custom/custom_user.js?').date('d')}}"></script>
<script type="text/javascript" src="{{ asset('/custom/custom_participan.js?').date('d')}}"></script>
<script type="text/javascript" src="{{ asset('/custom/validation.js?').date('d')}}"></script>
<script type="text/javascript">
    function modal(page,str1,str2) {
        loader_show();
        $.ajax({
            type: "POST",headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {page:page,str1:str1,str2:str2}, url: "{{ url('/participan/modal') }}",
            success: function(data) {
                loader_hide();
                $("#Modal").html(data);
                $("#Modal").modal('show',{backdrop: 'true'});
            }, error:function(data) {
                loader_hide();
                swall_error();
            }
        })
    }
    function getNotif() {
        $.ajax({
            url:'{{url('api/getNotifParticipan')}}',type: "GET",dataType: 'json',
            success: function (response) {
                if (response.status === "OK"){
                    if (response.total > 0){
                        $('#ttl_notif').show();
                        $('#ttl_notif').html(response.total);
                    } else {
                        $('#ttl_notif').hide();
                    }
                }
            },
            error:function(response){}
        });
    }
    function ajaxDelete(str, id) {
        swalWithBootstrapButtons.fire({
            text: 'Are you sure you want to delete ?',
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
                    var values = new FormData();
                    values.append("str",str);
                    values.append("id",id);
                    $.ajax({
                        type: "POST",data:values, url: "{{ url('/api/deleteData') }}",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        dataType: 'json', processData: false, contentType: false,
                        success: function(response) {
                            loader_hide();
                            if (response.status === "OK"){
                                swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                    if (result.value) {
                                        reloadTable();
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
</script>
@yield('js')
</body>
</html>
