<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\TbAdminModel;
use App\Models\TbAuthorModel;
use App\Models\TbCoHostModel;
use App\Models\TbEventModel;
use App\Models\TbGelarModel;
use App\Models\TbIndexingModel;
use App\Models\TbInvitedSpeakerModel;
use App\Models\TbJenisPembayaranModel;
use App\Models\TbJurnalAuthorModel;
use App\Models\TbJurnalModel;
use App\Models\TbKerjaSamaModel;
use App\Models\TbKeynoteSpeakerModel;
use App\Models\TbKontakModel;
use App\Models\TbNegaraModel;
use App\Models\TbNoModel;
use App\Models\TbNotifAdminModel;
use App\Models\TbNotifAuthorModel;
use App\Models\TbNotifParticipanModel;
use App\Models\TbNotifReviewerModel;
use App\Models\TbParticipanModel;
use App\Models\TbReviewerModel;
use App\Models\TbScopeModel;
use App\Models\TbSettingModel;
use App\Models\TbSosmedModel;
use App\Models\TbSubModel;
use App\Models\TbTimelineModel;
use App\Models\TbVCModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class ApiAdminController extends Controller
{
    private $message_invalid_input = "The data you have entered is invalid!!!";
    private $message_failed_save = "Failed To Save Data...";

    public function jsonRegistrasi(Request $request){
        $password = Helpers::getRandomPassword();
        $eventModel = TbEventModel::where('stt_aktif',1)->first();
        $id_event = $eventModel->id_event;
        $kontak_nomor = "";
        $kontak = TbKontakModel::where('judul',"Whatsapp");
        if ($kontak->count() > 0) {
            $kontak_nomor = $kontak->first()->isi;
        }
        $tahun_event = $eventModel->tahun_event;
        $sbg_pdf = $request->sebagai;
        $email = $request->email;
        $stmt_cek_author = TbAuthorModel::where('email',$email);
        $stmt_cek_participan = TbParticipanModel::where('email',$email);
        $st_cek = false;
        $type_author = "";
        if ($sbg_pdf=="AUTHOR"){
            $type_author = "PRESENTER";
            if ($stmt_cek_author->count() > 0){
                $st_cek = true;
            } else {
                $st_cek = false;
            }
        } else {
            $type_author = "PARTICIPANT";
            if ($stmt_cek_participan->count() > 0){
                $st_cek = true;
            } else {
                $st_cek = false;
            }
        }

        if ($st_cek){
            return response()->json(['status' => 'ERROR', 'message' => 'E-mail already exists...']);
        } else {
            $to_name = $request->nama_depan." ".$request->nama_tengah." ".$request->nama_belakang;
            $to_email = $request->email;
            $to_body = 'Thank you for your registration as the '.$type_author.' of the conference.<br/>Please login using :<br/>
                        E-mail: '.$to_email.'<br/>Password: '.$password.'<br/>
                        Official Website https://tic.poltektegal.ac.id/<br/><br/>
                        Use Mozilla Firefox/Chrome/Safari browser for best performance of the conference system.<br/><br/>
                        Best Regards,<br/>
                        Organizing Committee TIC-MS 2022 Conference<br/>Politeknik Harapan Bersama<br/>
                        Kampus 1: Jl. Mataram No. 9 Tegal, Indonesia<br/>Kampus 2: Jl. Dewi Sartika No. 71 Tegal, Indonesia<br/>
                        Email     : tic@poltektegal.ac.id<br/>
                        Website : https://tic.poltektegal.ac.id/<br/>
                        CP         : '.$kontak_nomor;
            $data = array('name'=>$to_name, "body" => $to_body);
            Mail::send('other.mail', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)
                    ->subject('TIC Politeknik Harapan Bersama');
                $message->from('tic@poltektegal.ac.id','TIC Politeknik Harapan Bersama');
            });
            if (!Mail::failures()){
//                $update['email_password'] = "GAGAL TERKIRIM";
//                TbAuthorModel::where('id_author',$stmt)->update($update);
//                $input_notif['judul'] = "E-mail registrasi gagal terkirim";
//                $input_notif['id_author'] = $stmt;
//                $input_notif['pesan'] = "The server failed to send e-mail, please manually resend it by going to the author menu and searching by e-mail. Then select the author account and in the author details there is a button to send e-mail again. Author e-mail  : ".$request->email;
//                TbNotifAdminModel::insert($input_notif);
                $stmt_no = TbNoModel::where('id_event',$id_event)->first();
                if ($sbg_pdf=="AUTHOR"){
                    $no_kode = 1;
                    $no = $stmt_no->no_author;
                } else {
                    $no_kode = 2;
                    $no = $stmt_no->no_participan;
                }
                $no_akhir = (int)$no+1;
                if (strlen($no_akhir)==1){
                    $no = "00".$no_akhir;
                } else if (strlen($no_akhir)==2){
                    $no = "0".$no_akhir;
                } else {
                    $no = $no_akhir;
                }
                $no_pendaftaran = $no_kode.substr($tahun_event,2,2).$no;
                if ($sbg_pdf=="AUTHOR"){
                    $input['no_author'] = "TIC-".$no_pendaftaran;
                } else {
                    $input['no_participan'] = "TIC-".$no_pendaftaran;
                    $input['id_event'] = $id_event;
                }
                $input['id_negara'] = $request->negara;
                $input['id_gelar'] = Helpers::dekrip($request->gelar);
                $input['nama_depan'] = $request->nama_depan;
                $input['nama_tengah'] = $request->nama_tengah;
                $input['nama_belakang'] = $request->nama_belakang;
                $input['jenis_kelamin'] = $request->jenis_kelamin;
                $input['tgl_lahir'] = $request->tgl_lahir;
                $input['pddk_terakhir'] = $request->pddk_terakhir;
                $input['institusi'] = $request->institusi;
                $input['research'] = $request->research;
                $input['email'] = $email;
                $input['alamat'] = $request->alamat;
                $input['kota'] = $request->kota;
                $input['kode_pos'] = $request->kode_pos;
                $input['no_hp'] = $request->no_hp;
                $input['no_fax'] = $request->no_fax;
                $input['orcid_id'] = $request->orcid_id;
                $input['informasi_lain'] = $request->informasi_lain;
                $input['password'] =sha1($password);
                $input['created_at'] = date('Y-m-d H:i:s');
                $stmt = false;
                if ($sbg_pdf=="AUTHOR"){
                    $stmt = TbAuthorModel::insertGetId($input);
                } else {
                    $stmt = TbParticipanModel::insertGetId($input);
                }
                if ($stmt){
                    if ($sbg_pdf=="AUTHOR"){
                        $where_no = array('no_author'=>$no_akhir);
                    } else {
                        $where_no = array('no_participan'=>$no_akhir);
                    }
                    TbNoModel::where('id_event',$id_event)->update($where_no);
                    return response()->json(['status' => 'OK', 'message' => 'Successfully Registered. Please check your email inbox or spam to get an account to enter the TIC application.. ']);
                } else {
                    return response()->json(['status' => 'ERROR', 'message' => 'Failed to save registration. Please try again...']);
                }
            } else {
                return response()->json(['status' => 'ERROR', 'message' => 'Failed to register. E-mail is unstable, please try again a few minutes later ...']);
            }
        }
    }

    public function jsonLoginAdmin(Request $request){
        $where['username'] = $where_3['email'] = $request->username;
        $where['del_flage'] = $where_3['del_flage'] = 0;
        $stmt_admin = TbAdminModel::where($where);
        $stmt_reviewer = TbReviewerModel::where($where_3);
        if ($stmt_admin->count() > 0 ){
            $where_2['username'] = $request->username;
            $where_2['password'] = sha1($request->password);
            $where_2['del_flage'] = 0;
            $stmt_admin_2 = TbAdminModel::where($where_2);
            if ($stmt_admin_2){
                if ($stmt_admin_2->count() > 0){
                    $dt = $stmt_admin_2->first();
                    $session['id_admin'] = $dt->id_admin;
                    $session['username'] = $dt->username;
                    $session['nama_admin'] = $dt->nama_admin;
                    $session['email'] = $dt->email;
                    $session['tic-admin'] = TRUE;
                    Session::put($session);
                    return response()->json(['status' => 'OK','data'=>array('url'=>url('/admin'))]);
                } else {
                    return response()->json(['status' => 'ERROR','message'=>"Wrong Password!!!"]);
                }
            } else {
                return response()->json(['status' => 'ERROR','message'=>"Terjadi Kesalahan. Silahkan Coba Lagi!!!"]);
            }
        } elseif ($stmt_reviewer->count() > 0 ){
            $where_3['email'] = $request->username;
            $where_3['password'] = sha1($request->password);
            $where_3['del_flage'] = 0;
            $stmt_reviewer_3 = TbReviewerModel::where($where_3);
            if ($stmt_reviewer_3){
                if ($stmt_reviewer_3->count() > 0){
                    $dt = $stmt_reviewer_3->first();
                    $session['id_reviewer'] = $dt->id_reviewer;
                    $session['foto_reviewer'] = $dt->foto_reviewer;
                    $session['email'] = $dt->email;
                    $session['nama_depan'] = $dt->nama_depan;
                    $session['nama_tengah'] = $dt->nama_tengah;
                    $session['nama_belakang'] = $dt->nama_belakang;
                    $session['jenis_kelamin'] = $dt->jenis_kelamin;
                    $session['tic-reviewer'] = TRUE;
                    Session::put($session);
                    return response()->json(['status' => 'OK','data'=>array('url'=>url('/reviewer'))]);
                } else {
                    return response()->json(['status' => 'ERROR','message'=>"Wrong Password!!!"]);
                }
            } else {
                return response()->json(['status' => 'ERROR','message'=>"Terjadi Kesalahan. Silahkan Coba Lagi!!!"]);
            }
        } else {
            return response()->json(['status' => 'ERROR','message'=>"Username not found!!!"]);
        }
    }
    public function jsonLogin(Request $request){
        $sbg = $request->sebagai;
        $where['email'] = $request->email;
        $where['del_flage'] = 0;
        $stmt = false;
        if ($sbg=="AUTHOR"){
            $stmt = TbAuthorModel::where($where);
        } else if ($sbg=="REVIEWER"){
            $stmt = TbReviewerModel::where($where);
        } else {
            $stmt = TbParticipanModel::where($where);
        }
        if ($stmt){
            if ($stmt->count() > 0 ){
                $stmt2 = false;
                $where2['email'] = $request->email;
                $where2['password'] = sha1($request->password);
                $where2['del_flage'] = 0;
                if ($sbg=="AUTHOR"){
                    $stmt2 = TbAuthorModel::where($where2);
                } else if ($sbg=="REVIEWER"){
                    $stmt2 = TbReviewerModel::where($where2);
                } else {
                    $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
                    $where2['id_event'] = $id_event;
                    $stmt2 = TbParticipanModel::where($where2);
                }
                if ($stmt2){
                    if ($stmt2->count() > 0){
                        $dt = $stmt2->first();
                        if ($sbg=="AUTHOR"){
                            $session['id_author'] = $dt->id_author;
                            $session['foto_author'] = $dt->foto_author;
                            $session['tic-author'] = TRUE;
                            $url = url('/author');
                        } else {
                            $session['id_participan'] = $dt->id_participan;
                            $session['foto_participan'] = $dt->foto_participan;
                            $session['tic-participan'] = TRUE;
                            $url = url('/participan');
                        }
                        if ($sbg == "AUTHOR" || $sbg == "PARTICIPAN"){
                            $session['orcid_id'] = $dt->orcid_id;
                            $session['institusi'] = $dt->institusi;
                        } else {
                            $session['id_reviewer'] = $dt->id_reviewer;
                            $session['foto_reviewer'] = $dt->foto_reviewer;
                            $session['jenis_kelamin'] = $dt->jenis_kelamin;
                            $session['tic-reviewer'] = TRUE;
                            $url = url('/reviewer');
                        }
                        $session['nama_depan'] = $dt->nama_depan;
                        $session['nama_tengah'] = $dt->nama_tengah;
                        $session['nama_belakang'] = $dt->nama_belakang;
                        $session['email'] = $dt->email;
                        Session::put($session);
                        return response()->json(['status' => 'OK','data'=>array('url'=>$url)]);
                    } else {
                        return response()->json(['status' => 'ERROR','message'=>"Wrong Password!!!"]);
                    }
                } else {
                    return response()->json(['status' => 'ERROR','message'=>"There is an error. Please Try Again !!!"]);
                }
            } else {
                return response()->json(['status' => 'ERROR','message'=>"E-mail not found!!!"]);
            }
        } else {
            return response()->json(['status' => 'ERROR','message'=>"There is an error. Please Try Again !!!"]);
        }
    }
    public function getNotifAdmin(){
        $stmt = TbNotifAdminModel::where(array('stt_view'=>0,'del_flage'=>0));
        $stmt2 = TbJurnalModel::where(array('stt_pembayaran_konfirmasi'=>"WAITING FOR CONFIRMATION",'del_flage'=>0));
        $stmt3 = TbParticipanModel::where(array('stt_pembayaran_konfirmasi'=>"WAITING FOR CONFIRMATION",'del_flage'=>0));
        $stmt4 = TbJurnalModel::where(array('stt_jurnal'=>"COMPLETED FOR A REVIEW",'del_flage'=>0));
        $stmt5 = TbJurnalModel::where(array('stt_jurnal'=>"ABSTRACT ACCEPTED",'del_flage'=>0));
        if ($stmt && $stmt2 && $stmt3 && $stmt4 && $stmt5){
            $data['status'] = "OK";
            $data['ttl_notif'] = $stmt->count();
            $data['ttl_payment_journal'] = $stmt2->count();
            $data['ttl_payment_participan'] = $stmt3->count();
            $data['ttl_journal_confirm'] = $stmt4->count();
            $data['ttl_journal_process'] = $stmt5->count();
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR",'message'=>"There is an error. Please Try Again !!!"]);
        }
    }
    public function updateNotifAdmin(Request $request){
        $update['stt_view'] = 1;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbNotifAdminModel::where('id_notif_admin',Helpers::dekrip($request->id))->update($update);
        if ($stmt){
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
        }
    }
    public function updateJournalReviewer(Request $request) {
        $where['no_abstrak'] = $no_abs = Helpers::dekrip($request->abs);
        $update['id_reviewer'] = $id_reviewer = Helpers::dekrip($request->reviewer);
        $stmt = TbJurnalModel::where($where)->update($update);
        if ($stmt){
            $input['judul'] = "ABSTRACT - Review.";
            $input['pesan'] = "You have been added to review the abstract ";
            $input['id_jurnal'] = TbJurnalModel::where('no_abstrak',$no_abs)->first()->id_jurnal;
            $input['id_reviewer'] = $id_reviewer;
            $input['stt_notif'] = "ABSTRACT";
            $input['created_at'] = date('Y-m-d H:i:s');
            TbNotifReviewerModel::insert($input);
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>"Failed To Save Data "]);
        }
    }
    public function updateRevisionAcc(Request $request){
        $no_abs = $request->no_abs;
        $update['stt_full_paper'] = "COPYEDITING";
        $update['stt_jurnal'] = "COPYEDITING";
        $update['stt_revisi_paper'] = "FILLED";
        $update['stt_progres_paper'] = "COPYEDITING";
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbJurnalModel::where('no_abstrak',$no_abs)->update($update);
        if ($stmt){
            $dt_jurnal = TbJurnalModel::where('no_abstrak',$no_abs)->first();
            $id_author_corresponding = $dt_jurnal->id_author_corresponding;
            if (empty($id_author_corresponding)){
                $id_author_corresponding = $dt_jurnal->id_author;
            }
            $input2['judul'] = "REVISION - The reviewer has given a review.";
            $input2['pesan'] = "Your journal has been reviewed by a reviewer and has been accepted. Congratulations. ";
            $input2['id_jurnal'] = $dt_jurnal->id_jurnal;
            $input2['id_author'] = $id_author_corresponding;
            $input2['stt_notif'] = "REVISION";
            $input2['created_at'] = date('Y-m-d H:i:s');
            TbNotifAuthorModel::insert($input2);
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>"Failed To Save Data "]);
        }
    }
    public function updatePaymentJournal(Request $request){
        $update['stt_pembayaran'] = "PAID";
        $update['stt_pembayaran_konfirmasi'] = "ACCEPTED";
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbJurnalModel::where('no_abstrak',$request->no_abs)->update($update);
        if ($stmt){
            $dt_jurnal = TbJurnalModel::where('no_abstrak',$request->no_abs)->first();
            $id_author_corresponding = $dt_jurnal->id_author_corresponding;
            if (empty($id_author_corresponding)){
                $id_author_corresponding = $dt_jurnal->id_author;
            }
            $input_notif['id_jurnal'] = $dt_jurnal->id_jurnal;
            $input_notif['id_author'] = $id_author_corresponding;
            $input_notif['judul'] = "Payment Confirmation";
            $input_notif['pesan'] = "Your abstract entitled <b>".$dt_jurnal->judul_jurnal."</b> - payment has been confirmed.";
            $input_notif['stt_notif'] = "JURNAL";
            $input_notif['created_at'] = date('Y-m-d H:i:s');
            TbNotifAuthorModel::insert($input_notif);
            return response()->json(['status' => 'OK']);
        } else {
            return response()->json(['status' => 'ERROR','message'=>"Failed to save data!!!"]);
        }
    }
    public function updatePaymentParticipan(Request $request){
        $update['stt_pembayaran'] = "PAID";
        $update['stt_pembayaran_konfirmasi'] = "ACCEPTED";
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbParticipanModel::where('no_participan',$request->no_participan)->update($update);
        if ($stmt){
            $dt_participan = TbParticipanModel::where('no_participan',$request->no_participan)->first();
            $input_notif['id_participan'] = $dt_participan->id_participan;
            $input_notif['judul'] = "Confirmation Payment Participan";
            $input_notif['pesan'] = "Participan payment has been confirmed.";
            $input_notif['stt_notif'] = "PAYMENT";
            $input_notif['created_at'] = date('Y-m-d H:i:s');
            TbNotifParticipanModel::insert($input_notif);
            return response()->json(['status' => 'OK']);
        } else {
            return response()->json(['status' => 'ERROR','message'=>"Failed to save data!!!"]);
        }
    }
    public function insertReviewers(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'gender' => 'required|string',
            'password' => 'required|string'
        ]);
        if (!$validator->fails()){
            $input['nama_depan'] = $request->first_name;
            $input['nama_tengah'] = $request->middle_name;
            $input['nama_belakang'] = $request->last_name;
            $input['password'] = sha1($request->password);
            $input['email'] = $request->email;
            $input['jenis_kelamin'] = $request->gender;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbReviewerModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR",'message'=>$error]);
        }
    }
    public function updateReviewers(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'middle_name' => 'string',
            'last_name' => 'required|string',
            'email' => 'required|string',
            'gender' => 'required|string',
        ]);
        if (!$validator->fails()){
            if (!empty($request->password)){
                $update['password'] = sha1($request->password);
            }
            $update['nama_depan'] = $request->first_name;
            $update['nama_tengah'] = $request->middle_name;
            $update['nama_belakang'] = $request->last_name;
            $update['email'] = $request->email;
            $update['jenis_kelamin'] = $request->gender;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbReviewerModel::where('id_reviewer',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR",'message'=>$error]);
        }
    }
    public function updateReviewersPhoto(Request $request){
        $data = $request->foto;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        $imageName = date('YmdHis').'.png';
        file_put_contents(public_path('upload/reviewer')."/".$imageName, $data);

        $update['foto_reviewer'] = $imageName;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbReviewerModel::where('id_reviewer',Helpers::dekrip($request->id))->update($update);
        if ($stmt){
            if (!empty($request->foto_lama)){
                File::delete(public_path("/upload/reviewer/".$request->foto_lama));
            }
            return response()->json(['status' => 'OK']);
        } else {
            return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
        }
    }
    public function insertCountry(Request $request){
        $validated = $request->validate([
            'negara' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if ($validated){
            $input['negara'] = $request->negara;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbNegaraModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            return response()->json(['status' => 'ERROR','message'=>$this->message_invalid_input]);
        }
    }
    public function updateCountry(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'country' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if (!$validator->fails()){
            $update['negara'] = $request->country;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbNegaraModel::where('id_negara',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR",'message'=>$error]);
        }
    }
    public function insertDegree(Request $request){
        $validated = $request->validate([
            'gelar' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if ($validated){
            $input['gelar'] = $request->gelar;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbGelarModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            return response()->json(['status' => 'ERROR','message'=>$this->message_invalid_input]);
        }
    }
    public function updateDegree(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'degree' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if (!$validator->fails()){
            $update['gelar'] = $request->degree;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbGelarModel::where('id_gelar',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR",'message'=>$error]);
        }
    }
    public function insertSosmed(Request $request){
        $validated = $request->validate([
            'icon' => 'required|string',
            'sosmed' => 'required|string',
            'link' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if ($validated){
            $input['icon'] = $request->icon;
            $input['sosmed'] = $request->sosmed;
            $input['link'] = $request->link;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbSosmedModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            return response()->json(['status' => 'ERROR','message'=>$this->message_invalid_input]);
        }
    }
    public function updateSosmed(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'icon' => 'required|string',
            'link' => 'required|string',
            'sosmed' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if (!$validator->fails()){
            $update['icon'] = $request->icon;
            $update['sosmed'] = $request->sosmed;
            $update['link'] = $request->link;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbSosmedModel::where('id_sosmed',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR",'message'=>$error]);
        }
    }
    public function insertContact(Request $request){
        $validated = $request->validate([
            'judul' => 'required|string',
            'icon' => 'required|string',
            'isi' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if ($validated){
            $input['icon'] = $request->icon;
            $input['judul'] = $request->judul;
            $input['isi'] = $request->isi;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbKontakModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            return response()->json(['status' => 'ERROR','message'=>$this->message_invalid_input]);
        }
    }
    public function updateContact(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'judul' => 'required|string',
            'icon' => 'required|string',
            'isi' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if (!$validator->fails()){
            $update['icon'] = $request->icon;
            $update['judul'] = $request->judul;
            $update['isi'] = $request->isi;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbKontakModel::where('id_kontak',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR",'message'=>$error]);
        }
    }
    public function updateEventActivate(Request $request){
        $validated = $request->validate([
            'id_event' => 'required|string'
        ]);
        if ($validated){
            $id_event = Helpers::dekrip($request->id_event);
            $update['stt_aktif'] = 1;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbEventModel::where('id_event',$id_event)->update($update);

            $update['stt_aktif'] = 0;
            $stmt2 = TbEventModel::where('id_event','!=',$id_event)->update($update);
            if ($stmt && $stmt2){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            return response()->json(['status' => 'ERROR','message'=>$this->message_invalid_input]);
        }
    }
    public function insertEvents(Request $request){
        $validated = $request->validate([
            'event' => 'required|string',
            'tahun_event' => 'required|numeric|digits_between:1,4',
        ]);
        if ($validated){
            $input['event'] = $request->event;
            $input['slug_event'] = Str::slug($request->event,'-');
            $input['stt_aktif'] = 1;
            $input['tahun_event'] = $request->tahun_event;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbEventModel::insertGetId($input);
            if ($stmt){
                $update['stt_aktif'] = 0;
                $update['updated_at'] = date('Y-m-d H:i:s');
                TbEventModel::where('id_event','!=',$stmt)->update($update);
                $input2['id_event'] = $stmt;
                $input2['created_at'] = date('Y-m-d H:i:s');
                TbSettingModel::insert($input2);
                TbNoModel::insert($input2);
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            return response()->json(['status' => 'ERROR','message'=>$this->message_invalid_input]);
        }
    }
    public function updateEvents(Request $request){
        $validated = $request->validate([
            'slug_event_old' => 'required|string',
            'event' => 'required|string',
            'tahun_event' => 'required|numeric|digits_between:1,4',
            'pamflet.*' => 'mimes:jpg,jpeg,png|max:3000'
        ]);
        if ($validated){
            $image = $request->file('pamflet');
            if (!empty($image)){
                $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/upload/event');

                $img = Image::make($image->getRealPath());
                $img->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/thumbnail/'.$file_name);
                $image->move($destinationPath,$file_name);
                $update['pamflet'] = $file_name;
            }
            $update['event'] = $request->event;
            $update['slug_event'] = Str::slug($request->event,'-');
            $update['tahun_event'] = $request->tahun_event;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbEventModel::where('slug_event',$request->slug_event_old)->update($update);
            if ($stmt){
                if (!empty($image)){
                    File::delete(public_path("/upload/event/".$request->pamflet_lama));
                    File::delete(public_path("/upload/event/thumbnail/".$request->pamflet_lama));
                }
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            return response()->json(['status' => 'ERROR','message'=>$this->message_invalid_input]);
        }
    }
    public function insertCoHost(Request $request){
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string',
            'nama' => 'required|string',
            'link' => 'required|string',
            'thumbnail' => 'required|mimes:jpg,jpeg,png|max:1000',
        ]);
        if (!$validator->fails()){
            $image = $request->file('thumbnail');
            $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/upload/co_host');
            $img = Image::make($image->getRealPath());
            $img->resize(720, 720, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$file_name);

            $id = TbEventModel::where('slug_event',Helpers::dekrip($request->kode))->first()->id_event;
            $input['id_event'] = $id;
            $input['thumbnail'] = $file_name;
            $input['nama'] = $request->nama;
            $input['link'] = $request->link;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbCoHostModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function updateCoHost(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'nama' => 'required|string',
            'link' => 'required|string',
            'thumbnail' => 'max:1000'
        ]);
        if (!$validator->fails()){
            $image = $request->file('thumbnail');
            if (!empty($image)){
                $image = $request->file('thumbnail');
                $ext = $image->getClientOriginalExtension();
                if ($ext=="jpg" || $ext=="jpeg" || $ext == "png"){
                    $file_name = date('YmdHis').'.'.$ext;

                    $destinationPath = public_path('/upload/co_host');
                    $img = Image::make($image->getRealPath());
                    $img->resize(720, 720, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.'/'.$file_name);
                    $update['thumbnail'] = $file_name;
                } else {
                    return response()->json(['status' => 'ERROR','message'=>"Only type file jpg, jpeg, and png"]);
                }
            }

            $update['nama'] = $request->nama;
            $update['link'] = $request->link;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbCoHostModel::where('id_cohost',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                if (!empty($image)){
                    File::delete(public_path("/upload/co_host/".$request->thumbnail_lama));
                }
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function insertIndexing(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'nama' => 'required|string',
            'link' => 'required|string',
            'logo' => 'required|mimes:jpg,jpeg,png|max:1000'
        ]);
        if (!$validator->fails()){
            $image = $request->file('logo');
            $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/upload/index');
            $img = Image::make($image->getRealPath());
            $img->resize(720, 720, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$file_name);

            $id = TbEventModel::where('slug_event',Helpers::dekrip($request->id))->first()->id_event;
            $input['id_event'] = $id;
            $input['logo'] = $file_name;
            $input['nama'] = $request->nama;
            $input['link'] = $request->link;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbIndexingModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function updateIndexing(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'nama' => 'required|string',
            'link' => 'required|string',
            'logo' => 'max:1000'
        ]);
        if (!$validator->fails()){
            $image = $request->file('logo');
            if (!empty($image)){
                $image = $request->file('logo');
                $ext = $image->getClientOriginalExtension();
                if ($ext=="jpg" || $ext=="jpeg" || $ext == "png"){
                    $file_name = date('YmdHis').'.'.$ext;

                    $destinationPath = public_path('/upload/index');
                    $img = Image::make($image->getRealPath());
                    $img->resize(720, 720, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.'/'.$file_name);
                    $update['logo'] = $file_name;
                } else {
                    return response()->json(['status' => 'ERROR','message'=>"Only type file jpg, jpeg, and png"]);
                }
            }

            $update['nama'] = $request->nama;
            $update['link'] = $request->link;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbIndexingModel::where('id_indexing',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                if (!empty($image)){
                    File::delete(public_path("/upload/index/".$request->logo_lama));
                }
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function insertTypePayment(Request $request){
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string',
            'jenis_pembayaran' => 'required|string',
            'nama_jenis_pembayaran' => 'required|string',
            'nomor_jenis_pembayaran' => 'required|string',
            'an_jenis_pembayaran' => 'required|string',
            'stt_data' => 'required|string',
            'logo_1' => 'required|mimes:jpg,jpeg,png|max:1000',
            'logo_2.*' => 'mimes:jpg,jpeg,png|max:1000',
            'logo_3.*' => 'mimes:jpg,jpeg,png|max:1000',
            'logo_4.*' => 'mimes:jpg,jpeg,png|max:1000',
            'logo_5.*' => 'mimes:jpg,jpeg,png|max:1000'
        ]);
        if (!$validator->fails()){
            $imageLogo1 = $request->file('logo_1');
            $imageLogo2 = $request->file('logo_2');
            $imageLogo3 = $request->file('logo_3');
            $imageLogo4 = $request->file('logo_4');
            $imageLogo5 = $request->file('logo_5');
            if (!empty($imageLogo1)){
                $imageLogo1 = $request->file('logo_1');
                $name_logo1 = date('YmdHis').'1.'.$imageLogo1->getClientOriginalExtension();

                $img_logo1 = Image::make($imageLogo1->getRealPath());
                $img_logo1->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/upload/jenis_pembayaran').'/'.$name_logo1);
                $input['logo_1'] = $name_logo1;
            }
            if (!empty($imageLogo2)){
                $imageLogo2 = $request->file('logo_2');
                $name_logo2 = date('YmdHis').'2.'.$imageLogo2->getClientOriginalExtension();

                $img_logo2 = Image::make($imageLogo2->getRealPath());
                $img_logo2->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/upload/jenis_pembayaran').'/'.$name_logo2);
                $input['logo_2'] = $name_logo2;
            }
            if (!empty($imageLogo3)){
                $imageLogo3 = $request->file('logo_3');
                $name_logo3 = date('YmdHis').'3.'.$imageLogo3->getClientOriginalExtension();

                $img_logo3 = Image::make($imageLogo3->getRealPath());
                $img_logo3->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/upload/jenis_pembayaran').'/'.$name_logo3);
                $input['logo_3'] = $name_logo3;
            }
            if (!empty($imageLogo4)){
                $imageLogo4 = $request->file('logo_4');
                $name_logo4 = date('YmdHis').'4.'.$imageLogo4->getClientOriginalExtension();

                $img_logo4 = Image::make($imageLogo4->getRealPath());
                $img_logo4->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/upload/jenis_pembayaran').'/'.$name_logo4);
                $input['logo_4'] = $name_logo4;
            }
            if (!empty($imageLogo5)){
                $imageLogo5 = $request->file('logo_5');
                $name_logo5 = date('YmdHis').'5.'.$imageLogo5->getClientOriginalExtension();

                $img_logo5 = Image::make($imageLogo5->getRealPath());
                $img_logo5->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/upload/jenis_pembayaran').'/'.$name_logo5);
                $input['logo_5'] = $name_logo5;
            }
            $id = TbEventModel::where('slug_event',Helpers::dekrip($request->kode))->first()->id_event;
            $input['id_event'] = $id;
            $input['jenis_pembayaran'] = $request->jenis_pembayaran;
            $input['nama_jenis_pembayaran'] = $request->nama_jenis_pembayaran;
            $input['nomor_jenis_pembayaran'] = $request->nomor_jenis_pembayaran;
            $input['an_jenis_pembayaran'] = $request->an_jenis_pembayaran;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbJenisPembayaranModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function updateTypePayment(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'jenis_pembayaran' => 'required|string',
            'nama_jenis_pembayaran' => 'required|string',
            'nomor_jenis_pembayaran' => 'required|string',
            'an_jenis_pembayaran' => 'required|string',
            'stt_data' => 'required|string',
            'logo_1.*' => 'mimes:jpg,jpeg,png|max:1000',
            'logo_2.*' => 'mimes:jpg,jpeg,png|max:1000',
            'logo_3.*' => 'mimes:jpg,jpeg,png|max:1000',
            'logo_4.*' => 'mimes:jpg,jpeg,png|max:1000',
            'logo_5.*' => 'mimes:jpg,jpeg,png|max:1000'
        ]);
        if (!$validator->fails()){
            $imageLogo1 = $request->file('logo_1');
            $imageLogo2 = $request->file('logo_2');
            $imageLogo3 = $request->file('logo_3');
            $imageLogo4 = $request->file('logo_4');
            $imageLogo5 = $request->file('logo_5');
            if (!empty($imageLogo1)){
                $imageLogo1 = $request->file('logo_1');
                $name_logo1 = date('YmdHis').'1.'.$imageLogo1->getClientOriginalExtension();

                $img_logo1 = Image::make($imageLogo1->getRealPath());
                $img_logo1->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/upload/jenis_pembayaran').'/'.$name_logo1);
                $update['logo_1'] = $name_logo1;
            }
            if (!empty($imageLogo2)){
                $imageLogo2 = $request->file('logo_2');
                $name_logo2 = date('YmdHis').'2.'.$imageLogo2->getClientOriginalExtension();

                $img_logo2 = Image::make($imageLogo2->getRealPath());
                $img_logo2->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/upload/jenis_pembayaran').'/'.$name_logo2);
                $update['logo_2'] = $name_logo2;
            }
            if (!empty($imageLogo3)){
                $imageLogo3 = $request->file('logo_3');
                $name_logo3 = date('YmdHis').'3.'.$imageLogo3->getClientOriginalExtension();

                $img_logo3 = Image::make($imageLogo3->getRealPath());
                $img_logo3->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/upload/jenis_pembayaran').'/'.$name_logo3);
                $update['logo_3'] = $name_logo3;
            }
            if (!empty($imageLogo4)){
                $imageLogo4 = $request->file('logo_4');
                $name_logo4 = date('YmdHis').'4.'.$imageLogo4->getClientOriginalExtension();

                $img_logo4 = Image::make($imageLogo4->getRealPath());
                $img_logo4->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/upload/jenis_pembayaran').'/'.$name_logo4);
                $update['logo_4'] = $name_logo4;
            }
            if (!empty($imageLogo5)){
                $imageLogo5 = $request->file('logo_5');
                $name_logo5 = date('YmdHis').'5.'.$imageLogo5->getClientOriginalExtension();

                $img_logo5 = Image::make($imageLogo5->getRealPath());
                $img_logo5->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('/upload/jenis_pembayaran').'/'.$name_logo5);
                $update['logo_5'] = $name_logo5;
            }
            $update['jenis_pembayaran'] = $request->jenis_pembayaran;
            $update['nama_jenis_pembayaran'] = $request->nama_jenis_pembayaran;
            $update['nomor_jenis_pembayaran'] = $request->nomor_jenis_pembayaran;
            $update['an_jenis_pembayaran'] = $request->an_jenis_pembayaran;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbJenisPembayaranModel::where('id_jenis_pembayaran',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                $logo_1_lama = $request->logo_1_lama;
                $logo_2_lama = $request->logo_2_lama;
                $logo_3_lama = $request->logo_3_lama;
                $logo_4_lama = $request->logo_4_lama;
                $logo_5_lama = $request->logo_5_lama;
                if (!empty($imageLogo1)){
                    File::delete(public_path("/upload/jenis_pembayaran/".$logo_1_lama));
                }
                if (!empty($imageLogo2)){
                    File::delete(public_path("/upload/jenis_pembayaran/".$logo_2_lama));
                }
                if (!empty($imageLogo3)){
                    File::delete(public_path("/upload/jenis_pembayaran/".$logo_3_lama));
                }
                if (!empty($imageLogo4)){
                    File::delete(public_path("/upload/jenis_pembayaran/".$logo_4_lama));
                }
                if (!empty($imageLogo5)){
                    File::delete(public_path("/upload/jenis_pembayaran/".$logo_5_lama));
                }
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function insertCollaboration(Request $request){
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string',
            'nama' => 'required|string',
            'link' => 'required|string',
            'stt_data' => 'required|string',
            'logo' => 'required',
            'logo.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);
        if (!$validator->fails()){
            $image = $request->file('logo');
            $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/upload/kerjasama');
            $img = Image::make($image->getRealPath());
            $img->resize(720, 720, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$file_name);

            $id = TbEventModel::where('slug_event',Helpers::dekrip($request->kode))->first()->id_event;
            $input['id_event'] = $id;
            $input['logo'] = $file_name;
            $input['nama'] = $request->nama;
            $input['link'] = $request->link;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbKerjaSamaModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function updateCollaboration(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'nama' => 'required|string',
            'link' => 'required|string',
            'stt_data' => 'required|string',
            'logo.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);
        if (!$validator->fails()){
            $image = $request->file('logo');
            if (!empty($image)){
                $image = $request->file('logo');
                $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/upload/kerjasama');
                $img = Image::make($image->getRealPath());
                $img->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$file_name);
                $update['logo'] = $file_name;
            }

            $update['nama'] = $request->nama;
            $update['link'] = $request->link;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbKerjaSamaModel::where('id_kerjasama',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                if (!empty($image)){
                    File::delete(public_path("/upload/kerjasama/".$request->logo_lama));
                }
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function insertKeynoteSpeaker(Request $request){
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string',
            'sub' => 'required|string',
            'nama' => 'required|string',
            'institusi' => 'required|string',
            'topik' => 'required|string',
            'stt_data' => 'required|string',
            'thumbnail' => 'required',
            'thumbnail.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);
        if (!$validator->fails()){
            $image = $request->file('thumbnail');
            $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/upload/keynote_speaker');
            $img = Image::make($image->getRealPath());
            $img->resize(720, 720, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$file_name);

            $id = TbEventModel::where('slug_event',Helpers::dekrip($request->kode))->first()->id_event;
            $input['id_event'] = $id;
            $input['thumbnail'] = $file_name;
            $input['id_sub'] = Helpers::dekrip($request->sub);
            $input['nama'] = $request->nama;
            $input['institusi'] = $request->institusi;
            $input['topik'] = $request->topik;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbKeynoteSpeakerModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function updateKeynoteSpeaker(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'sub' => 'required|string',
            'nama' => 'required|string',
            'institusi' => 'required|string',
            'topik' => 'required|string',
            'stt_data' => 'required|string',
            'thumbnail.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);
        if (!$validator->fails()){
            $image = $request->file('thumbnail');
            if (!empty($image)){
                $image = $request->file('thumbnail');
                $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/upload/keynote_speaker');
                $img = Image::make($image->getRealPath());
                $img->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$file_name);
                $update['thumbnail'] = $file_name;
            }

            $update['id_sub'] = Helpers::dekrip($request->sub);
            $update['nama'] = $request->nama;
            $update['institusi'] = $request->institusi;
            $update['topik'] = $request->topik;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbKeynoteSpeakerModel::where('id_keynote_speaker',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                if (!empty($image)){
                    File::delete(public_path("/upload/keynote_speaker/".$request->thumbnail_lama));
                }
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function insertInvitedSpeaker(Request $request){
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string',
            'nama' => 'required|string',
            'institusi' => 'required|string',
            'topik' => 'required|string',
            'stt_data' => 'required|string',
            'thumbnail' => 'required',
            'thumbnail.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);
        if (!$validator->fails()){
            $image = $request->file('thumbnail');
            $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/upload/invited_speaker');
            $img = Image::make($image->getRealPath());
            $img->resize(720, 720, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$file_name);

            $id = TbEventModel::where('slug_event',Helpers::dekrip($request->kode))->first()->id_event;
            $input['id_event'] = $id;
            $input['id_sub'] = Helpers::dekrip($request->sub);
            $input['thumbnail'] = $file_name;
            $input['nama'] = $request->nama;
            $input['institusi'] = $request->institusi;
            $input['topik'] = $request->topik;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbInvitedSpeakerModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function updateInvitedSpeaker(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'nama' => 'required|string',
            'institusi' => 'required|string',
            'topik' => 'required|string',
            'stt_data' => 'required|string',
            'thumbnail.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);
        if (!$validator->fails()){
            $image = $request->file('thumbnail');
            if (!empty($image)){
                $image = $request->file('thumbnail');
                $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/upload/invited_speaker');
                $img = Image::make($image->getRealPath());
                $img->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$file_name);
                $update['thumbnail'] = $file_name;
            }

            $update['id_sub'] = Helpers::dekrip($request->sub);
            $update['nama'] = $request->nama;
            $update['institusi'] = $request->institusi;
            $update['topik'] = $request->topik;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbInvitedSpeakerModel::where('id_invited_speaker',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                if (!empty($image)){
                    File::delete(public_path("/upload/invited_speaker/".$request->thumbnail_lama));
                }
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function updateSetting(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'key' => 'required|string',
            'deskripsi' => 'required|string'
        ]);
        if (!$validator->fails()){
            $update[$request->key] = $request->deskripsi;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbSettingModel::where('id_setting',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function updateSettingFoto(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'key' => 'required|string',
            'foto' => 'required',
            'foto.*' => 'mimes:jpg,jpeg,png|max:1000',
        ]);
        if (!$validator->fails()){
            $image = $request->file('foto');
            $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/upload/ttd');
            $img = Image::make($image->getRealPath());
            $img->resize(720, 720, function ($constraint) {
                $constraint->aspectRatio();
            })->greyscale()->save($destinationPath.'/'.$file_name);

            $update[$request->key] = $file_name;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbSettingModel::where('id_setting',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                if (!empty($request->foto_lama)){
                    File::delete(public_path("/upload/ttd/".$request->foto_lama));
                }
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function insertSub(Request $request){
        $validator = Validator::make($request->all(), [
            'kode' => 'required|string',
            'sub' => 'required|string',
            'deskripsi' => 'required|string',
            'stt_data' => 'required|string',
            'thumbnail' => 'required',
            'thumbnail.*' => 'mimes:jpg,jpeg,png|max:1000',
            'template.*' => 'mimes:doc,docx|max:1000',
        ]);
        if (!$validator->fails()){
            $image = $request->file('thumbnail');
            $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/upload/sub');
            $img = Image::make($image->getRealPath());
            $img->resize(1280, 1280, function ($constraint) {
                $constraint->aspectRatio();
            })->save($destinationPath.'/'.$file_name);


            $file_template = $request->file('template');
            if (!empty($file_template)) {
                $ext = $file_template->getClientOriginalExtension();
                $fileName_template = date('YmdHis').'.'.$ext;
                $destinationPath = public_path('/upload/sub/template');
                $file_template->move($destinationPath, $fileName_template);
                $input['template'] = $fileName_template;
            }

            $id = TbEventModel::where('slug_event',Helpers::dekrip($request->kode))->first()->id_event;
            $input['id_event'] = $id;
            $input['thumbnail'] = $file_name;
            $input['sub'] = $request->sub;
            $input['slug'] = Str::slug($request->sub,'-');
            $input['deskripsi'] = $request->deskripsi;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbSubModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function updateSub(Request $request){
         $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'sub' => 'required|string',
            'deskripsi' => 'required|string',
            'stt_data' => 'required|string',
            'thumbnail.*' => 'mimes:jpg,jpeg,png|max:1000',
            'template.*' => 'mimes:doc,docx|max:1000',
        ]);
        if (!$validator->fails()){
            $image = $request->file('thumbnail');
            if (!empty($image)){
                $image = $request->file('thumbnail');
                $file_name = date('YmdHis').'.'.$image->getClientOriginalExtension();

                $destinationPath = public_path('/upload/sub');
                $img = Image::make($image->getRealPath());
                $img->resize(1280, 1280, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$file_name);
                $update['thumbnail'] = $file_name;
            }
            $file_template = $request->file('template');
            if (!empty($file_template)) {
                $ext = $file_template->getClientOriginalExtension();
                $fileName_template = date('YmdHis').'.'.$ext;
                $destinationPath = public_path('/upload/sub/template');
                $file_template->move($destinationPath, $fileName_template);
                $update['template'] = $fileName_template;
            }

            $update['sub'] = $request->sub;
            $update['slug'] = Str::slug($request->sub,'-');
            $update['deskripsi'] = $request->deskripsi;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbSubModel::where('id_sub',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                if (!empty($image)){
                    File::delete(public_path("/upload/sub/".$request->thumbnail_lama));
                }
                if (!empty($file_template)){
                    File::delete(public_path("/upload/sub/template/".$request->template_lama));
                }
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function insertScope(Request $request){
         $validator = Validator::make($request->all(), [
            'sub' => 'required|string',
            'scope' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if (!$validator->fails()){
            $input['id_sub'] = Helpers::dekrip($request->sub);
            $input['scope'] = $request->scope;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbScopeModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }

    public function updateScope(Request $request){
         $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'sub' => 'required|string',
            'scope' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if (!$validator->fails()){
            $update['id_sub'] = Helpers::dekrip($request->sub);
            $update['scope'] = $request->scope;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbScopeModel::where('id_scope',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function insertVC(Request $request){
         $validator = Validator::make($request->all(), [
            'sub' => 'required|string',
            'vc' => 'required|string',
            'icon' => 'required|string',
            'link' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if (!$validator->fails()){
            $input['id_sub'] = Helpers::dekrip($request->sub);
            $input['vc'] = $request->vc;
            $input['icon'] = $request->icon;
            $input['link'] = $request->link;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbVCModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function updateVC(Request $request){
         $validator = Validator::make($request->all(), [
            'sub' => 'required|string',
            'vc' => 'required|string',
            'icon' => 'required|string',
            'link' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if (!$validator->fails()){
            $update['id_sub'] = Helpers::dekrip($request->sub);
            $update['vc'] = $request->vc;
            $update['icon'] = $request->icon;
            $update['link'] = $request->link;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbVCModel::where('id_vc',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function insertTimeline(Request $request){
         $validator = Validator::make($request->all(), [
            'kode' => 'required|string',
            'timeline' => 'required|string',
            'date' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if (!$validator->fails()){
            $input['id_event'] = TbEventModel::where('slug_event',Helpers::dekrip($request->kode))->first()->id_event;
            $input['timeline'] = $request->timeline;
            $input['date'] = $request->date;
            $input['stt_data'] = $request->stt_data;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbTimelineModel::insert($input);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function updateTimeline(Request $request){
         $validator = Validator::make($request->all(), [
            'timeline' => 'required|string',
            'date' => 'required|string',
            'stt_data' => 'required|string',
        ]);
        if (!$validator->fails()){
            $update['timeline'] = $request->timeline;
            $update['date'] = $request->date;
            $update['stt_data'] = $request->stt_data;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbTimelineModel::where('id_timeline',Helpers::dekrip($request->id))->update($update);
            if ($stmt){
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function updateAccount(Request $request){
         $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'nama_admin' => 'required|string',
            'email' => 'required|string|email',
        ]);
        if (!$validator->fails()){
            $update['nama_admin'] = $request->nama_admin;
            $update['username'] = $request->username;
            $update['email'] = $request->email;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbAdminModel::where('id_admin',Session::get('id_admin'))->update($update);
            if ($stmt){
                Session::put($update);
                return response()->json(['status' => 'OK']);
            } else {
                return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function updateAccountPassword(Request $request){
         $validator = Validator::make($request->all(), [
            'password_lama' => 'required|string',
            'password_baru' => 'required|string',
        ]);
        if (!$validator->fails()){
            $ck = TbAdminModel::where('id_admin',Session::get('id_admin'))->first();
            if ($ck->password == sha1($request->password_lama)){
                $update['password'] = sha1($request->password_lama);
                $update['updated_at'] = date('Y-m-d H:i:s');
                $stmt = TbAdminModel::where('id_admin',Session::get('id_admin'))->update($update);
                if ($stmt){
                    return response()->json(['status' => 'OK']);
                } else {
                    return response()->json(['status' => 'ERROR','message'=>$this->message_failed_save]);
                }
            } else {
                return response()->json(['status' => 'ERROR','message'=>"Wrong old password"]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
}
