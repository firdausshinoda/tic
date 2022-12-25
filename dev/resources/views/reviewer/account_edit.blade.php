@extends('reviewer.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/reviewer')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/reviewer/account')}}">Account</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <center><h5 class="card-title text-dark py-3">ACCOUNT</h5></center>
                        <hr>
                        <form id="formExecute" class="formExecute">
                            <div class="row text-dark">
                                <div class="col-sm-12 text-center pb-5">
                                    <div style="width: 150px; margin-right: auto;margin-left: auto">
                                        <img id="foto" class="rounded-circle border rounded w-100" src="<?= empty(Session::get('foto_reviewer')) ? asset('img/user_default.jpg') : asset('/upload/reviewer/'.Session::get('foto_reviewer')); ?>">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>FIRST NAME</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="first_name" name="first_name" value="{{Session::get('nama_depan')}}" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b>MIDDLE NAME</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="middle_name" name="middle_name" value="{{Session::get('nama_tengah')}}" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>LAST NAME</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="last_name" name="last_name" value="{{Session::get('nama_belakang')}}" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label><b><code>*)</code>GENDER</b></label><br/>
                                        <select class="form-control" id="sex" name="sex">
                                            <option value="MALE">MALE</option>
                                            <option value="FEMALE">FEMALE</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label><b><code>*)</code>E-MAIL</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="email" name="email" placeholder="Please fill in..." value="{{Session::get('email')}}">
                                    </div>
                                </div>
                                <div class="col-sm-12 mt-2 text-right">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="history.back()">CANCEL</button>
                                    <button type="submit" class="btn btn-sm btn-primary">SAVE</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(document).ready(function () {
            $("select[name='sex'] > option").each(function () {
                if (this.value === "{{Session::get('jenis_kelamin')}}"){$("#sex").val(this.value).change();}
            });
        });
        $(function() {
            $('#formExecute').validate({
                rules: {
                    first_name: { required: true, lettersonlys: true, }, middle_name: { lettersonlys: true, },
                    last_name: { required: true, lettersonlys: true, }, email: { required: true, emailfull: true, },
                },
                messages: {
                    first_name: { required: "Please fill in", lettersonlys: "Only alphabet and space only", },
                    middle_name: { lettersonlys: "Only alphabet and space only", },
                    last_name: { required: "Please fill in", lettersonlys: "Only alphabet and space only", },
                    email: { required: "Please fill in", emailfull: "E-mail invalid" },
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
                            loader_show();
                            return new Promise(function (resolve) {
                                var values = $('#formExecute').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/updateAccountReviewer') }}",
                                    dataType: 'json', headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: response.message, icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    window.location.replace("{{url('/reviewer/account')}}");
                                                }
                                            });
                                        } else {
                                            swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: response.message});
                                        }
                                    },
                                    error:function(data){
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
