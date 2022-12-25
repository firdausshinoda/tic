@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/country')}}">Country</a></li>
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
                                <label for="negara" class="col-form-label text-brown"><small><b><code>*)</code>Country Name</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="negara" name="negara" placeholder="Please fill in...">
                            </div>
                            <div class="form-group">
                                <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                                <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="PUBLISH">PUBLISH</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary float-right">Save</button>
                            <a href="{{url('/admin/country')}}" type="button" class="btn btn-sm btn-danger float-right mr-1">Cancel</a>
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
            setAktifItem('country');
        });

        $(function() {
            $('#formExecute').validate({
                rules: {
                    negara: { required: true, },
                },
                messages: {
                    negara: { required: "Please fill in", },
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
                                    type: "POST",data:values, url: "{{ url('/api/insertCountry') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    window.location.replace("{{url('/admin/country')}}");
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
