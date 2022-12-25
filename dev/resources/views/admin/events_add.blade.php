@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/events')}}">Events</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title py-3 text-brown text-center">ADD EVENT</h5>
                        <hr>
                        <form id="formExecute" class="formExecute">
                            <div class="form-group mb-0">
                                <label for="event" class="col-form-label text-brown"><small><b><code>*)</code>Event Name</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="event" name="event" placeholder="Please fill in...">
                            </div>
                            <div class="form-group">
                                <label for="tahun_event" class="col-form-label text-brown"><small><b><code>*)</code>Year Event</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="tahun_event" name="tahun_event" placeholder="Please fill in...">
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary float-right">Save</button>
                            <button type="button" class="btn btn-sm btn-danger float-right mr-1" onclick="history.back();">Cancel</button>
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
            setAktifItem('events');
        });

        $(function() {
            $('#formExecute').validate({
                rules: {
                    event: { required: true, },tahun_event: { required: true, digits: true, maxlength: 4, },
                },
                messages: {
                    event: { required: "Please fill in", },tahun_event: { required: "Please fill in", digits: "Only number", maxlength: "Max 4 digits" },
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
                                    type: "POST",data:values, url: "{{ url('/api/insertEvents') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    window.location.replace("{{url('/admin/events')}}");
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
