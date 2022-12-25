@if($page=="viewIMG")
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">VIEW IMAGE</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <img src="{{asset('upload').'/'.$file}}" class="w-100"/>
                </div>
            </form>
        </div>
    </div>
@elseif($page=="payment-journal-view")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">PAYMENT JOURNAL</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="determinate" id="progressBar-determinate" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <div class="form-control">{{$data->pembayaran_bank}}</div>
                    </div>
                    <div class="form-group">
                        <label>Account Holder</label>
                        <div class="form-control">{{$data->pembayaran_an}}</div>
                    </div>
                    <div class="form-group">
                        <label>Invoice Code</label>
                        <div class="form-control">{{$data->pembayaran_invoice}}</div>
                    </div>
                    <div class="form-group">
                        <label for="foto" class="form-label mb-0"><b>Proof of Bank Transfer</b></label><br/>
                        <center><img src="{{asset('/upload/pembayaran/'.$data->file_pembayaran)}}" class="w-100" id="PreviewImg"></center>
                    </div>
                    <div class="form-group">
                        <label>Status Payment</label>
                        <div class="form-control">{{$data->stt_pembayaran=="NOT PAID YET"?"WAITING CONFIRMATION":"ACCEPTED"}}</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@elseif($page=="payment-participan-view")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">PAYMENT PARTICIPAN</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="determinate" id="progressBar-determinate" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <div class="form-control">{{$data->pembayaran_bank}}</div>
                    </div>
                    <div class="form-group">
                        <label>Account Holder</label>
                        <div class="form-control">{{$data->pembayaran_an}}</div>
                    </div>
                    <div class="form-group">
                        <label>Invoice Code</label>
                        <div class="form-control">{{$data->pembayaran_invoice}}</div>
                    </div>
                    <div class="form-group">
                        <label for="foto" class="form-label mb-0"><b>Proof of Bank Transfer</b></label><br/>
                        <center><img src="{{asset('/upload/pembayaran/'.$data->file_pembayaran)}}" class="w-100" id="PreviewImg"></center>
                    </div>
                    <div class="form-group">
                        <label>Status Payment</label>
                        <div class="form-control">{{$data->stt_pembayaran=="NOT PAID YET"?"WAITING CONFIRMATION":"ACCEPTED"}}</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@elseif($page=="reviewers-photo")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT PHOTO REVIEWER</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-brown"><small><b>Photo</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="<?= empty($data->foto_reviewer) ? asset('img/user_default.jpg') : asset('/upload/reviewer/'.$data->foto_reviewer); ?>" class="center-cropped w-50" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input form-control-sm" id="foto" name="foto" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-brown" for="foto">Choose file</label>
                            <input type="hidden" id="foto_lama" name="foto_lama" value="{{$data->foto_reviewer}}">
                            <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_reviewer)}}">
                        </div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#formExecuteModal').validate({
                rules: {
                    foto: {required: true, extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000, },
                },
                messages: {
                    foto: {required: "Please fill in", extension: "Only PNG , JPEG , JPG...", },
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
                                $image_crop.croppie('result', {
                                    type: 'canvas',size: 'viewport'
                                }).then(function(response){
                                    loader_show_upload()
                                    var values = new FormData();
                                    values.append('foto', response);
                                    values.append('foto_lama', $('#foto_lama').val());
                                    values.append("id",$('#id').val());
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
                                        type: "POST",data:values,url: "{{ url('/api/updateReviewersPhoto') }}",
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        dataType: 'json', processData: false, contentType: false,
                                        success: function(response) {
                                            loader_hide_upload();
                                            if (response.status === "OK"){
                                                swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                    if (result.value) {
                                                        reloadTable();
                                                        $('#Modal').modal('hide');
                                                    }
                                                });
                                            } else {
                                                swall_failed_text(response.message);
                                            }
                                        },
                                        error:function(data){
                                            loader_hide_upload()
                                            swall_error();
                                        }
                                    });
                                });
                            })
                        },
                        allowOutsideClick: false,
                    });
                }
            });
        });
        $image_crop = $('#PreviewImg').croppie({
            enableExif: true,
            viewport: {width:200, height:200, type:'square'},
            boundary:{width:300, height:300}
        });
        $('#foto').on('change', function(){
            var reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {url: event.target.result})
                    .then(function(){
                        console.log('jQuery bind complete');
                    });
            };
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@elseif($page=="cohost-add")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD CO HOST</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b><code>*)</code>Image (Max 1 Mb)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="" style="max-height: 25vh" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-default" for="foto">Choose file</label>
                            <input type="hidden" id="kode" name="kode" value="{{$kode}}">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="nama" name="nama" placeholder="Name...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="link" class="col-form-label text-brown"><small><b><code>*)</code>Link</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="link" name="link" placeholder="http://tic.com OR https://tic.com">
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#formExecuteModal').validate({
                rules: {
                    nama: { required: true, }, link: {required: true, url: true },
                    thumbnail: {required: true, extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000, },
                },
                messages: {
                    judul: { required: "Please fill in", }, link: { required: "Please fill in", url: "URL invalid" },
                    thumbnail: {required: "Please fill in", extension: "Only PNG , JPEG , JPG...", },
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
                                values.append('thumbnail', $("#thumbnail")[0].files[0]);
                                values.append("kode",$('#kode').val());
                                values.append("nama",$('#nama').val());
                                values.append("link",$('#link').val());
                                values.append("stt_data",$('#stt_data').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/insertCoHost') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableCoHost();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("thumbnail").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="cohost-edit")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT CO HOST</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b><code>*)</code>Image (Max 1 Mb)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="{{asset('upload/co_host/'.$data->thumbnail)}}" style="max-height: 25vh" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-default" for="foto">Choose file</label>
                            <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_cohost)}}">
                            <input type="hidden" id="thumbnail_lama" name="thumbnail_lama" value="{{$data->thumbnail}}">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="nama" name="nama" value="{{$data->nama}}" placeholder="Name...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="link" class="col-form-label text-brown"><small><b><code>*)</code>Link</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="link" name="link" value="{{$data->link}}" placeholder="http://tic.com OR https://tic.com">
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{ $data->stt_data }}"){$("#stt_data").val(this.value).change();}
            });
            $('#formExecuteModal').validate({
                rules: {
                    nama: { required: true, }, link: {required: true, url: true },
                    thumbnail: {extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000, },
                },
                messages: {
                    judul: { required: "Please fill in", }, link: { required: "Please fill in", url: "URL invalid" },
                    thumbnail: {extension: "Only PNG , JPEG , JPG...", },
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
                                values.append('thumbnail', $("#thumbnail")[0].files[0]);
                                values.append("id",$('#id').val());
                                values.append("nama",$('#nama').val());
                                values.append("link",$('#link').val());
                                values.append("stt_data",$('#stt_data').val());
                                values.append("thumbnail_lama",$('#thumbnail_lama').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/updateCoHost') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableCoHost();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("thumbnail").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="indexing-add")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD INDEXING</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b><code>*)</code>Logo (Max 1 MB)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="" class="w-50" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-default" for="logo">Pilih file</label>
                            <input type="hidden" id="id" name="id" value="{{$kode}}">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="nama" name="nama" placeholder="Name...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="link" class="col-form-label text-brown"><small><b><code>*)</code>Link</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="link" name="link" placeholder="http://tic.com OR https://tic.com">
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#formExecuteModal').validate({
                rules: {
                    nama: { required: true, }, link: {required: true, url: true },
                    logo: {required: true, extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000, },
                },
                messages: {
                    judul: { required: "Please fill in", }, link: { required: "Please fill in", url: "URL invalid" },
                    logo: {required: "Please fill in", extension: "Only PNG , JPEG , JPG...", },
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
                                values.append('logo', $("#logo")[0].files[0]);
                                values.append("id",$('#id').val());
                                values.append("nama",$('#nama').val());
                                values.append("link",$('#link').val());
                                values.append("stt_data",$('#stt_data').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/insertIndexing') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableIndexing();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("logo").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="indexing-edit")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT INDEXING</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b><code>*)</code>Image (Max 1 Mb)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="{{asset('upload/index/'.$data->logo)}}" style="max-height: 25vh" class="w-100" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-default" for="foto">Choose file</label>
                            <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_indexing)}}">
                            <input type="hidden" id="logo_lama" name="logo_lama" value="{{$data->logo}}">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="nama" name="nama" value="{{$data->nama}}" placeholder="Name...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="link" class="col-form-label text-brown"><small><b><code>*)</code>Link</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="link" name="link" value="{{$data->link}}" placeholder="http://tic.com OR https://tic.com">
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{ $data->stt_data }}"){$("#stt_data").val(this.value).change();}
            });
            $('#formExecuteModal').validate({
                rules: {
                    nama: { required: true, }, link: {required: true, url: true },
                    logo: {extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000, },
                },
                messages: {
                    judul: { required: "Please fill in", }, link: { required: "Please fill in", url: "URL invalid" },
                    logo: {extension: "Only PNG , JPEG , JPG...", },
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
                                values.append('logo', $("#logo")[0].files[0]);
                                values.append("id",$('#id').val());
                                values.append("nama",$('#nama').val());
                                values.append("link",$('#link').val());
                                values.append("stt_data",$('#stt_data').val());
                                values.append("logo_lama",$('#logo_lama').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/updateIndexing') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableIndexing();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("logo").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="type-payment-add")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD TYPE PAYMENT</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="judul" class="col-form-label text-brown"><small><b><code>*)</code>Type Payment</b></small></label>
                            <select class="form-control rounded" id="type_payment" name="type_payment">
                                <option value="BANK">BANK</option>
                                <option value="PAYPAL">PAYPAL</option>
                            </select>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="judul" class="col-form-label text-brown"><small><b><code>*)</code>Payment Type Name</b></small></label>
                            <input type="text" class="form-control rounded" id="payment_type_name" name="payment_type_name" placeholder="Please fill in...">
                            <input type="hidden" id="kode" name="kode" value="{{$kode}}">
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="number" class="col-form-label text-brown"><small><b><code>*)</code>Number</b></small></label>
                            <input type="text" class="form-control rounded" id="number" name="number" placeholder="Please fill in...">
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="name" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                            <input type="text" class="form-control rounded" id="name" name="name" placeholder="Please fill in...">
                        </div>
                        <div class="col-sm-12">
                            <hr/>
                            <small>Image Payment</small>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b><code>*)</code>Image 1 (Max 1 MB)</b></small></label><br/>
                            <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_1">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_img_1" name="input_img_1" onchange="PreviewImage1();" accept="image/jpeg,image/png">
                                <label class="custom-file-label text-default" for="foto">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 2 (Max 1 MB)</b></small></label><br/>
                            <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_2">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_img_2" name="input_img_2" onchange="PreviewImage2();" accept="image/jpeg,image/png">
                                <label class="custom-file-label text-default" for="foto">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 3 (Max 1 MB)</b></small></label><br/>
                            <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_3">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_img_3" name="input_img_3" onchange="PreviewImage3();" accept="image/jpeg,image/png">
                                <label class="custom-file-label text-default" for="foto">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 4 (Max 1 MB)</b></small></label><br/>
                            <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_4">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_img_4" name="input_img_4" onchange="PreviewImage4();" accept="image/jpeg,image/png">
                                <label class="custom-file-label text-default" for="foto">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 5 (Max 1 MB)</b></small></label><br/>
                            <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_5">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_img_5" name="input_img_5" onchange="PreviewImage5();" accept="image/jpeg,image/png">
                                <label class="custom-file-label text-default" for="foto">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                            <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                                <option value="DRAFT">DRAFT</option>
                                <option value="PUBLISH">PUBLISH</option>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#formExecuteModal').validate({
                rules: {
                    payment_type_name: { required: true, }, number: { required: true, }, name: {required: true, },
                    input_img_1: {required: true, extension: "png|jpeg|jpg|PNG|JPEG|JPG",filesize: 1000000,},
                    input_img_2: {extension: "png|jpeg|jpg|PNG|JPEG|JPG",filesize: 1000000,},
                    input_img_3: {extension: "png|jpeg|jpg|PNG|JPEG|JPG",filesize: 1000000,},
                    input_img_4: {extension: "png|jpeg|jpg|PNG|JPEG|JPG",filesize: 1000000,},
                    input_img_5: {extension: "png|jpeg|jpg|PNG|JPEG|JPG",filesize: 1000000,},
                },
                messages: {
                    payment_type_name: { required: "Please fill in", }, number: { required: "Please fill in", },
                    name: { required: "Please fill in", },
                    input_img_1: {required: "Please choose", extension: "Only PNG , JPEG , JPG...",},
                    input_img_2: {extension: "Only PNG , JPEG , JPG...",},
                    input_img_3: {extension: "Only PNG , JPEG , JPG...",},
                    input_img_4: {extension: "Only PNG , JPEG , JPG...",},
                    input_img_5: {extension: "Only PNG , JPEG , JPG...",},
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
                                values.append("jenis_pembayaran",$('#type_payment').val());
                                values.append("nama_jenis_pembayaran",$('#payment_type_name').val());
                                values.append("nomor_jenis_pembayaran",$('#number').val());
                                values.append("an_jenis_pembayaran",$('#name').val());
                                values.append("stt_data",$('#stt_data').val());
                                values.append("kode",$('#kode').val());
                                values.append('logo_1', $("#input_img_1")[0].files[0]);
                                values.append('logo_2', $("#input_img_2")[0].files[0]);
                                values.append('logo_3', $("#input_img_3")[0].files[0]);
                                values.append('logo_4', $("#input_img_4")[0].files[0]);
                                values.append('logo_5', $("#input_img_5")[0].files[0]);
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
                                    type: "POST",data:values, url: "{{ url('/api/insertTypePayment') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTablePayment();
                                                    $('#Modal').modal('hide');
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
        function PreviewImage1() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("input_img_1").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("img_1").src = oFREvent.target.result;
            };
        }
        function PreviewImage2() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("input_img_2").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("img_2").src = oFREvent.target.result;
            };
        }
        function PreviewImage3() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("input_img_3").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("img_3").src = oFREvent.target.result;
            };
        }
        function PreviewImage4() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("input_img_4").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("img_4").src = oFREvent.target.result;
            };
        }
        function PreviewImage5() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("input_img_5").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("img_5").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="type-payment-edit")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT TYPE PAYMENT</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="judul" class="col-form-label text-brown"><small><b><code>*)</code>Type Payment</b></small></label>
                            <select class="form-control rounded" id="type_payment" name="type_payment">
                                <option value="BANK">BANK</option>
                                <option value="PAYPAL">PAYPAL</option>
                            </select>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="judul" class="col-form-label text-brown"><small><b><code>*)</code>Payment Type Name</b></small></label>
                            <input type="text" class="form-control rounded" id="payment_type_name" name="payment_type_name" value="{{$data->nama_jenis_pembayaran}}" placeholder="Please fill in...">
                            <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_jenis_pembayaran)}}">
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="number" class="col-form-label text-brown"><small><b><code>*)</code>Number</b></small></label>
                            <input type="text" class="form-control rounded" id="number" name="number" value="{{$data->nomor_jenis_pembayaran}}" placeholder="Please fill in...">
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="name" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                            <input type="text" class="form-control rounded" id="name" name="name" value="{{$data->an_jenis_pembayaran}}" placeholder="Please fill in...">
                        </div>
                        <div class="col-sm-12">
                            <hr/>
                            <small>Image Payment</small>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b><code>*)</code>Image 1 (Max 1 MB)</b></small></label><br/>
                            @if(empty($data->logo_1))
                                <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_1">
                            @else
                                <img src="{{asset('upload/jenis_pembayaran/'.$data->logo_1)}}" class="img-crop-payment w-100" id="img_1">
                            @endif
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_img_1" name="input_img_1" onchange="PreviewImage1();" accept="image/jpeg,image/png">
                                <input type="hidden" id="logo_1_lama" name="logo_1_lama" value="{{$data->logo_1}}">
                                <label class="custom-file-label text-default" for="foto">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 2 (Max 1 MB)</b></small></label><br/>
                            @if(empty($data->logo_2))
                                <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_2">
                            @else
                                <img src="{{asset('upload/jenis_pembayaran/'.$data->logo_2)}}" class="img-crop-payment w-100" id="img_2">
                            @endif
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_img_2" name="input_img_2" onchange="PreviewImage2();" accept="image/jpeg,image/png">
                                <input type="hidden" id="logo_2_lama" name="logo_2_lama" value="{{$data->logo_2}}">
                                <label class="custom-file-label text-default" for="foto">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 3 (Max 1 MB)</b></small></label><br/>
                            @if(empty($data->logo_3))
                                <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_3">
                            @else
                                <img src="{{asset('upload/jenis_pembayaran/'.$data->logo_3)}}" class="img-crop-payment w-100" id="img_3">
                            @endif
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_img_3" name="input_img_3" onchange="PreviewImage3();" accept="image/jpeg,image/png">
                                <input type="hidden" id="logo_3_lama" name="logo_3_lama" value="{{$data->logo_3}}">
                                <label class="custom-file-label text-default" for="foto">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 4 (Max 1 MB)</b></small></label><br/>
                            @if(empty($data->logo_4))
                                <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_4">
                            @else
                                <img src="{{asset('upload/jenis_pembayaran/'.$data->logo_4)}}" class="img-crop-payment w-100" id="img_4">
                            @endif
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_img_4" name="input_img_4" onchange="PreviewImage4();" accept="image/jpeg,image/png">
                                <input type="hidden" id="logo_4_lama" name="logo_4_lama" value="{{$data->logo_4}}">
                                <label class="custom-file-label text-default" for="foto">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 5 (Max 1 MB)</b></small></label><br/>
                            @if(empty($data->logo_5))
                                <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_5">
                            @else
                                <img src="{{asset('upload/jenis_pembayaran/'.$data->logo_5)}}" class="img-crop-payment w-100" id="img_5">
                            @endif
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="input_img_5" name="input_img_5" onchange="PreviewImage5();" accept="image/jpeg,image/png">
                                <input type="hidden" id="logo_5_lama" name="logo_5_lama" value="{{$data->logo_5}}">
                                <label class="custom-file-label text-default" for="foto">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                            <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                                <option value="DRAFT">DRAFT</option>
                                <option value="PUBLISH">PUBLISH</option>
                            </select>
                        </div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $("select[name='type_payment'] > option").each(function () {
                if (this.value === "{{$data->jenis_pembayaran}}"){$("#type_payment").val(this.value).change();}
            });
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{$data->stt_data}}"){$("#stt_data").val(this.value).change();}
            });
            $('#formExecuteModal').validate({
                rules: {
                    payment_type_name: { required: true, }, number: { required: true, }, name: {required: true, },
                    input_img_1: {extension: "png|jpeg|jpg|PNG|JPEG|JPG",filesize: 1000000,},
                    input_img_2: {extension: "png|jpeg|jpg|PNG|JPEG|JPG",filesize: 1000000,},
                    input_img_3: {extension: "png|jpeg|jpg|PNG|JPEG|JPG",filesize: 1000000,},
                    input_img_4: {extension: "png|jpeg|jpg|PNG|JPEG|JPG",filesize: 1000000,},
                    input_img_5: {extension: "png|jpeg|jpg|PNG|JPEG|JPG",filesize: 1000000,},
                },
                messages: {
                    payment_type_name: { required: "Please fill in", }, number: { required: "Please fill in", },
                    name: { required: "Please fill in", },
                    input_img_1: {extension: "Only PNG , JPEG , JPG...",},
                    input_img_2: {extension: "Only PNG , JPEG , JPG...",},
                    input_img_3: {extension: "Only PNG , JPEG , JPG...",},
                    input_img_4: {extension: "Only PNG , JPEG , JPG...",},
                    input_img_5: {extension: "Only PNG , JPEG , JPG...",},
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
                                values.append("id",$('#id').val());
                                values.append("jenis_pembayaran",$('#type_payment').val());
                                values.append("nama_jenis_pembayaran",$('#payment_type_name').val());
                                values.append("nomor_jenis_pembayaran",$('#number').val());
                                values.append("an_jenis_pembayaran",$('#name').val());
                                values.append("stt_data",$('#stt_data').val());
                                values.append("logo_1_lama",$('#logo_1_lama').val());
                                values.append("logo_2_lama",$('#logo_2_lama').val());
                                values.append("logo_3_lama",$('#logo_3_lama').val());
                                values.append("logo_4_lama",$('#logo_4_lama').val());
                                values.append("logo_5_lama",$('#logo_5_lama').val());
                                values.append('logo_1', $("#input_img_1")[0].files[0]);
                                values.append('logo_2', $("#input_img_2")[0].files[0]);
                                values.append('logo_3', $("#input_img_3")[0].files[0]);
                                values.append('logo_4', $("#input_img_4")[0].files[0]);
                                values.append('logo_5', $("#input_img_5")[0].files[0]);
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
                                    type: "POST",data:values, url: "{{ url('/api/updateTypePayment') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTablePayment();
                                                    $('#Modal').modal('hide');
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
        function PreviewImage1() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("input_img_1").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("img_1").src = oFREvent.target.result;
            };
        }
        function PreviewImage2() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("input_img_2").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("img_2").src = oFREvent.target.result;
            };
        }
        function PreviewImage3() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("input_img_3").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("img_3").src = oFREvent.target.result;
            };
        }
        function PreviewImage4() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("input_img_4").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("img_4").src = oFREvent.target.result;
            };
        }
        function PreviewImage5() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("input_img_5").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("img_5").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="type-payment-detail")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">DETAIL TYPE PAYMENT</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="judul" class="col-form-label text-brown"><small><b><code>*)</code>Type Payment</b></small></label>
                            <div class="form-control rounded h-auto">{{$data->jenis_pembayaran}}</div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="judul" class="col-form-label text-brown"><small><b>Payment Type Name</b></small></label>
                            <div class="form-control rounded h-auto">{{$data->nama_jenis_pembayaran}}</div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="number" class="col-form-label text-brown"><small><b><code>*)</code>Number</b></small></label>
                            <div class="form-control rounded h-auto">{{$data->nomor_jenis_pembayaran}}</div>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-6">
                            <label for="name" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                            <div class="form-control rounded h-auto">{{$data->an_jenis_pembayaran}}</div>
                        </div>
                        <div class="col-sm-12">
                            <hr/>
                            <small>Image Payment</small>
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 1</b></small></label><br/>
                            @if(empty($data->logo_1))
                                <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_1">
                            @else
                                <img src="{{asset('upload/jenis_pembayaran/'.$data->logo_1)}}" class="img-crop-payment w-100" id="img_1">
                            @endif
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 2</b></small></label><br/>
                            @if(empty($data->logo_2))
                                <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_2">
                            @else
                                <img src="{{asset('upload/jenis_pembayaran/'.$data->logo_2)}}" class="img-crop-payment w-100" id="img_2">
                            @endif
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 3</b></small></label><br/>
                            @if(empty($data->logo_3))
                                <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_3">
                            @else
                                <img src="{{asset('upload/jenis_pembayaran/'.$data->logo_3)}}" class="img-crop-payment w-100" id="img_3">
                            @endif
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 4</b></small></label><br/>
                            @if(empty($data->logo_4))
                                <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_4">
                            @else
                                <img src="{{asset('upload/jenis_pembayaran/'.$data->logo_4)}}" class="img-crop-payment w-100" id="img_4">
                            @endif
                        </div>
                        <div class="form-group mb-0 col-sm-12 col-md-4">
                            <label for="name" class="col-form-label text-brown"><small><b>Image 5</b></small></label><br/>
                            @if(empty($data->logo_5))
                                <img src="{{asset('img/empty.jpg')}}" class="img-crop-payment w-100" id="img_5">
                            @else
                                <img src="{{asset('upload/jenis_pembayaran/'.$data->logo_5)}}" class="img-crop-payment w-100" id="img_5">
                            @endif
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                            <div class="form-control rounded h-auto">{{$data->stt_data}}</div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@elseif($page=="collaboration-add")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD COLLABORATION</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b><code>*)</code>Logo (Max 1 MB)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="" class="w-50" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <input type="hidden" id="kode" name="kode" value="{{$kode}}">
                            <label class="custom-file-label text-default" for="foto">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="nama" name="nama" placeholder="Please fill in...">
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
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $('#formExecuteModal').validate({
                rules: {
                    nama: { required: true, }, link: {required: true, url: true },
                    logo: {required: true, extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000,},
                },
                messages: {
                    nama: { required: "Please fill in", }, link: { required: "Please fill in", url: "URL invalid" },
                    logo: {required: "Please fill in", extension: "Only PNG , JPEG , JPG...", },
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
                                values.append('logo', $("#logo")[0].files[0]);
                                values.append("nama",$('#nama').val());
                                values.append("link",$('#link').val());
                                values.append("stt_data",$('#stt_data').val());
                                values.append("kode",$('#kode').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/insertCollaboration') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableCollaboration();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("logo").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="collaboration-edit")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT COLLABORATION</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b>Logo (Max 1 MB)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="{{asset('upload/kerjasama/'.$data->logo)}}" class="w-50" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo" name="logo" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <input type="hidden" name="id" id="id" value="{{\App\Helpers\Helpers::enkrip($data->id_kerjasama)}}">
                            <input type="hidden" name="logo_lama" id="logo_lama" value="{{$data->logo}}">
                            <label class="custom-file-label text-default" for="foto">Pilih file</label>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="nama" name="nama" placeholder="Please fill in..." value="{{$data->nama}}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="link" class="col-form-label text-brown"><small><b><code>*)</code>Link</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="link" name="link" placeholder="http://tic.com OR https://tic.com..." value="{{$data->link}}">
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAF">DRAF</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{ $data->stt_data }}"){$("#stt_data").val(this.value).change();}
            });
            $('#formExecuteModal').validate({
                rules: {
                    nama: { required: true, }, link: {required: true, url: true },
                    logo: {extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000, },
                },
                messages: {
                    nama: { required: "Please fill in", }, link: { required: "Please fill in", url: "URL invalid" },
                    logo: {extension: "Only PNG , JPEG , JPG...", },
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
                                values.append('logo', $("#logo")[0].files[0]);
                                values.append("nama",$('#nama').val());
                                values.append("link",$('#link').val());
                                values.append("id",$('#id').val());
                                values.append("logo_lama",$('#logo_lama').val());
                                values.append("stt_data",$('#stt_data').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/updateCollaboration') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableCollaboration();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("logo").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="keynote-speaker-add")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD KEYNOTE SPEAKER</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b><code>*)</code>Image (Max 2 Mb)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="" class="w-50" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-default" for="foto">Choose file</label>
                            <input type="hidden" id="kode" name="kode" value="{{$kode}}">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Sub</b></small></label>
                        <select class="form-control border border-default rounded" id="sub" name="sub">
                            @foreach($sub as $item)
                                <option value="{{\App\Helpers\Helpers::enkrip($item->id_sub)}}">{{$item->sub}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="nama" name="nama" placeholder="Please fill in...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="institusi" class="col-form-label text-brown"><small><b><code>*)</code>Institution</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="institusi" name="institusi" placeholder="Please fill in...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="topik" class="col-form-label text-brown"><small><b><code>*)</code>Topic</b></small></label>
                        <div id="topik" name="topik"></div>
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            CKEDITOR.replace('topik',{height: '200px', width: 'auto'});
            $('#formExecuteModal').validate({
                rules: {
                    nama: { required: true, }, institusi: { required: true, }, topik: {required: true, },
                    thumbnail: {required: true, extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 2000000,},
                },
                messages: {
                    nama: { required: "Please fill in", }, link: { required: "Please fill in", }, topik: { required: "Please fill in", },
                    thumbnail: {required: "Please fill in", extension: "Only PNG , JPEG , JPG...", },
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
                                values.append('thumbnail', $("#thumbnail")[0].files[0]);
                                values.append("sub",$('#sub').val());;
                                values.append("kode",$('#kode').val());
                                values.append("nama",$('#nama').val());
                                values.append("institusi",$('#institusi').val());
                                values.append("topik",CKEDITOR.instances.topik.getData());
                                values.append("stt_data",$('#stt_data').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/insertKeynoteSpeaker') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableKeynoteSpeaker();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("thumbnail").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="keynote-speaker-edit")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT KEYNOTE SPEAKER</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b>Image (Max 2 Mb)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="{{asset('/upload/keynote_speaker/'.$data->thumbnail)}}" style="height: 30vh" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-default" for="foto">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Sub</b></small></label>
                        <select class="form-control border border-default rounded" id="sub" name="sub">
                            @foreach($sub as $item)
                                <option value="{{\App\Helpers\Helpers::enkrip($item->id_sub)}}">{{$item->sub}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="nama" name="nama" placeholder="Please fill in..." value="{{$data->nama}}">
                        <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_keynote_speaker)}}">
                        <input type="hidden" id="thumbnail_lama" name="thumbnail_lama" value="{{$data->thumbnail}}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="institusi" class="col-form-label text-brown"><small><b><code>*)</code>Institution</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="institusi" name="institusi" placeholder="Please fill in..." value="{{$data->institusi}}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="topik" class="col-form-label text-brown"><small><b><code>*)</code>Topic</b></small></label>
                        <div id="topik" name="topik"><?= $data->topik; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            CKEDITOR.replace('topik',{height: '200px', width: 'auto'});
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{ $data->stt_data }}"){$("#stt_data").val(this.value).change();}
            });
            $("select[name='sub'] > option").each(function () {
                if (this.value === "{{ $data_id }}"){$("#sub").val(this.value).change();}
            });
            $('#formExecuteModal').validate({
                rules: {
                    nama: { required: true, }, institusi: { required: true, }, topik: {required: true, },
                    thumbnail: {extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000, },
                },
                messages: {
                    nama: { required: "Please fill in", }, institusi: { required: "Please fill in", }, topik: { required: "Please fill in", },
                    thumbnail: {extension: "Only PNG , JPEG , JPG...", },
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
                                values.append('thumbnail', $("#thumbnail")[0].files[0]);
                                values.append("nama",$('#nama').val());
                                values.append("sub",$('#sub').val());
                                values.append("institusi",$('#institusi').val());
                                values.append("topik",CKEDITOR.instances.topik.getData());
                                values.append("stt_data",$('#stt_data').val());
                                values.append("id",$('#id').val());
                                values.append("thumbnail_lama",$('#thumbnail_lama').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/updateKeynoteSpeaker') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableKeynoteSpeaker();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("thumbnail").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="keynote-speaker-detail")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">DETAIL KEYNOTE SPEAKER</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
            </div>
            <div class="modal-body">
                <div class="form-group mb-0">
                    <label for="img_header" class="col-form-label text-default"><small><b>Image</b></small></label><br>
                    <div class="mb-3 text-center">
                        <img src="{{asset('/upload/keynote_speaker/'.$data->thumbnail)}}" style="height: 30vh" id="PreviewImg">
                    </div>
                </div>
                <div class="form-group mb-0">
                    <label for="nama" class="col-form-label text-brown"><small><b>Name</b></small></label>
                    <div class="form-control border border-default rounded h-auto">{{$data->nama}}</div>
                </div>
                <div class="form-group mb-0">
                    <label for="institusi" class="col-form-label text-brown"><small><b>Institution</b></small></label>
                    <div class="form-control border border-default rounded h-auto">{{$data->institusi}}</div>
                </div>
                <div class="form-group mb-0">
                    <label for="topik" class="col-form-label text-brown"><small><b>Topic</b></small></label>
                    <div class="form-control border border-default rounded h-auto h-min-textarea"><?= $data->topik; ?></div>
                </div>
                <div class="form-group">
                    <label for="stt_data" class="col-form-label text-brown"><small><b>Status</b></small></label>
                    <div class="form-control border border-default rounded h-auto">{{$data->stt_data}}</div>
                </div>
            </div>
        </div>
    </div>
@elseif($page=="invited-speaker-add")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD INVITED SPEAKER</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b><code>*)</code>Image (Max 2 Mb)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="" class="w-50" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-default" for="foto">Choose file</label>
                            <input type="hidden" id="kode" name="kode" value="{{$kode}}">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Sub</b></small></label>
                        <select class="form-control border border-default rounded" id="sub" name="sub">
                            @foreach($sub as $item)
                                <option value="{{\App\Helpers\Helpers::enkrip($item->id_sub)}}">{{$item->sub}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="nama" name="nama" placeholder="Please fill in...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="institusi" class="col-form-label text-brown"><small><b><code>*)</code>Institution</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="institusi" name="institusi" placeholder="Please fill in...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="topik" class="col-form-label text-brown"><small><b><code>*)</code>Topic</b></small></label>
                        <div id="topik" name="topik"></div>
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            CKEDITOR.replace('topik',{height: '200px', width: 'auto'});
            $('#formExecuteModal').validate({
                rules: {
                    nama: { required: true, }, institusi: { required: true, }, topik: {required: true, },
                    thumbnail: {required: true, extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 2000000,},
                },
                messages: {
                    nama: { required: "Please fill in", }, link: { required: "Please fill in", }, topik: { required: "Please fill in", },
                    thumbnail: {required: "Please fill in", extension: "Only PNG , JPEG , JPG...", },
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
                                values.append('thumbnail', $("#thumbnail")[0].files[0]);
                                values.append("sub",$('#sub').val());
                                values.append("kode",$('#kode').val());
                                values.append("nama",$('#nama').val());
                                values.append("institusi",$('#institusi').val());
                                values.append("topik",CKEDITOR.instances.topik.getData());
                                values.append("stt_data",$('#stt_data').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/insertInvitedSpeaker') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableInvitedSpeaker();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("thumbnail").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="invited-speaker-edit")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT INVITED SPEAKER</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b>Image (Max 2 Mb)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="{{asset('/upload/invited_speaker/'.$data->thumbnail)}}" style="height: 30vh" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-default" for="foto">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Sub</b></small></label>
                        <select class="form-control border border-default rounded" id="sub" name="sub">
                            @foreach($sub as $item)
                                <option value="{{\App\Helpers\Helpers::enkrip($item->id_sub)}}">{{$item->sub}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b><code>*)</code>Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="nama" name="nama" placeholder="Please fill in..." value="{{$data->nama}}">
                        <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_invited_speaker)}}">
                        <input type="hidden" id="thumbnail_lama" name="thumbnail_lama" value="{{$data->thumbnail}}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="institusi" class="col-form-label text-brown"><small><b><code>*)</code>Institution</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="institusi" name="institusi" placeholder="Please fill in..." value="{{$data->institusi}}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="topik" class="col-form-label text-brown"><small><b><code>*)</code>Topic</b></small></label>
                        <div id="topik" name="topik"><?= $data->topik; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            CKEDITOR.replace('topik',{height: '200px', width: 'auto'});
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{ $data->stt_data }}"){$("#stt_data").val(this.value).change();}
            });
            $("select[name='sub'] > option").each(function () {
                if (this.value === "{{ $data->sub }}"){$("#sub").val(this.value).change();}
            });
            $('#formExecuteModal').validate({
                rules: {
                    nama: { required: true, }, institusi: { required: true, }, topik: {required: true, },
                    thumbnail: {extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000, },
                },
                messages: {
                    nama: { required: "Please fill in", }, institusi: { required: "Please fill in", }, topik: { required: "Please fill in", },
                    thumbnail: {extension: "Only PNG , JPEG , JPG...", },
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
                                values.append('thumbnail', $("#thumbnail")[0].files[0]);
                                values.append("sub",$('#sub').val());
                                values.append("nama",$('#nama').val());
                                values.append("institusi",$('#institusi').val());
                                values.append("topik",CKEDITOR.instances.topik.getData());
                                values.append("stt_data",$('#stt_data').val());
                                values.append("id",$('#id').val());
                                values.append("thumbnail_lama",$('#thumbnail_lama').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/updateInvitedSpeaker') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableInvitedSpeaker();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("thumbnail").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="invited-speaker-detail")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">DETAIL INVITED SPEAKER</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b>Image</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="{{asset('/upload/invited_speaker/'.$data->thumbnail)}}" style="height: 30vh" id="PreviewImg">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b>Name</b></small></label>
                        <div class="form-control border border-default rounded h-auto">{{$data->nama}}</div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b>Institution</b></small></label>
                        <div class="form-control border border-default rounded h-auto h-min-textarea">{{$data->institusi}}</div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="nama" class="col-form-label text-brown"><small><b>Topic</b></small></label>
                        <div class="form-control border border-default rounded h-auto"><?= $data->topik; ?></div>
                    </div>
                    <div class="form-group">
                        <label for="nama" class="col-form-label text-brown"><small><b>Status</b></small></label>
                        <div class="form-control border border-default rounded h-auto">{{$data->stt_data}}</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@elseif($page=="sub-add")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD SUB</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b><code>*)</code>Image (Max 2 Mb)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="" class="w-50" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-default" for="foto">Choose file</label>
                            <input type="hidden" id="kode" name="kode" value="{{$kode}}">
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="sub" class="col-form-label text-brown"><small><b><code>*)</code>Sub Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="sub" name="sub" placeholder="Please fill in...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="deskripsi" class="col-form-label text-brown"><small><b><code>*)</code>Description</b></small></label>
                        <textarea class="form-control border border-default rounded" id="deskripsi" name="deskripsi" placeholder="Please fill in..." rows="3"></textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label for="link_video_youtube" class="form-label mb-0"><small><b>Template Journal (DOC/DOCX Max 1 Mb)</b></small></label><br/>
                        <div id="view_doc" class="mt-3 ml-5 display-none">
                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="javascript:void(0)" class="mailbox-attachment-name text-decoration-none text-black" id="tx_file_nama"></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="template" name="template" onchange="PreviewFile();" accept="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                            <label class="custom-file-label text-default" for="foto">Search file</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        function PreviewFile() {
            var input = document.getElementById("template");
            var file_name = input.files[0].name;
            $('#view_doc').show();
            var nBytes = input.files[0].size;
            var sOutput = nBytes + " bytes";
            for (var aMultiples = ["K", "M", "G", "T", "P", "E", "Z", "Y"], nMultiple = 0, nApprox = nBytes / 1024; nApprox > 1; nApprox /= 1024, nMultiple++) {
                sOutput = nApprox.toFixed(3) +" "+ aMultiples[nMultiple];
            }
            if (file_name.length >= 20) {
                file_name = file_name.substring(0, 20)+"...";
            }
            $('#tx_file_nama').html('<i class="fas fa-paperclip"></i>'+file_name+'<span class="mailbox-attachment-size">'+sOutput+'</span>');
        }
        $(function() {
            $('#formExecuteModal').validate({
                rules: {
                    sub: { required: true, },  deskripsi: {required: true, },
                    thumbnail: {required: true, extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 2000000,},
                    template: {extension: "doc|docx", filesize: 1000000, },
                },
                messages: {
                    sub: { required: "Please fill in", }, deskripsi: { required: "Please fill in", },
                    thumbnail: {required: "Please fill in", extension: "Only PNG , JPEG , JPG...", },
                    template: {extension: "Only DOC or DOCX format file...", },
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
                                values.append('thumbnail', $("#thumbnail")[0].files[0]);
                                values.append('template', $("#template")[0].files[0]);
                                values.append("kode",$('#kode').val());
                                values.append("sub",$('#sub').val());
                                values.append("deskripsi",$('#deskripsi').val());
                                values.append("stt_data",$('#stt_data').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/insertSub') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableSub();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("thumbnail").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="sub-edit")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT SUB</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-default"><small><b>Image (Max 2 Mb)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="{{asset('/upload/sub/'.$data->thumbnail)}}" style="height: 30vh" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" onchange="PreviewImagesp();" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-default" for="foto">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="sub" class="col-form-label text-brown"><small><b><code>*)</code>Sub Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="sub" name="sub" placeholder="Please fill in..." value="{{$data->sub}}">
                        <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_sub)}}">
                        <input type="hidden" id="thumbnail_lama" name="thumbnail_lama" value="{{$data->thumbnail}}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="deskripsi" class="col-form-label text-brown"><small><b><code>*)</code>Description</b></small></label>
                        <textarea class="form-control border border-default rounded" id="deskripsi" name="deskripsi" placeholder="Please fill in..." rows="3">{{$data->deskripsi}}</textarea>
                    </div>
                    <div class="form-group mb-0">
                        <label for="link_video_youtube" class="form-label mb-0"><small><b>Template Journal (DOC/DOCX Max 1 Mb)</b></small></label><br/>
                        <div id="view_doc" class="mt-3 ml-5 display-none">
                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-word"></i></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="javascript:void(0)" class="mailbox-attachment-name text-decoration-none text-black" id="tx_file_nama"></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="template" name="template" onchange="PreviewFile();" accept="application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">
                            <label class="custom-file-label text-default" for="foto">Search file</label>
                        </div>
                        <input type="hidden" id="template_lama" value="{{$data->template}}">
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        var file_template = "{{$data->template}}";
        if (file_template!=="null" && file_template!==null && file_template!==""){
            $('#view_doc').show();
            var file_name = file_template;
            if (file_name.length >= 20) {
                file_name = file_name.substring(0, 20)+"...";
            }
            $('#tx_file_nama').html('<i class="fas fa-paperclip"></i>'+file_name+'<span class="mailbox-attachment-size"></span>');
        }
        function PreviewFile() {
            var input = document.getElementById("template");
            var file_name = input.files[0].name;
            $('#view_doc').show();
            var nBytes = input.files[0].size;
            var sOutput = nBytes + " bytes";
            for (var aMultiples = ["K", "M", "G", "T", "P", "E", "Z", "Y"], nMultiple = 0, nApprox = nBytes / 1024; nApprox > 1; nApprox /= 1024, nMultiple++) {
                sOutput = nApprox.toFixed(3) +" "+ aMultiples[nMultiple];
            }
            if (file_name.length >= 20) {
                file_name = file_name.substring(0, 20)+"...";
            }
            $('#tx_file_nama').html('<i class="fas fa-paperclip"></i>'+file_name+'<span class="mailbox-attachment-size">'+sOutput+'</span>');
        }
        $(function() {
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{ $data->stt_data }}"){$("#stt_data").val(this.value).change();}
            });
            $('#formExecuteModal').validate({
                rules: {
                    sub: { required: true, }, deskripsi: {required: true, },
                    thumbnail: {extension: "png|jpeg|jpg|PNG|JPEG|JPG", filesize: 1000000, },
                    template: {extension: "doc|docx", filesize: 1000000, },
                },
                messages: {
                    sub: { required: "Please fill in", }, deskripsi: { required: "Please fill in", },
                    thumbnail: {extension: "Only PNG , JPEG , JPG...", },
                    template: {extension: "Only DOC or DOCX format file...", },
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
                                values.append('thumbnail', $("#thumbnail")[0].files[0]);
                                values.append('template', $("#template")[0].files[0]);
                                values.append("sub",$('#sub').val());
                                values.append("deskripsi",$('#deskripsi').val());
                                values.append("stt_data",$('#stt_data').val());
                                values.append("id",$('#id').val());
                                values.append("thumbnail_lama",$('#thumbnail_lama').val());
                                values.append("template_lama",$('#template_lama').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/updateSub') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        loader_hide_upload();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableSub();
                                                    $('#Modal').modal('hide');
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
        function PreviewImagesp() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("thumbnail").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("PreviewImg").src = oFREvent.target.result;
            };
        }
    </script>
@elseif($page=="scope-add")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD SCOPE</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="scope" class="col-form-label text-brown"><small><b><code>*)</code>Scope</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="scope" name="scope" placeholder="Please fill in...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="sub" class="col-form-label text-brown"><small><b><code>*)</code>Sub Name</b></small></label>
                        <select class="form-control border border-default rounded select2" id="sub" name="sub" style="width: 100%">
                            @foreach($sub as $item)
                                <option value="{{\App\Helpers\Helpers::enkrip($item->id_sub)}}">{{$item->sub}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $(".select2").select2({"language": "en"});
            $('#formExecuteModal').validate({
                rules: {
                    scope: { required: true, }, sub: { required: true, },
                },
                messages: {
                    scope: { required: "Please fill in", }, sub: { required: "Please fill in", },
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
                                var values = $('#formExecuteModal').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/insertScope') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableScope();
                                                    $('#Modal').modal('hide');
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
@elseif($page=="scope-edit")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT SCOPE</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="scope" class="col-form-label text-brown"><small><b><code>*)</code>Scope</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="scope" name="scope" placeholder="Please fill in..." value="{{$data->scope}}">
                        <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_scope)}}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="sub" class="col-form-label text-brown"><small><b><code>*)</code>Sub Name</b></small></label>
                        <select class="form-control border border-default rounded select2 w-100" id="sub" name="sub">
                            @foreach($sub as $item)
                                <option value="{{\App\Helpers\Helpers::enkrip($item->id_sub)}}">{{$item->sub}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{ $data->stt_data }}"){$("#stt_data").val(this.value).change();}
            });
            $("select[name='sub'] > option").each(function () {
                if (this.value === "{{ $data->id_sub }}"){$("#sub").val(this.value).change();}
            });
            $('#formExecuteModal').validate({
                rules: {
                    scope: { required: true, }, sub: { required: true, },
                },
                messages: {
                    scope: { required: "Please fill in", }, sub: { required: "Please fill in", },
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
                                var values = $('#formExecuteModal').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/updateScope') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableScope();
                                                    $('#Modal').modal('hide');
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
@elseif($page=="vc-add")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD VC</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="vc" class="col-form-label text-brown"><small><b><code>*)</code>Name VC</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="vc" name="vc" placeholder="Please fill in...">
                    </div>
                    <div class="form-group mb-0">
                        <label for="sub" class="col-form-label text-brown"><small><b><code>*)</code>Sub Name</b></small></label>
                        <select class="form-control border border-default rounded select2" id="sub" name="sub" style="width: 100%">
                            @foreach($sub as $item)
                                <option value="{{\App\Helpers\Helpers::enkrip($item->id_sub)}}">{{$item->sub}}</option>
                            @endforeach
                        </select>
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
                        <input type="text" class="form-control border border-default rounded" id="link" name="link" placeholder="http://tic.com OR https://tic.com">
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $(".select2").select2({"language": "en"});
            $('#formExecuteModal').validate({
                rules: {
                    vc: { required: true, },icon: { required: true, },sub: { required: true, },link: { required: true, url: true, },
                },
                messages: {
                    vc: { required: "Please fill in", },icon: { required: "Please fill in", }, sub: { required: "Please fill in", },
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
                                loader_show();
                                var values = $('#formExecuteModal').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/insertVC') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableVC();
                                                    $('#Modal').modal('hide');
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
@elseif($page=="vc-edit")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT VC</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="vc" class="col-form-label text-brown"><small><b><code>*)</code>Name VC</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="vc" name="vc" placeholder="Please fill in..." value="{{$data->vc}}">
                        <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_vc)}}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="sub" class="col-form-label text-brown"><small><b><code>*)</code>Sub Name</b></small></label>
                        <select class="form-control border border-default rounded select2 w-100" id="sub" name="sub">
                            @foreach($sub as $item)
                                <option value="{{\App\Helpers\Helpers::enkrip($item->id_sub)}}">{{$item->sub}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label for="icon" class="col-form-label text-default"><small><b><code>*)</code>Icon</b></small></label>
                        <div class="input-group mb-0">
                            <input type="text" class="form-control border border-default" name="icon" id="icon" placeholder="Icon example fab fa-youtube" value="{{$data->icon}}">
                            <div class="input-group-append">
                                <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" class="btn btn-default" type="button">Cari</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mb-0">
                        <label for="link" class="col-form-label text-brown"><small><b><code>*)</code>Link</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="link" name="link" placeholder="http://tic.com OR https://tic.com..." value="{{$data->link}}">
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $("select[name='sub'] > option").each(function () {
                if (this.value === "{{ $data->id_sub }}"){$("#sub").val(this.value).change();}
            });
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{ $data->stt_data }}"){$("#stt_data").val(this.value).change();}
            });
            $('#formExecuteModal').validate({
                ules: {
                    vc: { required: true, },icon: { required: true, },sub: { required: true, },link: { required: true, url: true, },
                },
                messages: {
                    vc: { required: "Please fill in", },icon: { required: "Please fill in", }, sub: { required: "Please fill in", },
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
                                loader_show();
                                var values = $('#formExecuteModal').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/updateVC') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableVC();
                                                    $('#Modal').modal('hide');
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
@elseif($page=="timeline-add")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD TIMELINE</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="timeline" class="col-form-label text-brown"><small><b><code>*)</code>Timeline Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="timeline" name="timeline" placeholder="Please fill in...">
                        <input type="hidden" id="kode" name="kode" value="{{$kode}}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="date" class="col-form-label text-brown"><small><b><code>*)</code>Date</b></small></label>
                        <input type="text" class="form-control border border-default rounded datepicker" id="date" name="date" placeholder="Please fill in">
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                autoclose: true
            }).attr("readonly", "readonly").css({"cursor":"pointer", "background":"white"});
            $('#formExecuteModal').validate({
                rules: {
                    timeline: { required: true, },date: { required: true, },
                },
                messages: {
                    timeline: { required: "Please fill in", },date: { required: "Please fill in", },
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
                                var values = $('#formExecuteModal').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/insertTimeline') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableTimeline();
                                                    $('#Modal').modal('hide');
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
@elseif($page=="timeline-edit")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT VC</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="timeline" class="col-form-label text-brown"><small><b><code>*)</code>Timeline Name</b></small></label>
                        <input type="text" class="form-control border border-default rounded" id="timeline" name="timeline" placeholder="Please fill in..." value="{{$data->timeline}}">
                        <input type="hidden" id="id" name="id" value="{{\App\Helpers\Helpers::enkrip($data->id_timeline)}}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="date" class="col-form-label text-brown"><small><b><code>*)</code>Timeline Date</b></small></label>
                        <input type="text" class="form-control border border-default rounded datepicker" id="date" name="date" placeholder="Please fill in..." value="{{$data->date}}">
                    </div>
                    <div class="form-group">
                        <label for="stt_data" class="col-form-label text-brown"><small><b><code>*)</code>Status</b></small></label>
                        <select class="form-control border border-default rounded" id="stt_data" name="stt_data">
                            <option value="DRAFT">DRAFT</option>
                            <option value="PUBLISH">PUBLISH</option>
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            $(".datepicker").datepicker({
                format: "yyyy-mm-dd",
                todayHighlight: true,
                autoclose: true
            }).attr("readonly", "readonly").css({"cursor":"pointer", "background":"white"});
            $("select[name='stt_data'] > option").each(function () {
                if (this.value === "{{ $data->stt_data }}"){$("#stt_data").val(this.value).change();}
            });
            $('#formExecuteModal').validate({
                ules: {
                    timeline: { required: true, },date: { required: true, },
                },
                messages: {
                    timeline: { required: "Please fill in", },date: { required: "Please fill in", },
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
                                var values = $('#formExecuteModal').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/updateTimeline') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTableTimeline();
                                                    $('#Modal').modal('hide');
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
@elseif($page=="journal-add-reviewer")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">ADD REVIEWER ABSTRACT</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="sub" class="col-form-label text-brown"><small><b><code>*)</code>Reviewer</b></small></label>
                        <input type="hidden" name="abs" id="abs" value="{{$abs}}"/>
                        <select class="form-control border border-default rounded select2" id="reviewer" name="reviewer" style="width: 100%">
                            @foreach($data as $item)
                                <option value="{{\App\Helpers\Helpers::enkrip($item->id_reviewer)}}">{{$item->nama_depan." ".$item->nama_tengah." ".$item->nama_belakang}}</option>
                            @endforeach
                        </select>
                    </div>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        $(function() {
            var kd = "{{$kode}}";
            $(".select2").select2({"language": "en"});
            if (kd !== "0") {
                $('#reviewer').val(kd);
                $('#reviewer').trigger('change');
            }

            $('#formExecuteModal').validate({
                rules: {
                    reviewer: { required: true, },
                },
                messages: {
                    reviewer: { required: "Please fill in", },
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
                                var values = $('#formExecuteModal').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/updateJournalReviewer') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTable();
                                                    $('#Modal').modal('hide');
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
@elseif($page=="payment-journal")
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">UPLOAD PROOF OF PAYMENT </h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="determinate" id="progressBar-determinate" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Bank Destination</label>
                                <select type="text" class="form-control" id="bank_destination" name="bank_destination" onchange="getDetailPayment(this.value)">
                                    <option value="">--Please Choose --</option>
                                    @foreach($jenis_pembayaran as $item)
                                        <option value="{{Helpers::enkrip($item->id_jenis_pembayaran)}}">{{$item->jenis_pembayaran." (".$item->nama_jenis_pembayaran.")"}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Account Number Destination</label>
                                <div class="form-control h-auto h-min-textarea" id="account_number_destination"></div>
                            </div>
                            <div class="form-group">
                                <label>Account Holder Destination</label>
                                <div class="form-control h-auto h-min-textarea" id="account_holder_destination"></div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <label>Bank Name</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Please fill in...">
                    </div>
                    <div class="form-group">
                        <label>Account Holder</label>
                        <input type="text" class="form-control" id="account_holder" name="account_holder" placeholder="Please fill in...">
                    </div>
                    <div class="form-group">
                        <label>Invoice Code</label>
                        <div class="form-control">{{$no_abstrak}}</div>
                        <input type="hidden" id="pembayaran_invoice" name="pembayaran_invoice" value="{{$no_abstrak}}">
                    </div>
                    <div class="form-group">
                        <label for="link_video_youtube" class="form-label mb-0"><b><code>*)</code>Proof of Bank Transfer (JPG/PNG/PDF) (Max 1 Mb)</b></label><br/>
                        <div class="display-none" id="view_img">
                            <center><img src="{{asset('/img/empty.jpg')}}" class="w-75" id="PreviewImg"></center>
                        </div>
                        <div id="view_pdf" class="mt-3 ml-5 display-none">
                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>
                                    <div class="mailbox-attachment-info">
                                        <a href="javascript:void(0)" class="mailbox-attachment-name text-decoration-none text-black" id="tx_file_nama"></a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file" onchange="PreviewImagesp();" accept="image/jpeg,image/png,application/pdf">
                            <label class="custom-file-label text-default" for="foto">Search file</label>
                        </div>
                        <input type="hidden" id="no_abs" value="{{$no_abs}}">
                        <input type="hidden" id="file_pembayaran" value="<?= empty($file_pembayaran) ? "0" : $file_pembayaran; ?>">
                    </div>
                    <code>*) Payment status will be confirmed instantly </code>
                    <hr/>
                    <div class="text-right">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">CANCEL</button>
                        <button type="submit" class="btn btn-primary">SAVE</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script type="text/javascript">
        function getDetailPayment(kd_bank) {
            if (kd_bank !== "") {
                $('#progress-modal').show();
                var values = new FormData();
                values.append("kd_bank",kd_bank);
                $.ajax({
                    type: "POST",data:values, url: "{{ url('/api/detailTypePayment') }}",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    dataType: 'json', processData: false, contentType: false,
                    success: function(response) {
                        $('#progress-modal').hide();
                        if (response.status === "OK"){
                            $('#account_number_destination').html(response.data.nomor_jenis_pembayaran);
                            $('#account_holder_destination').html(response.data.an_jenis_pembayaran);
                        } else {
                            swall_failed_text(response.message);
                        }
                    },
                    error:function(response){
                        swall_error();
                    }
                });
            }
        }
        function PreviewImagesp() {
            var input = document.getElementById("file");
            var file_name = input.files[0].name;
            var extention = file_name.substring(file_name.lastIndexOf('.') + 1).toLowerCase();
            if (extention==="pdf"){
                $('#view_pdf').show();
                $('#view_img').hide();
                var nBytes = input.files[0].size;
                var sOutput = nBytes + " bytes";
                for (var aMultiples = ["K", "M", "G", "T", "P", "E", "Z", "Y"], nMultiple = 0, nApprox = nBytes / 1024; nApprox > 1; nApprox /= 1024, nMultiple++) {
                    sOutput = nApprox.toFixed(3) +" "+ aMultiples[nMultiple];
                }
                if (file_name.length <= 20) {
                    file_name = file.name;
                } else {
                    file_name = file_name.substring(0, 20)+"...";
                }
                $('#tx_file_nama').html('<i class="fas fa-paperclip"></i>'+file_name+'<span class="mailbox-attachment-size">'+sOutput+'</span>');
            } else {
                $('#view_img').show();
                $('#view_pdf').hide();
                var oFReader = new FileReader();
                oFReader.readAsDataURL(document.getElementById("file").files[0]);
                oFReader.onload = function (oFREvent) {
                    document.getElementById("PreviewImg").src = oFREvent.target.result;
                };
            }
        }
        $(function() {
            $('#formExecuteModal').validate({
                rules: {
                    bank_destination: { required:true, },
                    file: { required: true, extension: 'png|jpeg|jpg|PNG|JPEG|JPG|pdf|PDF', filesize: 1000000},
                    bank_name: { required:true, },
                    account_holder: { required:true, },
                },
                messages: {
                    bank_destination: { required: "Please choose", },
                    file: { required: "Please fill in", extension: 'Only document files of type PNG , JPEG , JPG and PDF are allowed', },
                    bank_name: { required: "Please fill in", },
                    account_holder: { required: "Please fill in", },
                },
                errorElement : 'div', errorPlacement: function(error, element) {
                    var placement = $(element).data('error');
                    if (placement) {$(placement).append(error)} else {error.insertAfter(element);}
                },
                submitHandler: function(form) {
                    console.log("OK");
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
                                $('#progress-modal').show();
                                var values = new FormData();
                                values.append("bank_name",$('#bank_name').val());
                                values.append("account_holder",$('#account_holder').val());
                                values.append("pembayaran_invoice",$('#pembayaran_invoice').val());
                                values.append("no_abs",$('#no_abs').val());
                                values.append("id",$('#bank_destination').val());
                                values.append("file_pembayaran",$('#file_pembayaran').val());
                                values.append('file', $("#file")[0].files[0]);
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
                                    type: "POST",data:values, url: "{{ url('/api/updateMyJournalPaymentAdmin') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        $('#progress-modal').hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    reloadTable();
                                                    $('#Modal').modal('hide');
                                                }
                                            });
                                        } else {
                                            swall_failed_text(response.message);
                                        }
                                    },
                                    error:function(response){
                                        $('#progress-modal').hide();
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
@elseif($page=="payment-view")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">PAYMENT JOURNAL</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="determinate" id="progressBar-determinate" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Bank Name</label>
                        <div class="form-control">{{$data->pembayaran_bank}}</div>
                    </div>
                    <div class="form-group">
                        <label>Account Holder</label>
                        <div class="form-control">{{$data->pembayaran_an}}</div>
                    </div>
                    <div class="form-group">
                        <label>Invoice Code</label>
                        <div class="form-control">{{$data->pembayaran_invoice}}</div>
                    </div>
                    <div class="form-group">
                        <label for="foto" class="form-label mb-0"><b>Proof of Bank Transfer</b></label><br/>
                        <center><img src="{{asset('/upload/pembayaran/'.$data->file_pembayaran)}}" class="w-100" id="PreviewImg"></center>
                    </div>
                    <div class="form-group">
                        <label>Status Payment</label>
                        <div class="form-control">{{$data->stt_pembayaran=="NOT PAID YET"?"WAITING CONFIRMATION":"ACCEPTED"}}</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
