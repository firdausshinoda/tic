@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/reviewers')}}">Reviewers</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form id="formExecute" class="formExecute row">
                            <div class="form-group mb-0 col-sm-12 col-md-4">
                                <label for="nama_depan" class="col-form-label text-brown"><small><b><code>*)</code>First Name</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="first_name" name="first_name" value="{{$data->nama_depan}}" placeholder="Please fill in...">
                                <input type="hidden" id="id" name="id" value="{{$data->id_reviewer}}">
                            </div>
                            <div class="form-group mb-0 col-sm-12 col-md-4">
                                <label for="nama_tengah" class="col-form-label text-brown"><small><b>Middle Name</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="middle_name" name="middle_name" value="{{$data->nama_tengah}}" placeholder="Please fill in...">
                            </div>
                            <div class="form-group mb-0 col-sm-12 col-md-4">
                                <label for="nama_belakang" class="col-form-label text-brown"><small><b><code>*)</code>Last Name</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="last_name" name="last_name" value="{{$data->nama_belakang}}" placeholder="Please fill in...">
                            </div>
                            <div class="form-group mb-0 col-sm-12">
                                <label for="password" class="col-form-label text-brown"><small><b>Password</b></small></label>
                                <input type="password" class="form-control border border-default rounded" id="password" name="password" placeholder="Please fill in if you want to change the password.." autocomplete="off">
                            </div>
                            <div class="form-group mb-0 col-sm-12">
                                <label for="email" class="col-form-label text-brown"><small><b><code>*)</code>E-mail</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="email" name="email" value="{{$data->email}}" placeholder="Please fill in...">
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="jenis_kelamin" class="col-form-label text-brown"><small><b><code>*)</code>Gender</b></small></label>
                                <select class="form-control border border-default rounded" id="gender" name="gender">
                                    <option value="MALE">MALE</option>
                                    <option value="FEMALE">FEMALE</option>
                                </select>
                            </div>
                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-sm btn-primary float-right">Save</button>
                                <a href="{{url('/admin/reviewers')}}" type="button" class="btn btn-sm btn-danger float-right mr-1">Cancel</a>
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
        $(document).ready(function() {
            setAktifItem('reviewers');
            $("select[name='jenis_kelamin'] > option").each(function () {
                if (this.value === "{{ $data->jenis_kelamin }}"){$("#jenis_kelamin").val(this.value).change();}
            });
        });

        $(function() {
            $('#formExecute').validate({
                rules: {
                    first_name: { required: true, lettersonlys: true, }, middle_name: { lettersonlys: true, }, last_name: { required: true,  lettersonlys: true,},
                    email: { required: true, emailfull: true },
                },
                messages: {
                    first_name: { required: "Please fill in", lettersonlys: "Only alphabet and space only", }, middle_name: { lettersonlys: "Only alphabet and space only", },
                    last_name: { required: "Please fill in", lettersonlys: "Only alphabet and space only", },
                    email: { required: "Please fill in", emailfull: "E-mail invalid" },
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
                                loader_show();
                                var values = $('#formExecute').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/updateReviewers') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    window.location.replace("{{url('/admin/reviewers')}}");
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
