@extends('sub.template')

@section('konten')
    <section class="w-100" style="height: 100vh;">
        <div class="row w-100 ml-0 mr-0">
            <div class="d-none d-sm-block col-sm-6 pr-0 pl-0">
                <div class="bg-login"></div>
            </div>
            <div class="col-sm-6 bg-partikel-2">
                <div style="margin-top: 10vh;padding: 15%;">
                    <h4 class="text-center"><b>FORGOT PASSWORD</b></h4>
                    <form class="mt-5" id="formExecute" class="formExecute">
                        <div class="form-group">
                            <label>E-mail</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="E-mail..." autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>As</label>
                            <select class="form-control" id="sebagai" name="sebagai">
                                <option value="AUTHOR">PRESENTER/AUTHOR</option>
                                <option value="PARTICIPAN">PARTICIPAN</option>
                                <option value="REVIEWER">REVIEWER</option>
                            </select>
                        </div>
                        <div class="row mt-5">
                            <div class="col-12 col-sm-6">
                                <button type="submit" class="btn text-success border border-success m-1" style="border-radius: 35px;">Submit</button>
                            </div>
                            <div class="col-12 col-sm-6 text-right">
                                <a href="{{url('/login')}}" class="text-decoration-none text-dark">LOGIN</a>
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
            $('footer').hide();
        });
        $(function() {
            $('#formExecute').validate({
                rules: {email: { required: true, email: true, },},
                messages: {email: { required: "Please fill in", emailfull: "E-mail invalid" },},
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
                                    type: "POST",data:values, url: "{{ url('/api/ckAccountAuthor') }}",
                                    dataType: 'json', headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    success: function(response) {
                                        if (response.status === "OK"){
                                            verificationForm();
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
        })
        function verificationForm() {
            swalWithBootstrapButtons.fire({
                text: 'We will send the password by email.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: function () {
                    return new Promise(function (resolve) {
                        var values = new FormData();
                        values.append("email",$('#email').val());
                        values.append("sebagai",$('#sebagai').val());
                        $.ajax({
                            type: "POST",data:values, url: "{{ url('/api/submitForgotAuthor') }}",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            dataType: 'json', processData: false, contentType: false,
                            success: function(response) {
                                if (response.status === "OK"){
                                    swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                        if (result.value) {
                                            location.reload();
                                        }
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
    </script>
@endsection
