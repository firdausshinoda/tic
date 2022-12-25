@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/account')}}">Account</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Account</li>
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
                                        <label><b><code>*)</code>USERNAME</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="username" name="username" value="{{session()->get('username')}}" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>NAME</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="nama_admin" name="nama_admin" value="{{session()->get('nama_admin')}}" placeholder="Please fill in...">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label><b><code>*)</code>E-mail</b></label><br/>
                                        <input type="text" class="form-control h-min-formaccount" id="email" name="email" value="{{session()->get('email')}}" placeholder="Please fill in...">
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
        $(function() {
            $('#formExecute').validate({
                rules: {
                    username: { required: true, },nama_admin: { required: true, },email: { required: true, email: true},
                },
                messages: {
                    username: { required: "Please fill in", },nama_admin: { required: "Please fill in", },email: { required: "Please fill in", email: "E-mail invalid" },
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
                                    type: "POST",data:values, url: "{{ url('/api/updateAccount') }}",
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
