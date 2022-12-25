@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/contact')}}">Contact</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <form id="formExecute" class="formExecute">
                            <div class="form-group mb-0">
                                <label for="judul" class="col-form-label text-brown"><small><b><code>*)</code>Contact Name</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="judul" name="judul" value="{{$data->judul}}" placeholder="Please fill in...">
                                <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_kontak)}}">
                            </div>
                            <div class="form-group mb-0">
                                <label for="icon" class="col-form-label text-default"><small><b><code>*)</code>Icon</b></small></label>
                                <div class="input-group mb-0">
                                    <input type="text" class="form-control border border-default" name="icon" id="icon" placeholder="Icon example fab fa-youtube" value="{{$data->icon}}">
                                    <div class="input-group-append">
                                        <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" class="btn btn-default" type="button">Choose</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <label for="isi" class="col-form-label text-brown"><small><b><code>*)</code>Description</b></small></label>
                                <textarea class="form-control border border-default rounded" id="isi" name="isi" placeholder="Please fill in..." rows="3">{{$data->isi}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                                <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                                    <option value="DRAFT">DRAFT</option>
                                    <option value="PUBLISH">PUBLISH</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary float-right">Save</button>
                            <a href="{{url('/admin/contact')}}" type="button" class="btn btn-sm btn-danger float-right mr-1">Cancel</a>
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
            setAktifItem('contact');
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{ $data->stt_data }}"){$("#stt_data").val(this.value).change();}
            });
        });
        $(function() {
            $('#formExecute').validate({
                rules: {
                    judul: { required: true, },icon: { required: true, },isi: { required: true, },
                },
                messages: {
                    judul: { required: "Please fill in", },icon: { required: "Please fill in", },isi: { required: "Please fill in", },
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
                                    type: "POST",data:values, url: "{{ url('/api/updateContact') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    window.location.replace("{{url('/admin/contact')}}");
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
