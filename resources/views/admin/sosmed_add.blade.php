@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/sosmed')}}">Sosmed</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form id="formExecute" class="formExecute">
                            <div class="form-group mb-0">
                                <label for="sosmed" class="col-form-label text-brown"><small><b><code>*)</code>Sosmed Name</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="sosmed" name="sosmed" placeholder="Please fill in...">
                            </div>
                            <div class="form-group mb-0">
                                <label for="icon" class="col-form-label text-default"><small><b><code>*)</code>Icon</b></small></label>
                                <div class="input-group mb-0">
                                    <input type="text" class="form-control border border-default" name="icon" id="icon" placeholder="Icon example fab fa-youtube">
                                    <div class="input-group-append">
                                        <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" class="btn btn-default" type="button">Choose</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label for="link" class="col-form-label text-brown"><small><b><code>*)</code>Link</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="link" name="link" placeholder="http://tic.com OR https://tic.com...">
                            </div>
                            <div class="form-group">
                                <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                                <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="PUBLISH">PUBLISH</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary float-right">Save</button>
                            <a href="{{url('/admin/sosmed')}}" type="button" class="btn btn-sm btn-danger float-right mr-1">Cancel</a>
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
            setAktifItem('sosmed');
        });

        $(function() {
            $('#formExecute').validate({
                rules: {
                    icon: { required: true, },nama: { required: true, },link: { required: true, url: true, },
                },
                messages: {
                    icon: { required: "Please fill in", },nama: { required: "Please fill in", },
                    link: { required: "Please fill in", url: "URL invalid" },
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
                                    type: "POST",data:values, url: "{{ url('/api/insertSosmed') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    window.location.replace("{{url('/admin/sosmed')}}");
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
