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
            <img src="{{ \App\Helpers\Helpers::base64_encode_image(asset('img/logo.png')) }}" style="height: 30px;margin-top: -5px"/>
            <a class="text-dark text-decoration-none" href="{{ url('/admin') }}">
                <b>ADMIN</b>
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
                            <a class="dropdown-item" href="{{url('/admin/account')}}">Account</a>
                            <a class="dropdown-item" href="{{ url('/admin/logout') }}">Logout</a>
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
            <li id="i_dashboard"><a href="{{url('/admin')}}" class="pl-sidebar"><i class="fas fa-home fa-lg mr-3"></i> Dashboard</a></li>
            <li id="i_notification"><a href="{{url('/admin/notification')}}" class="pl-sidebar"><i class="far fa-bell fa-lg mr-3"></i> Notification <span class="badge badge-warning text-light right" id="ttl_notif" style="display: none">0</span></a></li>
            <li id="i_payment">
                <a href="#subPayment" data-toggle="collapse" aria-expanded="false" class="pl-sidebar drop-sidebar dropdown-toggle"><i class="fas fa-money-bill-wave fa-lg mr-3"></i> Payment <span class="badge badge-warning text-light right" id="ttl_payment" style="display: none">0</span></a>
                <ul class="collapse list-unstyled" id="subPayment">
                    <li><a href="{{url('/admin/payment_journal')}}" id="i_payment_journal">Journal <span class="badge badge-warning text-light right" id="ttl_payment_journal" style="display: none">0</span></a></li>
                    <li><a href="{{url('/admin/payment_participan')}}" id="i_payment_participan">Participan <span class="badge badge-warning text-light right" id="ttl_payment_participan" style="display: none">0</span></a></li>
                </ul>
            </li>
            <li id="i_journal">
                <a href="#subJournal" data-toggle="collapse" aria-expanded="false" class="pl-sidebar drop-sidebar dropdown-toggle"><i class="far fa-copy fa-lg mr-3"></i> Journal <span class="badge badge-warning text-light right" id="ttl_journal" style="display: none">0</span></a>
                <ul class="collapse list-unstyled" id="subJournal">
                    <li><a href="{{url('/admin/journal')}}" id="i_journal_journal">Journal</a></li>
                    <li><a href="{{url('/admin/journal/process')}}" id="i_journal_process">Process <span class="badge badge-warning text-light right" id="ttl_journal_process" style="display: none">0</span></a></li>
                    <li><a href="{{url('/admin/journal/confirmation')}}" id="i_journal_confirm">Confirmation <span class="badge badge-warning text-light right" id="ttl_journal_confirm" style="display: none">0</span></a></li>
                    <li><a href="{{url('/admin/journal/draft')}}" id="i_journal_draft">Draft</a></li>
                </ul>
            </li>
            <li id="i_revision"><a href="{{url('/admin/revision')}}" class="pl-sidebar"><i class="far fa-comment-alt fa-lg mr-3"></i> Revision</a></li>
            <li id="i_videos"><a href="{{url('/admin/videos')}}" class="pl-sidebar"><i class="far fa-file-video fa-lg mr-3"></i> Videos</a></li>
            <li id="i_users">
                <a href="#subUsers" data-toggle="collapse" aria-expanded="false" class="pl-sidebar drop-sidebar dropdown-toggle"><i class="fas fa-users fa-lg mr-3"></i> Users</a>
                <ul class="collapse list-unstyled" id="subUsers">
                    <li><a href="{{url('/admin/authors')}}" id="i_users_authors">Author</a></li>
                    <li><a href="{{url('/admin/reviewers')}}" id="i_users_reviewer">Reviewer</a></li>
                    <li><a href="{{url('/admin/participan')}}" id="i_users_participan">Participan</a></li>
                </ul>
            </li>
            <li id="i_document">
                <a href="#subDocument" data-toggle="collapse" aria-expanded="false" class="pl-sidebar drop-sidebar dropdown-toggle"><i class="fas fa-book fa-lg mr-3"></i> Document</a>
                <ul class="collapse list-unstyled" id="subDocument">
                    <li><a href="{{url('/admin/country')}}" id="i_document_country">Country</a></li>
                    <li><a href="{{url('/admin/degree')}}" id="i_document_degree">Degree</a></li>
                    <li><a href="{{url('/admin/sosmed')}}" id="i_document_sosmed">Sosmed</a></li>
                    <li><a href="{{url('/admin/contact')}}" id="i_document_contact">Contact</a></li>
                </ul>
            </li>
            <li id="i_events"><a href="{{url('/admin/events')}}" class="pl-sidebar"><i class="far fa-calendar-alt fa-lg mr-3"></i> Events</a></li>
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
<script type="text/javascript" src="{{ asset('/custom/custom_user.js?').date('d')}}"></script>
<script type="text/javascript" src="{{ asset('/custom/custom_admin.js?').date('d')}}"></script>
<script type="text/javascript" src="{{asset('custom/validation.js?').date('d')}}"></script>
<script type="text/javascript">
    function modal(page,str1,str2) {
        loader_show();
        $.ajax({
            type: "POST",headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {page:page,str1:str1,str2:str2}, url: "{{ url('/admin/modal') }}",
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
            url:'{{url('api/getNotifAdmin')}}',type: "GET",dataType: 'json',
            success: function (response) {
                if (response.status === "OK"){
                    if (response.ttl_notif > 0){
                        $('#ttl_notif').show();
                        $('#ttl_notif').html(response.ttl_notif);
                    } else {
                        $('#ttl_notif').hide();
                    }
                    if (response.ttl_payment_journal > 0 || response.ttl_payment_participan > 0){
                        $('#ttl_payment').show();
                        $('#ttl_payment').html(parseInt(response.ttl_payment_journal)+parseInt(response.ttl_payment_participan));
                        if (response.ttl_payment_journal > 0){
                            $('#ttl_payment_journal').show();
                            $('#ttl_payment_journal').html(response.ttl_payment_journal);
                        } else {
                            $('#ttl_payment_journal').hide();
                        }
                        if (response.ttl_payment_participan > 0){
                            $('#ttl_payment_participan').show();
                            $('#ttl_payment_participan').html(response.ttl_payment_participan);
                        } else {
                            $('#ttl_payment_participan').hide();
                        }
                    } else {
                        $('#ttl_payment').hide();
                    }
                    if (response.ttl_journal_process > 0 || response.ttl_journal_confirm > 0){
                        $('#ttl_journal').show();
                        $('#ttl_journal').html(parseInt(response.ttl_journal_process)+parseInt(response.ttl_journal_confirm));
                        if (response.ttl_journal_process > 0){
                            $('#ttl_journal_process').show();
                            $('#ttl_journal_process').html(response.ttl_journal_process);
                        } else {
                            $('#ttl_journal_process').hide();
                        }
                        if (response.ttl_journal_confirm > 0){
                            $('#ttl_journal_confirm').show();
                            $('#ttl_journal_confirm').html(response.ttl_journal_confirm);
                        } else {
                            $('#ttl_journal_confirm').hide();
                        }
                    } else {
                        $('#ttl_journal').hide();
                    }
                } else {
                    swall_failed_text(response.message);
                }
            },
            error:function(response){
                swall_failed_text("Terjadi kesalahan. Silahkan muat ulang halaman.");
            }
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
                                        setActionDelete(str);
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
    function setActionDelete(str) {
        if (str==="authors"||str==="contact"||str==="country"||str==="degree"||str==="events"||str==="notification_admin"
            ||str==="reviewers"||str==="sosmed"){
            reloadTable();
        } else if (str==="co_host"){
            reloadTableCoHost();
        } else if (str==="indexing"){
            reloadTableIndexing();
        } else if (str==="type_payment"){
            reloadTablePayment();
        } else if (str==="kerjasama"){
            reloadTableCollaboration();
        } else if (str==="keynote_speaker"){
            reloadTableKeynoteSpeaker();
        } else if (str==="invited_speaker"){
            reloadTableInvitedSpeaker();
        } else if (str==="sub"){
            reloadTableSub();
        } else if (str==="scope"){
            reloadTableScope();
        } else if (str==="vc"){
            reloadTableVC();
        } else if (str==="timeline"){
            reloadTableTimeline();
        }
    }
    function checkNull(str) {
        if (str===null){
            return "-";
        }
        return str;
    }
</script>
@yield('js')
</body>
</html>
