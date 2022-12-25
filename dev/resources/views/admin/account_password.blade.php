@extends('admin.template')

@section('konten')
    <style type="text/css">
        #password_lama-error, #password_baru-error, #password_ulangi-error {
            position: absolute;
            right: 0;top: 40px;
            border: solid 1px rgba(0, 0, 0, .5);background: #fff;box-shadow: 0px 2px 6px rgba(0, 0, 0, .5);
            padding: 2px 5px;z-index: 5;
        }
    </style>
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/account')}}">Account</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Password</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <form id="formExecute" class="formExecute">
                        <div class="card-body">
                            <center><h5 class="card-title text-dark py-3">ACCOUNT</h5></center>
                            <hr>
                            <div class="row text-dark">
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="old_password" class="form-label mb-0"><b><code>*)</code>OLD PASSWORD</b></label><br/>
                                        <div class="input-group" id="show_hide_password_old_password">
                                            <input type="password" id="password_lama" name="password_lama" class="form-control" placeholder="Please fill in" aria-label="Password" aria-describedby="button-addon">
                                            <div class="input-group-append">
                                                <button class="btn btn-default btn-outline-secondary" type="button"><i class="fas fa-eye-slash" id="i_old"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="new_password" class="form-label mb-0"><b><code>*)</code>NEW PASSWORD</b></label><br/>
                                        <div class="input-group" id="show_hide_password_new_password">
                                            <input type="password" id="password_baru" name="password_baru" class="form-control" placeholder="Please fill in" aria-label="Password" aria-describedby="button-addon">
                                            <div class="input-group-append">
                                                <button class="btn btn-default btn-outline-secondary" type="button"><i class="fas fa-eye-slash" id="i_new"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label for="rewrite_new_password" class="form-label mb-0"><b><code>*)</code>RETYPE NEW PASSWORD</b></label><br/>
                                        <div class="input-group" id="show_hide_password_rewrite_new_password">
                                            <input type="password" id="password_ulangi" name="password_ulangi" class="form-control" placeholder="Please fill in" aria-label="Password" aria-describedby="button-addon">
                                            <div class="input-group-append">
                                                <button class="btn btn-default btn-outline-secondary" type="button"><i class="fas fa-eye-slash" id="i_retype"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2 text-right">
                                    <button type="submit" class="btn btn-sm btn-primary float-right">Save</button>
                                    <a href="{{url('/admin/account')}}" type="button" class="btn btn-sm btn-danger float-right mr-1">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript">
        $("#show_hide_password_old_password button").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password_old_password input').attr("type") == "text"){
                $('#show_hide_password_old_password input').attr('type', 'password');
                $('#i_old').addClass( "fa-eye-slash" ).removeClass( "fa-eye" );
            }else if($('#show_hide_password_old_password input').attr("type") == "password"){
                $('#show_hide_password_old_password input').attr('type', 'text');
                $('#i_old').removeClass( "fa-eye-slash" ).addClass( "fa-eye" );
            }
        });
        $("#show_hide_password_new_password button").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password_new_password input').attr("type") == "text"){
                $('#show_hide_password_new_password input').attr('type', 'password');
                $('#i_new').addClass( "fa-eye-slash" ).removeClass( "fa-eye" );
            }else if($('#show_hide_password_new_password input').attr("type") == "password"){
                $('#show_hide_password_new_password input').attr('type', 'text');
                $('#i_new').removeClass( "fa-eye-slash" ).addClass( "fa-eye" );
            }
        });
        $("#show_hide_password_rewrite_new_password button").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password_rewrite_new_password input').attr("type") == "text"){
                $('#show_hide_password_rewrite_new_password input').attr('type', 'password');
                $('#i_retype').addClass( "fa-eye-slash" ).removeClass( "fa-eye" );
            }else if($('#show_hide_password_rewrite_new_password input').attr("type") == "password"){
                $('#show_hide_password_rewrite_new_password input').attr('type', 'text');
                $('#i_retype').removeClass( "fa-eye-slash" ).addClass( "fa-eye" );
            }
        });
        $(function() {
            $('#formExecute').validate({
                rules: {
                    password_lama: { required: true, },password_baru: { required: true, },
                    password_ulangi: { required: true, equalTo:"#password_baru"},
                },
                messages: {
                    password_lama: { required: "Please fill in", },password_baru: { required: "Please fill in", },
                    password_ulangi: { required: "Please fill in", equalTo:"Passwords are not the same"},
                },
                errorElement : 'div', errorPlacement: function(error, element) {
                    var placement = $(element).data('error');
                    if (placement) {$(placement).append(error)} else {error.insertAfter(element);}
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
                                    type: "POST",data:values, url: "{{ url('/api/updateAccountPassword') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    window.location.replace("{{url('/admin/account')}}");
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
            });
        });
    </script>
@endsection
