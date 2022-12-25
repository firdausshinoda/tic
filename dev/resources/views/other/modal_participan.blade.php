@if($page=="account-photo")
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal" enctype="multipart/form-data">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">EDIT PHOTO PARTICIPAN</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="img_header" class="col-form-label text-brown"><small><b>Photo (Max 1 Mb)</b></small></label><br>
                        <div class="mb-3 text-center">
                            <img src="<?= empty(Session::get('foto_participan')) ? asset('img/user_default.jpg') : asset('/upload/participan/'.Session::get('foto_participan')); ?>" class="center-cropped w-50" id="PreviewImg">
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input form-control-sm" id="foto" name="foto" accept="image/jpeg,image/png">
                            <label class="custom-file-label text-brown" for="foto">Choose file</label>
                            <input type="hidden" id="foto_lama" name="foto_lama" value="{{Session::get('foto_participan')}}">
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
        var $image_crop;
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
                                $('#progress-modal').css('visibility', 'visible');
                                $image_crop.croppie('result', {
                                    type: 'canvas',size: 'viewport'
                                }).then(function(response){
                                    loader_show_upload()
                                    var values = new FormData();
                                    values.append('foto', response);
                                    values.append('foto_lama', $('#foto_lama').val());
                                    $.ajax({
                                        type: "POST",data:values,url: "{{ url('/api/updateAccountParticipanPhoto') }}",
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                        dataType: 'json', processData: false, contentType: false,
                                        success: function(response)
                                        {
                                            $('#progress-modal').css('visibility', 'hidden');
                                            if (response.status === "OK"){
                                                swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                    if (result.value) {
                                                        location.reload();
                                                        $('#Modal').modal('hide');
                                                    }
                                                });
                                            } else {
                                                swall_failed_text(response.message);
                                            }
                                        },
                                        error:function(data){
                                            $('#progress-modal').css('visibility', 'hidden');
                                            swalWithBootstrapButtons.fire({icon: 'error', title: 'Oops...', text: 'Terjadi Kesalahan. Silahkan coba lagi!!!'});
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
@elseif($page=="account-password")
    <style type="text/css">
        #password_lama-error, #password_baru-error, #password_ulangi-error {
            position: absolute;
            right: 0;top: 40px;
            border: solid 1px rgba(0, 0, 0, .5);background: #fff;box-shadow: 0px 2px 6px rgba(0, 0, 0, .5);
            padding: 2px 5px;z-index: 5;
        }
    </style>
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form id="formExecuteModal" class="formExecuteModal">
                <div class="modal-header">
                    <h6 class="modal-title text-default font-weight-bold" id="exampleModalLabel">Change Password</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="progress" id="progress-modal" style="position: absolute;top: 48px;visibility: hidden;">
                    <div class="indeterminate" id="progressBar" style="background-color: #000000"></div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="old_password" class="form-label mb-0"><b><code>*)</code>Old Password</b></label><br/>
                        <div class="input-group" id="show_hide_password_old_password">
                            <input type="password" id="password_lama" name="password_lama" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="button-addon">
                            <div class="input-group-append">
                                <button class="btn btn-default btn-outline-secondary" type="button"><i class="fas fa-eye-slash" id="i_old"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="new_password" class="form-label mb-0"><b><code>*)</code>New Password</b></label><br/>
                        <div class="input-group" id="show_hide_password_new_password">
                            <input type="password" id="password_baru" name="password_baru" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="button-addon">
                            <div class="input-group-append">
                                <button class="btn btn-default btn-outline-secondary" type="button"><i class="fas fa-eye-slash" id="i_new"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="rewrite_new_password" class="form-label mb-0"><b><code>*)</code>Rewrite New Password</b></label><br/>
                        <div class="input-group" id="show_hide_password_rewrite_new_password">
                            <input type="password" id="password_ulangi" name="password_ulangi" class="form-control" placeholder="Password" aria-label="Password" aria-describedby="button-addon">
                            <div class="input-group-append">
                                <button class="btn btn-default btn-outline-secondary" type="button"><i class="fas fa-eye-slash" id="i_retype"></i></button>
                            </div>
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
        $("#show_hide_password_old_password button").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password_old_password input').attr("type") == "text"){
                $('#show_hide_password_old_password input').attr('type', 'password');
                $('#i_old').addClass( "fa-eye-slash" ).removeClass( "fa-eye" );
            }else if($('#show_hide_password_old_password input').attr("type") == "password"){
                $('#show_hide_password_old_password input').attr('type', 'text');
                $('#i_old').removeClass( "fa-eye-slash" ).addClass( "fa-eye" );
            }
        });
        $("#show_hide_password_new_password button").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password_new_password input').attr("type") == "text"){
                $('#show_hide_password_new_password input').attr('type', 'password');
                $('#i_new').addClass( "fa-eye-slash" ).removeClass( "fa-eye" );
            }else if($('#show_hide_password_new_password input').attr("type") == "password"){
                $('#show_hide_password_new_password input').attr('type', 'text');
                $('#i_new').removeClass( "fa-eye-slash" ).addClass( "fa-eye" );
            }
        });
        $("#show_hide_password_rewrite_new_password button").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password_rewrite_new_password input').attr("type") == "text"){
                $('#show_hide_password_rewrite_new_password input').attr('type', 'password');
                $('#i_retype').addClass( "fa-eye-slash" ).removeClass( "fa-eye" );
            }else if($('#show_hide_password_rewrite_new_password input').attr("type") == "password"){
                $('#show_hide_password_rewrite_new_password input').attr('type', 'text');
                $('#i_retype').removeClass( "fa-eye-slash" ).addClass( "fa-eye" );
            }
        });
        $(function() {
            $('#formExecuteModal').validate({
                rules: {
                    password_lama: { required: true, },password_baru: { required: true, },
                    password_ulangi: {
                        required: true, equalTo:"#password_baru"
                    },
                },
                messages: {
                    password_lama: { required: "Please fill in", },password_baru: { required: "Please fill in", },
                    password_ulangi: {
                        required: "Please fill in",  equalTo:"Passwords are not the same"
                    },
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
                                var values = $('#formExecuteModal').serialize();
                                $.ajax({
                                    type: "POST",data:values, url: "{{ url('/api/updateAccountParticipanPassword') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, dataType: 'json',
                                    success: function(response) {
                                        loader_hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    getData();
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
@elseif($page=="payment-participan")
    <div class="modal-dialog" role="document">
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
                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Please fill in...">
                    </div>
                    <div class="form-group">
                        <label>Account Holder</label>
                        <input type="text" class="form-control" id="account_holder" name="account_holder" placeholder="Please fill in...">
                    </div>
                    <div class="form-group">
                        <label>Invoice Code</label>
                        <div class="form-control">{{$no_participan}}</div>
                        <input type="hidden" id="pembayaran_invoice" name="pembayaran_invoice" value="{{$no_participan}}">
                    </div>
                    <div class="form-group">
                        <label for="link_video_youtube" class="form-label mb-0"><b><code>*)</code>Proof of Bank Transfer (JPG/PNG/PDF) (Max 1 Mb)</b></label><br/>
                        <div class="display-none" id="view_img">
                            <center><img src="{{asset('/img/empty.jpg')}}" class="w-75" id="PreviewImg"></center>
                        </div>
                        <div class="display-none" id="view_pdf" class="mt-3 ml-5">
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
                        <input type="hidden" id="id" value="{{$id}}">
                        <input type="hidden" id="file_pembayaran" value="<?= empty($file_pembayaran) ? "0" : $file_pembayaran; ?>">
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
                    file: { required: true, extension: 'png|jpeg|jpg|PNG|JPEG|JPG|pdf|PDF', filesize: 1000000},
                    bank_name: { required:true, },
                    account_holder: { required:true, },
                },
                messages: {
                    file: { required: "Please fill in", extension: 'Only document files of type PNG , JPEG , JPG and PDF are allowed', },
                    bank_name: { required: "Please fill in", },
                    account_holder: { required: "Please fill in", },
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
                                $('#progress-modal').show();
                                var values = new FormData();
                                values.append("bank_name",$('#bank_name').val());
                                values.append("account_holder",$('#account_holder').val());
                                values.append("pembayaran_invoice",$('#pembayaran_invoice').val());
                                values.append("no_participan",$('#no_participan').val());
                                values.append("id",$('#id').val());
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
                                    type: "POST",data:values, url: "{{ url('/api/updateParticipanPayment') }}",
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                                    dataType: 'json', processData: false, contentType: false,
                                    success: function(response) {
                                        $('#progress-modal').hide();
                                        if (response.status === "OK"){
                                            swalWithBootstrapButtons.fire({title: 'Success.', text: "", icon: 'success',}).then((result) => {
                                                if (result.value) {
                                                    getData();
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
    <div class="modal-dialog" role="document">
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
                        <center><img src="{{asset('/upload/pembayaran/'.$data->file_pembayaran)}}" class="w-75" id="PreviewImg"></center>
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
