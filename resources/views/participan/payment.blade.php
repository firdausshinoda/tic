@extends('participan.template')

@section('konten')
    <div class="m-0 p-3">
        <div class="row">
            <div class="col-sm-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('/participan')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment</li>
                    </ol>
                </nav>
                <hr>
            </div>
            <div class="col-sm-12">
                <div class="callout callout-info display-none" id="view_payment_notif_nopaid">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    Please select a type of payment.
                </div>
                <div class="callout callout-warning display-none" id="view_payment_notif_wait">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    Please wait for payment confirmation.
                </div>
                <div class="callout callout-success display-none" id="view_payment_notif_success">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    Payment has been confirmed.
                </div>
                <div class="view_accepted display-none">

                </div>
                <div class="card">
                    <div class="card-body row">
                        <div class="col-12 col-sm-6">
                            <p class="mb-0"><b><u>PRICE</u></b></p>
                            <div id="div_harga"></div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <p class="mb-0"><b><u>DEADLINE PAYMENT</u></b></p>
                            <div class="countdown" id="countdown_payment">
                                <ul>
                                    <li class="text-center"><span class="tx_countdown" id="days_payment">:</span>DAYS</li>
                                    <li>:</li>
                                    <li class="text-center"><span class="tx_countdown" id="hours_payment"></span>HOURS</li>
                                    <li>:</li>
                                    <li class="text-center"><span class="tx_countdown" id="minutes_payment"></span>MINUTES</li>
                                    <li>:</li>
                                    <li class="text-center"><span class="tx_countdown" id="seconds_payment"></span>SECONDS</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="view_payment_show"></div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        var no_participan = "", id_payment = "", stt_payment = "", type_payment = "",
            file_payment = "", file_type = "";
        $(document).ready(function () {
            setAktifItem('payment');
            getData();
        });
        function getData() {
            loader_show();
            $.ajax({
                type: "GET",
                url: "{{url('api/participanPayment')}}",
                dataType: 'json',
                success: function(response)
                {
                    loader_hide();
                    if (response.status==="OK"){
                        var dt_akun = response.data_akun;
                        no_participan = dt_akun.no_participan;
                        id_payment = dt_akun.id_jenis_pembayaran;
                        stt_payment = dt_akun.stt_pembayaran_konfirmasi;
                        type_payment = dt_akun.jenis_pembayaran;
                        file_payment = dt_akun.file_pembayaran;
                        file_type = dt_akun.tipe_pembayaran;
                        if(stt_payment ==="ACCEPTED"){
                            $('#view_payment_notif_nopaid').hide();
                            $('#view_payment_notif_wait').hide();
                            $('#view_payment_notif_success').show();
                        } else if (stt_payment === "WAITING FOR CONFIRMATION") {
                            $('#view_payment_notif_nopaid').hide();
                            $('#view_payment_notif_wait').show();
                            $('#view_payment_notif_success').hide();
                        } else {
                            $('#view_payment_notif_nopaid').show();
                            $('#view_payment_notif_wait').hide();
                            $('#view_payment_notif_success').hide();
                        }

                        var dt_setting = response.data_setting;
                        var view_price = '<table><tbody>';
                        view_price+='<tr><td>Local Price</td><td class="pl-2 pr-2">:</td><td>Rp '+convertToRupiah(dt_setting.harga_participan_lokal)+'</td></tr>';
                        view_price+='<tr><td>International Price</td><td class="pl-2 pr-2">:</td><td>$ '+dt_setting.harga_participan_internasional+'</td></tr>';
                        $('#div_harga').html(view_price+'</tbody></table>');
                        setTimePayment(dt_setting.tgl_akhir_pembayaran);

                        var view_payment = "";
                        $.each(response.data_payment, function (index,element) {
                            var stt_bank_ = "Paypal";
                            if (element.jenis_pembayaran === "BANK"){ stt_bank_ = "Transfer Bank"; }
                            view_payment += '<div class="card mt-3 card-payment" id="card_payment_'+element.id_jenis_pembayaran+'">' +
                                '                            <div class="card-body">' +
                                '                                <div class="row">' +
                                '                                    <div class="col-sm-12 col-md-8">' +
                                '                                        <h6><b>'+stt_bank_+'</b></h6>' +
                                '                                        <table>' +
                                '                                            <tbody>' +
                                '                                            <tr>' +
                                '                                                <td>'+stt_bank_+' Name</td>' +
                                '                                                <td>:</td>' +
                                '                                                <td>'+element.nama_jenis_pembayaran+'</td>' +
                                '                                            </tr>' +
                                '                                            <tr>' +
                                '                                                <td>Swift/ BIC</td>' +
                                '                                                <td>:</td>' +
                                '                                                <td>'+no_participan.replace('TIC-','')+'</td>' +
                                '                                            </tr>' +
                                '                                            <tr>' +
                                '                                                <td>Account Number</td>' +
                                '                                                <td>:</td>' +
                                '                                                <td>'+element.nomor_jenis_pembayaran+'</td>' +
                                '                                            </tr>' +
                                '                                            <tr>' +
                                '                                                <td>Account Holder</td>' +
                                '                                                <td>:</td>' +
                                '                                                <td>'+element.an_jenis_pembayaran+'</td>' +
                                '                                            </tr>' +
                                '                                            </tbody>' +
                                '                                        </table>';
                            if (element.logo_1 !== null) {view_payment += '<img src="{{asset('upload/jenis_pembayaran')}}/'+element.logo_1+'" class="img-crop-payment-icon">';}
                            if (element.logo_2 !== null) {view_payment += '<img src="{{asset('upload/jenis_pembayaran')}}/'+element.logo_2+'" class="img-crop-payment-icon">';}
                            if (element.logo_3 !== null) {view_payment += '<img src="{{asset('upload/jenis_pembayaran')}}/'+element.logo_3+'" class="img-crop-payment-icon">';}
                            if (element.logo_4 !== null) {view_payment += '<img src="{{asset('upload/jenis_pembayaran')}}/'+element.logo_4+'" class="img-crop-payment-icon">';}
                            if (element.logo_5 !== null) {view_payment += '<img src="{{asset('upload/jenis_pembayaran')}}/'+element.logo_5+'" class="img-crop-payment-icon">';}
                            view_payment += '                                    </div>' +
                                '                                    <div class="col-sm-12 col-md-4">' +
                                '                                        <ul id="pdf_payment_'+element.id_jenis_pembayaran+'" class="mailbox-attachments align-items-stretch clearfix display-none">' +
                                '                                           <li>' +
                                '                                               <span class="mailbox-attachment-icon"><i class="far fa-file-pdf"></i></span>' +
                                '                                               <div class="mailbox-attachment-info">' +
                                '                                                   <a href="javascript:void(0)" class="mailbox-attachment-name text-decoration-none text-black" id="tx_file_nama_payment_'+element.id_jenis_pembayaran+'"></a>' +
                                '                                                   <a id="a_file_download_payment_'+element.id_jenis_pembayaran+'" class="btn btn-default btn-sm float-right text-light"><i class="fas fa-cloud-download-alt"></i></a>' +
                                '                                               </div>' +
                                '                                           </li>' +
                                '                                        </ul>' +
                                '                                        <img id="imv_payment_'+element.id_jenis_pembayaran+'" class="img-crop-nota-transfer w-100 display-none" style="height: 150px;">' +
                                '                                        <button id="btn_payment_'+element.id_jenis_pembayaran+'" type="submit" class="btn btn-info btn-block display-none btn_payment" onclick="modal(\'payment-participan\',\''+element.id_jenis_pembayaran+'\')">MAKE PAYMENT</button>' +
                                '                                        <button id="btn_payment_view_'+element.id_jenis_pembayaran+'" class="btn btn-info btn-block display-none" onclick="modal(\'payment-view\',\''+no_participan+'\')">VIEW PAYMENT</button>' +
                                '                                    </div>' +
                                '                                </div>' +
                                '                            </div>' +
                                '                        </div>';
                        });
                        $('#view_payment_show').html(view_payment);
                        if (stt_payment==="EMPTY"){
                            $('.btn_payment').show();
                        } else if (stt_payment==="WAITING FOR CONFIRMATION") {
                            $('.btn_payment').show();
                            $('.card-payment').hide();
                        } else {
                            $('.btn_payment').hide();
                            $('.card-payment').hide();
                        }
                        if (stt_payment !== "EMPTY"){
                            $('#card_payment_'+id_payment).show();
                            if (type_payment==="BANK"){
                                if (file_type === "pdf"){
                                    var file_payment_pdf = file_payment;
                                    if (file_payment_pdf.length > 15) {
                                        file_payment_pdf = file_payment_pdf.substring(0, 15)+"...";
                                    }
                                    $('#pdf_payment_'+id_payment).show();
                                    $('#tx_file_nama_payment_'+id_payment).html('<i class="fas fa-paperclip"></i>'+file_payment_pdf);
                                    $('#a_file_download_payment_'+id_payment).attr('href',"{{ url('download?type=payment') }}"+'&file='+file_payment+"&no_participan="+no_participan);
                                    $('#btn_payment_view_'+id_payment).hide();
                                } else {
                                    $('#pdf_payment_'+id_payment).hide();
                                    $('#imv_payment_'+id_payment).show();
                                    $('#imv_payment_'+id_payment).attr('src','{{asset('/upload/pembayaran')}}/'+file_payment);
                                    $('#btn_payment_view_'+id_payment).show();
                                }
                            }
                        }
                    } else {
                        swall_failed_text(response.message);
                    }
                },
                error:function(data){
                    loader_hide();
                    swall_error();
                }
            });
        }
        function setTimePayment(str) {
            const second = 1000, minute = second * 60, hour = minute * 60, day = hour * 24;
            let countDown = new Date(str+" 23:59:59").getTime(), x_time = setInterval(function() {
                let now = new Date().getTime(), distance = countDown - now;
                document.getElementById("days_payment").innerText = Math.floor(distance / (day)),
                    document.getElementById("hours_payment").innerText = Math.floor((distance % (day)) / (hour)),
                    document.getElementById("minutes_payment").innerText = Math.floor((distance % (hour)) / (minute)),
                    document.getElementById("seconds_payment").innerText = Math.floor((distance % (minute)) / second);
                if (distance < 0) {
                    clearInterval(x_time);
                    $('#countdown_payment').html('<b>PAYMENT HAS BEEN CLOSED</b>');
                }
            }, 0);
        }
    </script>
@endsection
