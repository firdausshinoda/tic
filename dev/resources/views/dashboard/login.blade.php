@extends('dashboard.template')

@section('konten')
    <style type="text/css">
        #password-error {
            position: absolute;
            left: 0%;
            top: 40px;
            border: solid 1px rgba(0, 0, 0, .5);
            background: #fff;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, .5);
            padding: 2px 5px;
            z-index: 5;
        }
    </style>
    <section class="inner-header parallax-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2><b>LOGIN AND SUBMISSION</b></h2>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="row w-100 ml-0 mr-0" style="margin-top: 10vh;">
            <div class="col-12 col-sm-8" style="padding: 5%">
                <?= $dt_isi; ?>
            </div>
            <div class="col-12 col-sm-4 bg-partikel-2  px-0">
                <div style="padding: 10%;">
                    <h4 class="text-center"><b>LOGIN</b></h4>
                    <form class="mt-5" id="formExecute" class="formExecute">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="E-mail...">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <div class="input-group" id="show_hide_password">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="button-addon">
                                <div class="input-group-append">
                                    <button class="btn btn-default btn-outline-secondary" type="button"><i class="fas fa-eye-slash" id="i_password"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>As</label>
                            <select class="form-control" id="sebagai" name="sebagai">
                                <option value="AUTHOR">PRESENTER/AUTHOR</option>
                                <option value="PARTICIPAN">PARTICIPANT</option>
                                <option value="REVIEWER">REVIEWER</option>
                            </select>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 col-sm-6 px-0">
                                <button type="submit" class="btn border border-orange text-orange m-1" style="border-radius: 35px;">LOGIN</button>
                            </div>
                            <div class="col-12 col-sm-6 text-right px-0">
                                <a href="{{url('/forgot')}}" class="text-decoration-none text-dark" style="font-size: 14px;">Forgot The password?</a>
                            </div>
                        </div>
                        <p class="font-weight-bold m-1">Don't have an account? <a href="{{url('/registration')}}" class="text-decoration-none text-danger">Registration</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#li-login').addClass("active");
            $("#show_hide_password button").on('click', function(event) {
                event.preventDefault();
                if($('#show_hide_password input').attr("type") == "text"){
                    $('#show_hide_password input').attr('type', 'password');
                    $('#i_password').addClass( "fa-eye-slash" ).removeClass( "fa-eye" );
                }else if($('#show_hide_password input').attr("type") == "password"){
                    $('#show_hide_password input').attr('type', 'text');
                    $('#i_password').removeClass( "fa-eye-slash" ).addClass( "fa-eye" );
                }
            });
        });
        $(function() {
            $('#formExecute').validate({
                rules: {
                    email: { required: true, emailfull: true, },password: { required: true, },
                },
                messages: {
                    email: { required: "Please fill in", emailfull: "E-mail invalid" },password: { required: "Please fill in", },
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
                                    type: "POST",data:values, url: "{{ url('/api/jsonLogin') }}",
                                    dataType: 'json', headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    success: function(response) {
                                        if (response.status === "OK"){
                                            window.location.replace(response.data.url);
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
