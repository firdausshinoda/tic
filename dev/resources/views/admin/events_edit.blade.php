@extends('admin.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/admin')}}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admin/events')}}">Events</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title py-3 text-brown text-center">EDIT EVENT</h5>
                        <hr>
                        <form id="formExecute" class="formExecute" enctype="multipart/form-data">
                            <div class="form-group mb-0">
                                <label for="event" class="col-form-label text-brown"><small><b><code>*)</code>Event Name</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="event" name="event" value="{{$data->event}}" placeholder="Please fill in...">
                                <input type="hidden" id="slug_event_old" name="slug_event_old" value="{{$data->slug_event}}">
                            </div>
                            <div class="form-group mb-0">
                                <label for="img_header" class="col-form-label text-brown"><small><b>Pamphlet (Max 3 Mb)</b></small></label><br>
                                <div class="mb-3 text-center">
                                    @if(empty($data->pamflet))
                                        <img src="{{asset('/img/empty.jpg')}}" style="height: 80vh" id="PreviewImg">
                                    @else
                                        <img src="{{asset('/upload/event/'.$data->pamflet)}}" style="height: 80vh" id="PreviewImg">
                                    @endif
                                    <input type="hidden" id="pamflet_lama" name="pamflet_lama" value="{{$data->pamflet}}">
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="pamflet" name="pamflet" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                                    <label class="custom-file-label text-default" for="foto">Choose file</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tahun_event" class="col-form-label text-brown"><small><b><code>*)</code>Year Event</b></small></label>
                                <input type="text" class="form-control border border-default rounded" id="tahun_event" name="tahun_event" value="{{$data->tahun_event}}" placeholder="Please fill in...">
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("pamflet").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
        $(function() {
            $('#formExecute').validate({
                rules: {
                    event: { required: true, },tahun_event: { required: true, digits: true, maxlength: 4, },
                    pamflet: {extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 3000000, },
                },
                messages: {
                    event: { required: "Please fill in", },tahun_event: { required: "Please fill in", digits: "Only number", maxlength: "Max 4 digits" },
                    pamflet: {extension: "Only PNG , JPEG , JPG...", },
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
                                loader_show_upload();
                                var values = new FormData();
                                values.append('pamflet', $("#pamflet")[0].files[0]);
                                values.append("event",$('#event').val());
                                values.append("slug_event_old",$('#slug_event_old').val());
                                values.append("tahun_event",$('#tahun_event').val());
                                values.append("pamflet_lama",$('#pamflet_lama').val());
                                $.ajax({
                                    xhr : function() {
                                        var xhr = new window.XMLHttpRequest();
                                        xhr.upload.addEventListener('progress', function(e){
                                            if(e.lengthComputable){
                                                var percent = Math.round((e.loaded / e.total) * 100);
                                                $('#progressBar-determinate').css('width', percent + '%');
                                            }
                                        });
                                        return xhr;
                                    },
                                    type: "POST",data:values, url: "{{ url('/api/updateEvents') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
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
