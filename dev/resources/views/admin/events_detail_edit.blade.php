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
                    <form id="formExecute" class="formExecute">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                                <div class="form-control border border-default rounded">{{$nama}}</div>
                                <input type="hidden" name="key" id="key" value="{{$key}}">
                                <input type="hidden" name="id" id="id" value="{{$id}}">
                            </div>
                            <div class="form-group mb-0">
                                <label for="deskripsi" class="col-form-label text-brown"><small><b><code>*)</code>Description</b></small></label>
                                @if($page=="setting-edit-full")
                                    <div id="deskripsi" name="deskripsi"><?= $deskripsi?></div>
                                @elseif($page=="setting-edit-text")
                                    <input type="text" class="form-control border border-default rounded" name="deskripsi" id="deskripsi" value="{{$deskripsi}}" placeholder="Please fill in...">
                                @elseif($page=="setting-edit-number")
                                    <input type="text" class="form-control border border-default rounded" name="deskripsi" id="deskripsi" value="{{$deskripsi}}" placeholder="Please fill in...">
                                @elseif($page=="setting-edit-foto")
                                    <br/>
                                    <center>
                                        @if(empty($deskripsi))
                                            <img src="{{asset('/img/empty.jpg')}}" class="w-50 border" id="PreviewImg">
                                        @else
                                            <img src="{{asset('/upload/ttd/'.$deskripsi)}}" class="w-50 border" id="PreviewImg">
                                        @endif
                                    </center>
                                    <div class="custom-file">
                                        <input type="hidden" name="foto_lama" id="foto_lama" value="{{$deskripsi}}">
                                        <input type="file" class="custom-file-input" id="foto" name="foto" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                                        <label class="custom-file-label text-default" for="foto">Choose file</label>
                                    </div>
                                @else
                                    <input type="text" class="form-control border border-default rounded datepicker" name="deskripsi" id="deskripsi" value="{{$deskripsi}}" placeholder="Please fill in...">
                                @endif
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                        </div>
                    </form>
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
    </script>
    @if($page=="setting-edit-full")
        <script type="text/javascript">
            $(function() {
                document.getElementsByClassName('modal')[0].removeAttribute('tabindex');
                CKEDITOR.replace('deskripsi',{height: '200px', width: 'auto'});
                $('#formExecute').validate({
                    rules: {
                        deskripsi: {required: true, },
                    },
                    messages: {
                        deskripsi: { required: "Please fill in", },
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
                                    values.append('id',$('#id').val());
                                    values.append('key',$('#key').val());
                                    values.append("deskripsi",CKEDITOR.instances.deskripsi.getData());
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
                                        type: "POST",data:values, url: "{{ url('/api/updateSetting') }}",
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        dataType: 'json', processData: false, contentType: false,
                                        success: function(response) {
                                            loader_hide_upload();
                                            if (response.status === "OK"){
                                                swalWithBootstrapButtons.fire({title: 'Success.', text: "Please press the refresh button above the settings table.", icon: 'success',}).then((result) => {
                                                    if (result.value) {
                                                        window.close();
                                                    }
                                                });
                                            } else {
                                                swall_failed_text(response.message);
                                            }
                                        },
                                        error:function(response){
                                            loader_hide_upload();
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
    @elseif($page=="setting-edit-foto")
        <script type="text/javascript">
            function PreviewImagesp() {
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("foto").files[0]);
                oFReader.onload = function (oFREvent) {
                    document.getElementById("PreviewImg").src = oFREvent.target.result;
                };
            }
            $(function() {
                $('#formExecute').validate({
                    rules: {
                        foto: {extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000, },
                    },
                    messages: {
                        foto: {extension: "Only PNG , JPEG , JPG...", },
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
                                    values.append('foto', $("#foto")[0].files[0]);
                                    values.append('id',$('#id').val());
                                    values.append('key',$('#key').val());
                                    values.append("foto_lama",$('#foto_lama').val());
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
                                        type: "POST",data:values, url: "{{ url('/api/updateSettingFoto') }}",
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        dataType: 'json', processData: false, contentType: false,
                                        success: function(response) {
                                            loader_hide_upload();
                                            if (response.status === "OK"){
                                                swalWithBootstrapButtons.fire({title: 'Success.', text: "Please press the refresh button above the settings table.", icon: 'success',}).then((result) => {
                                                    if (result.value) {
                                                        window.close();
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
    @elseif($page=="setting-edit-number")
        <script type="text/javascript">
            $(function() {
                $('#formExecute').validate({
                    rules: {
                        deskripsi: {required: true, digits: true, },
                    },
                    messages: {
                        deskripsi: { required: "Please fill in", digits: "Only number"  },
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
                                    values.append('id',$('#id').val());
                                    values.append('key',$('#key').val());
                                    values.append('deskripsi',$('#deskripsi').val());
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
                                        type: "POST",data:values, url: "{{ url('/api/updateSetting') }}",
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        dataType: 'json', processData: false, contentType: false,
                                        success: function(response) {
                                            loader_hide_upload();
                                            if (response.status === "OK"){
                                                swalWithBootstrapButtons.fire({title: 'Success.', text: "Please press the refresh button above the settings table.", icon: 'success',}).then((result) => {
                                                    if (result.value) {
                                                        window.close();
                                                    }
                                                });
                                            } else {
                                                swall_failed_text(response.message);
                                            }
                                        },
                                        error:function(response){
                                            loader_hide_upload();
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
    @else
        <script type="text/javascript">
            $(function() {
                $(".datepicker").datepicker({
                    format: "yyyy-mm-dd",
                    todayHighlight: true,
                    autoclose: true
                }).attr("readonly", "readonly").css({"cursor":"pointer", "background":"white"});

                $('#formExecute').validate({
                    rules: {
                        deskripsi: {required: true, },
                    },
                    messages: {
                        deskripsi: { required: "Please fill in", },
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
                                    values.append('id',$('#id').val());
                                    values.append('key',$('#key').val());
                                    values.append('deskripsi',$('#deskripsi').val());
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
                                        type: "POST",data:values, url: "{{ url('/api/updateSetting') }}",
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        dataType: 'json', processData: false, contentType: false,
                                        success: function(response) {
                                            loader_hide_upload();
                                            if (response.status === "OK"){
                                                swalWithBootstrapButtons.fire({title: 'Success.', text: "Please press the refresh button above the settings table.", icon: 'success',}).then((result) => {
                                                    if (result.value) {
                                                        window.close();
                                                    }
                                                });
                                            } else {
                                                swall_failed_text(response.message);
                                            }
                                        },
                                        error:function(response){
                                            loader_hide_upload();
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
    @endif
@endsection
