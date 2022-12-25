<?php


namespace App\Http\Controllers;


use App\Helpers\Helpers;
use App\Models\TbAuthorModel;
use App\Models\TbEventModel;
use App\Models\TbJenisPembayaranModel;
use App\Models\TbJurnalAuthorModel;
use App\Models\TbJurnalModel;
use App\Models\TbJurnalPendukungModel;
use App\Models\TbJurnalRevisiModel;
use App\Models\TbKontakModel;
use App\Models\TbNoModel;
use App\Models\TbNotifAdminModel;
use App\Models\TbNotifAuthorModel;
use App\Models\TbNotifReviewerModel;
use App\Models\TbSettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ApiAuthor
{
    private $message_invalid_input = "The data you have entered is invalid!!!";
    private $message_failed_save = "Failed To Save Data...";
    private $message_failed_get = "Failed To Get Data...";

    public function getNotifAuthor(){
        $stmt = TbNotifAuthorModel::where(array('stt_view'=>0,'del_flage'=>0,'id_author'=>Session::get('id_author')));
        if ($stmt){
            return response()->json(['status' => "OK",'total'=>$stmt->count()]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }
    public function updateNotifAuthor(Request $request){
        $update['stt_view'] = 1;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbNotifAuthorModel::where('id_notif_author',Helpers::dekrip($request->id))->update($update);
        if ($stmt){
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
        }
    }
    public function insertMyJournal(Request $request){
        $full_paper_file = $request->file('full_paper');
        if (!empty($full_paper_file)){
            $full_paper_ext = $request->file('full_paper')->extension();
            $full_paper_fileName = date('YmdHis').'.'.$full_paper_ext;
            $request->file('full_paper')->move(public_path('upload/jurnal'), $full_paper_fileName);
            $input['file_nama'] = $full_paper_fileName;
        }
        $stmt_event = TbEventModel::where('stt_aktif',1)->first();
        $no = TbNoModel::where('id_event',$stmt_event->id_event)->first()->no_abs;
        $no_akhir = (int)$no+1;
        if (strlen($no_akhir)==1){
            $no = "00".$no_akhir;
        } else if (strlen($no_akhir)==2){
            $no = "0".$no_akhir;
        } else {
            $no = $no_akhir;
        }
        $eventModel = TbEventModel::where('stt_aktif',1)->first();
        $kontak_nomor = "";
        $kontak = TbKontakModel::where('judul',"Whatsapp");
        if ($kontak->count() > 0) {
            $kontak_nomor = $kontak->first()->isi;
        }
        $input['no_abstrak'] = "TIC-3".substr($eventModel->tahun_event,2,2).$no;
        $input['id_author'] = Session::get('id_author');
        $input['id_scope'] = $request->scope;
        $input['id_event'] = $eventModel->id_event;
        $input['judul_jurnal'] = $request->title;
        $input['abstrak_jurnal'] = $request->abstrac;
        $input['keyword_jurnal'] = $request->keyword;
        $input['slug_jurnal'] = Str::slug($request->title,'-');
        $input['stt_jurnal'] = $request->stt_journal;
        $input['created_at'] = date('Y-m-d H:i:s');
        $stmt = TbJurnalModel::insertGetId($input);
        if ($stmt) {
            $id_corresponding = 0;
            $first_name = $request->first_name;
            $midle_name = $request->midle_name;
            $last_name = $request->last_name;
            $email = $request->email;
            $corresponding = $request->corresponding;
            $orcid_id = $request->orcid_id;
            $country = $request->country;
            $institution = $request->institution;
            $bio = $request->bio;
            $id_jurnal_author = 0;
            foreach($first_name as $key => $item) {
                if ($email[$key] != Session::get('email')){
                    if ($corresponding == $email[$key]) {
                        $no_atr = TbNoModel::where('id_event',$stmt_event->id_event)->first()->no_author;
                        $no_akhir_atr = (int)$no_atr+1;
                        if (strlen($no_akhir_atr)==1){$no_atr = "00".$no_akhir_atr;}
                        else if (strlen($no_akhir_atr)==2){$no_atr = "0".$no_akhir_atr;}
                        else {$no_atr = $no_akhir_atr;}
                        $ck_metadata = TbAuthorModel::where('email',$email[$key]);
                        if ($ck_metadata->count() > 0) {
                            $input_2['id_author'] = $ck_metadata->first()->id_author;
                            $id_corresponding = $ck_metadata->first()->id_author;
                        } else {
                            $password = Helpers::getRandomPassword();
                            $input_author['no_author'] = "TIC-1".date('y').$no_atr;
                            $input_author['nama_depan'] = $first_name[$key];
                            $input_author['nama_tengah'] = $midle_name[$key];
                            $input_author['nama_belakang'] = $last_name[$key];
                            $input_author['institusi'] = $institution[$key];
                            $input_author['orcid_id'] = $orcid_id[$key];
                            $input_author['email'] = $email[$key];
                            $input_author['id_negara'] = $country[$key];
                            $input_author['password'] =sha1($password);
                            $input_author['created_at'] = date('Y-m-d H:i:s');
                            $stmt_atr = TbAuthorModel::insertGetId($input_author);
                            if ($stmt_atr){
                                $to_name = $first_name[$key]." ".$midle_name[$key]." ".$last_name[$key];
                                $to_email = $email[$key];
                                $to_body = 'Someone has added you as the corresponding at the Tegal International Conference event .<br/>Please login using :<br/>
                                            E-mail: '.$to_email.'<br/>Password: '.$password.'<br/>
                                            Official Website https://tic.poltektegal.ac.id/<br/><br/>
                                            Use Mozilla Firefox/Chrome/Safari browser for best performance of the conference system.<br/><br/>
                                            Best Regards,<br/>
                                            Organizing Committee TIC-MS 2022 Conference<br/>Politeknik Harapan Bersama<br/>
                                            Kampus 1: Jl. Mataram No. 9 Tegal, Indonesia<br/>Kampus 2: Jl. Dewi Sartika No. 71 Tegal, Indonesia<br/>
                                            Email     : tic@poltektegal.ac.id<br/>
                                            Website : https://tic.poltektegal.ac.id/<br/>
                                            CP         : '.$kontak_nomor;
                                $data = array('name'=>$email[$key], "body" => $to_body);
                                Mail::send('other.mail', $data, function($message) use ($to_name, $to_email) {
                                    $message->to($to_email, $to_name)
                                        ->subject('TIC Politeknik Harapan Bersama');
                                    $message->from('tic@poltektegal.ac.id','TIC Politeknik Harapan Bersama');
                                });
                                TbNoModel::where('id_event',$stmt_event->id_event)->update(array('no_author'=>$no_akhir_atr));
                                $input_2['id_author'] = $stmt_atr;
                                $id_corresponding = $stmt_atr;
                            }
                        }
                    }
                } else {
                    $input_2['id_author'] = Session::get('id_author');
                    $id_corresponding = Session::get('id_author');
                }
                $input_2['id_jurnal'] = $stmt;
                $input_2['nama_depan'] = $first_name[$key];
                $input_2['nama_tengah'] = $midle_name[$key];
                $input_2['nama_belakang'] = $last_name[$key];
                $input_2['email'] = $email[$key];
                $input_2['orcid_id'] = $orcid_id[$key];
                $input_2['id_negara'] = $country[$key];
                $input_2['institusi'] = $institution[$key];
                $input_2['biodata'] = $bio[$key];
                $stmt_jurnal_author = TbJurnalAuthorModel::insertGetId($input_2);
                if ($email[$key]==$corresponding) {
                    $id_jurnal_author = $stmt_jurnal_author;
                }
            }
            $document_name = $request->document_name;
            $files = $request->file('document_file');
            if (!empty($files)){
                foreach($files as $key_2 => $file_2) {
                    $ext = $file_2->extension();
                    $fileName = date('YmdHis').$key_2.'.'.$ext;
                    $destinationPath = public_path('upload/jurnal_pendukung');
                    if (strtolower($ext)=="jpg"||strtolower($ext)=="jpeg"||strtolower($ext)=="png"){
                        $img = Image::make($file_2->getRealPath());
                        $img->resize(720, 720, function ($constraint) {
                            $constraint->aspectRatio();
                        })->save($destinationPath."/".$fileName);
                    } else {
                        $file_2->move($destinationPath, $fileName);
                    }
                    $input_3['id_jurnal'] = $stmt;
                    $input_3['file_nama'] = $document_name[$key_2];
                    $input_3['file_pendukung'] = $fileName;
                    $input_3['file_tipe'] = strtolower($ext);
                    TbJurnalPendukungModel::insert($input_3);
                }
            }
            if ($request->stt_journal=="COMPLETED FOR A REVIEW"){
                $input_notif['id_jurnal'] = $stmt;
                $input_notif['judul'] = "JOURNAL - New journal";
                $input_notif['pesan'] = "There is a new journal with the title <b>".strtoupper($request->title)."</b> uploaded by the author, please check it.";
                $input_notif['stt_user'] = "ALL";
                $input_notif['stt_notif'] = "JURNAL";
                $input_notif['created_at'] = date('Y-m-d H:i:s');
                TbNotifAdminModel::insert($input_notif);
            }
            TbJurnalModel::where('id_jurnal',$stmt)->update(array('id_jurnal_author'=>$id_jurnal_author,'id_author_corresponding'=>$id_corresponding));
            TbNoModel::where('id_event',$stmt_event->id_event)->update(array('no_abs'=>$no_akhir));
            return response()->json(['status' => "OK",'message'=>"Please check email if you choose corresponding from metadata name that is not registered in TIC account get password to login in TIC"]);
        } else {
            return response()->json(['status' => "OK",'message'=>"Failed To Save Data"]);
        }
    }
    public function detailMyJournal(Request $request){
        $stmt_jurnal = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_jenis_pembayaran.jenis_pembayaran','tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang','tb_sub.sub','tb_sub.template')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_jenis_pembayaran','tb_jenis_pembayaran.id_jenis_pembayaran','=','tb_jurnal.id_jenis_pembayaran','left')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author_corresponding','left')
            ->latest('tb_jurnal.id_jurnal')
            ->where('tb_jurnal.no_abstrak',$request->no_abs);
        $stmt_metadata = TbJurnalAuthorModel::select('tb_jurnal_author.*','tb_negara.negara')
            ->join('tb_negara','tb_negara.id_negara','=','tb_jurnal_author.id_negara')
            ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_author.id_jurnal')
            ->where(array('tb_jurnal.no_abstrak'=>$request->no_abs,'tb_jurnal_author.del_flage'=>0));
        $stmt_suplementari = TbJurnalPendukungModel::select('tb_jurnal_pendukung.*')
            ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_pendukung.id_jurnal')
            ->where(array('tb_jurnal.no_abstrak'=>$request->no_abs,'tb_jurnal_pendukung.del_flage'=>0));
        $stmt_author = TbJurnalAuthorModel::select('tb_jurnal_author.*')
            ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_author.id_jurnal')
            ->where(array('tb_jurnal.no_abstrak'=>$request->no_abs,'tb_jurnal_author.del_flage'=>0));
        $stmt_setting = TbSettingModel::select('tb_setting.*')
            ->join('tb_event','tb_event.id_event','=','tb_setting.id_event')
            ->where(array('tb_event.stt_aktif'=>1));
        if ($stmt_jurnal && $stmt_metadata && $stmt_suplementari && $stmt_author && $stmt_setting){
            $data_journal = $stmt_jurnal->first();
            $data['data_journal'] = $data_journal;
            $data['data_journal']['id_jenis_pembayaran'] = Helpers::enkrip($data_journal->id_jenis_pembayaran);
            $data['data_journal']['id_jurnal'] = Helpers::enkrip($data_journal->id_jurnal);
            $data['data_journal']['id_event'] = Helpers::enkrip($data_journal->id_event);
            $data['data_journal']['id_scope'] = Helpers::enkrip($data_journal->id_scope);
            $data['data_journal']['id_jurnal'] = Helpers::enkrip($data_journal->id_jurnal);
            $data['data_journal']['id_event'] = Helpers::enkrip($data_journal->id_event);
            $data['data_journal']['id_scope'] = Helpers::enkrip($data_journal->id_scope);
            $data['data_journal']['id_author'] = Helpers::enkrip($data_journal->id_author);
            $data['data_journal']['id_jurnal_author'] = Helpers::enkrip($data_journal->id_jurnal_author);
            $data['data_journal']['id_author_corresponding'] = Helpers::enkrip($data_journal->id_author_corresponding);
            $data['data_journal']['id_reviewer'] = Helpers::enkrip($data_journal->id_reviewer);

            $data['data_metadata'] = $stmt_metadata->get();
            $data['data_suplementari'] = $stmt_suplementari->get();

            $data_author = $stmt_author->get();
            $stmt_author = array();
            foreach ($data_author as $key => $item){
                $stmt_author[$key]['id_jurnal_author'] = Helpers::enkrip($item->id_jurnal_author);
                $stmt_author[$key]['nama_depan'] = $item->nama_depan;
                $stmt_author[$key]['nama_tengah'] = $item->nama_tengah;
                $stmt_author[$key]['nama_belakang'] = $item->nama_belakang;
            }
            $data['data_author'] = $stmt_author;
            $data['data_setting'] = $stmt_setting->first();

            $data['status'] = "OK";
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>"Failed To Display Data "]);
        }
    }
    public function updateMyJournal(Request $request){
        $update['judul_jurnal'] = $request->title;
        $update['abstrak_jurnal'] = $request->abstrac;
        $update['keyword_jurnal'] = $request->keyword;
        $update['stt_jurnal'] = $request->stt_journal;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbJurnalModel::where('no_abstrak',$request->no_abs)->update($update);
        if ($stmt){
            if ($request->stt_journal=="COMPLETED FOR A REVIEW"){
                TbJurnalModel::where('no_abstrak',$request->no_abs)->update(array('created_at'=>date('Y-m-d H:i:s')));
                
                $input_notif['id_jurnal'] = TbJurnalModel::where('no_abstrak',$request->no_abs)->first()->id_jurnal;
                $input_notif['judul'] = "JOURNAL - New journal";
                $input_notif['pesan'] = "There is a new journal with the title <b>".strtoupper($request->title)."</b> uploaded by the author, please check it.";
                $input_notif['stt_user'] = "ALL";
                $input_notif['stt_notif'] = "JURNAL";
                $input_notif['created_at'] = date('Y-m-d H:i:s');
                TbNotifAdminModel::insert($input_notif);
            }
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>"Failed To Change Data "]);
        }
    }
    public function updateMyJournalPaperUpload(Request $request){
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:doc,docx|max:3000',
        ]);
        $no_abstrak = Helpers::dekrip($request->kode);
        if (!$validator->fails()){
            $image = $request->file('file');
            $imageName = date('YmdHis').'.'. $image->extension();
            $image->move(public_path('upload/jurnal'), $imageName);

            $dt_jurnal = TbJurnalModel::where('no_abstrak',$no_abstrak)->first();
            $update['file_nama'] = $imageName;
            $update['stt_full_paper'] = "EMPTY";
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbJurnalModel::where('no_abstrak',$no_abstrak)->update($update);
            if ($stmt){
                if (!empty($dt_jurnal->file_nama)){
                    File::delete(public_path("/upload/jurnal/".$dt_jurnal->file_nama));
                }
                $input2['judul'] = "JOURNAL - Full journal";
                $input2['pesan'] = "Someone uploaded a complete journal file, please give a review.";
                $input2['id_jurnal'] = $dt_jurnal->id_jurnal;
                $input2['stt_user'] = "ALL";
                $input2['stt_notif'] = "REVISION";
                $input2['created_at'] = date('Y-m-d H:i:s');
                TbNotifAdminModel::insert($input2);
                return response()->json(['status' => "OK"]);
            } else {
                return response()->json(['status' => "ERROR", 'message' => $this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function updateMyJournalMetadata(Request $request){
        $stmt = false;
        $stmt2 = true;
        $stmt3 = true;
        $first_name_old = $request->first_name_old;
        $midle_name_old = $request->midle_name_old;
        $last_name_old = $request->last_name_old;
        $email_old = $request->email_old;
        $orcid_id_old = $request->orcid_id_old;
        $country_old = $request->country_old;
        $institution_old = $request->institution_old;
        $bio_old = $request->bio_old;
        $id_old = $request->id_old;
        foreach($first_name_old as $key => $item) {
            $where['id_jurnal_author'] = $id_old[$key];
            $update['nama_depan'] = $first_name_old[$key];
            $update['nama_tengah'] = $midle_name_old[$key];
            $update['nama_belakang'] = $last_name_old[$key];
            $update['email'] = $email_old[$key];
            $update['orcid_id'] = $orcid_id_old[$key];
            $update['id_negara'] = $country_old[$key];
            $update['institusi'] = $institution_old[$key];
            $update['biodata'] = $bio_old[$key];
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbJurnalAuthorModel::where($where)->update($update);
        }
        $delete_old = $request->delete_old;
        if (!empty($delete_old) AND count($request->delete_old) > 0) {
            foreach ($delete_old as $item) {
                $where2['id_jurnal_author'] = $item;
                $update2['del_flage'] = 1;
                $stmt2 = TbJurnalAuthorModel::where($where2)->update($update2);
                if ($stmt2) {
                    $stmt2 = true;
                } else {
                    $stmt2 = false;
                }
            }
        }
        $first_name = $request->first_name;
        if (count($first_name) > 0 && !empty($first_name[0])) {
            $midle_name = $request->midle_name;
            $last_name = $request->last_name;
            $email = $request->email;
            $orcid_id = $request->orcid_id;
            $country = $request->country;
            $institution = $request->institution;
            $bio = $request->bio;
            $id_abs = TbJurnalModel::select('id_jurnal')->where(array('no_abstrak'=>$request->no_abs))->first()->id_jurnal;
            foreach($first_name as $key => $item) {
                $input_2['id_author'] = Session::get('id_author');
                $input_2['id_jurnal'] = $id_abs;
                $input_2['nama_depan'] = $first_name[$key];
                $input_2['nama_tengah'] = $midle_name[$key];
                $input_2['nama_belakang'] = $last_name[$key];
                $input_2['email'] = $email[$key];
                $input_2['orcid_id'] = $orcid_id[$key];
                $input_2['id_negara'] = $country[$key];
                $input_2['institusi'] = $institution[$key];
                $input_2['biodata'] = $bio[$key];
                $stmt3 = $stmt_jurnal_author = TbJurnalAuthorModel::insert($input_2);
                if ($stmt3) {
                    $stmt3 = true;
                } else {
                    $stmt3 = false;
                }
            }
        }
        if ($stmt && $stmt2 && $stmt3){
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>"Failed To Change Data "]);
        }
    }
    public function updateMyJournalPayment(Request $request){
        $validator = Validator::make($request->all(), [
            'bank_name' => 'required',
            'account_holder' => 'required',
            'pembayaran_invoice' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png|max:1000',
        ]);
        if (!$validator->fails()){
            $file_payment = $request->file('file');
            $ext = $file_payment->getClientOriginalExtension();
            $fileName = date('YmdHis').'.'.$ext;
            $destinationPath = public_path('/upload/pembayaran');

            if (strtolower($ext) == "pdf"){
                $file_payment->move($destinationPath, $fileName);
            } else {
                $img = Image::make($file_payment->getRealPath());
                $img->resize(720, 720, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($destinationPath.'/'.$fileName);
            }

            $update['file_pembayaran'] = $fileName;
            $update['tipe_pembayaran'] = $ext;
            $update['id_jenis_pembayaran'] = Helpers::dekrip($request->id);
            $update['pembayaran_bank'] = $request->bank_name;
            $update['pembayaran_an'] = $request->account_holder;
            $update['pembayaran_invoice'] = $request->pembayaran_invoice;
            $update['stt_pembayaran_konfirmasi'] = "WAITING FOR CONFIRMATION";
            $update['stt_pembayaran_date_upload'] = date('Y-m-d H:i:s');
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbJurnalModel::where('no_abstrak',$request->no_abs)->update($update);
            if ($stmt){
                $ft_lama = $request->file_pembayaran;
                if ($ft_lama != "0"){
                    File::delete(public_path("/upload/pembayaran/".$ft_lama));
                }
                $dt_jurnal = TbJurnalModel::where('no_abstrak',$request->no_abs)->first();
                $input3['judul'] = "PAYMENT - Payment upload.";
                $input3['pesan'] = "The user has uploaded proof of payment transfer. Please check to confirm payment.";
                $input3['id_jurnal'] = $dt_jurnal->id_jurnal;
                $input3['stt_user'] = "ADMIN";
                $input3['stt_notif'] = "PAYMENT";
                $input3['created_at'] = date('Y-m-d H:i:s');
                TbNotifAdminModel::insert($input3);
                return response()->json(['status' => "OK"]);
            } else {
                return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR",'message'=>$error]);
        }
    }
    public function updateMyJournalVideo(Request $request){
        $update['link_video'] = $request->link_video;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbJurnalModel::where('no_abstrak',$request->no_abs)->update($update);
        if ($stmt){
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
        }
    }
    public function getTypePayment(){
        $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
        $stmt = TbJenisPembayaranModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0,'id_event'=>$id_event));
        if ($stmt){
            $stmt_data = array();
            foreach ($stmt->get() as $key => $item){
                $stmt_data[$key]['id_jenis_pembayaran'] = Helpers::enkrip($item->id_jenis_pembayaran);
                $stmt_data[$key]['jenis_pembayaran'] = $item->jenis_pembayaran;
                $stmt_data[$key]['nama_jenis_pembayaran'] = $item->nama_jenis_pembayaran;
                $stmt_data[$key]['nomor_jenis_pembayaran'] = $item->nomor_jenis_pembayaran;
                $stmt_data[$key]['an_jenis_pembayaran'] = $item->an_jenis_pembayaran;
                $stmt_data[$key]['logo_1'] = $item->logo_1;
                $stmt_data[$key]['logo_2'] = $item->logo_2;
                $stmt_data[$key]['logo_3'] = $item->logo_3;
                $stmt_data[$key]['logo_4'] = $item->logo_4;
                $stmt_data[$key]['logo_5'] = $item->logo_5;
            }


            $data['data'] = $stmt_data;
            $data['status'] = "OK";
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }
    public function updateRevisionAuthor(Request $request){
        $file = $request->file('file');
        $fileName = date('YmdHis').'.'. $file->extension();
        $file->move(public_path('upload/jurnal_revisi'), $fileName);
        copy(public_path('upload/jurnal_revisi/').$fileName, public_path('upload/jurnal/').$fileName);

        $dt_jurnal = TbJurnalModel::where('no_abstrak',$request->no_abs)->first();
        $update['file_revisi_author'] = $fileName;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $id = Helpers::dekrip($request->id);
        $stmt = TbJurnalRevisiModel::where('id_jurnal_revisi',$id)->update($update);
        if ($stmt){
            if (!empty($dt_jurnal->file_nama)){
                File::delete(public_path("/upload/jurnal/".$dt_jurnal->file_nama));
            }
            $update2['file_nama'] = $fileName;
            $update2['stt_revisi_paper'] = "FILLED";
            $update2['updated_at'] = date('Y-m-d H:i:s');
            TbJurnalModel::where('no_abstrak',$request->no_abs)->update($update2);

            $input3['judul'] = "REVISION - Revision upload.";
            $input3['pesan'] = "The author has uploaded a new revision.";
            $input3['id_jurnal'] = $dt_jurnal->id_jurnal;
            $input3['id_reviewer'] = $dt_jurnal->id_reviewer;
            $input3['stt_notif'] = "REVISION";
            $input3['created_at'] = date('Y-m-d H:i:s');
            TbNotifReviewerModel::insert($input3);
            return response()->json(['success' => $fileName,'ID'=>$id]);
        } else {
            return response()->json(['error' => "ERROR"]);
        }
    }
    public function getAccountAuthor(){
        $stmt = TbAuthorModel::select('tb_author.*','tb_gelar.gelar','tb_negara.negara')
            ->join('tb_gelar','tb_gelar.id_gelar','=','tb_author.id_gelar','LEFT')
            ->join('tb_negara','tb_negara.id_negara','=','tb_author.id_negara','LEFT')
            ->where('tb_author.id_author',Session::get('id_author'));
        if ($stmt){
            return response()->json(['status' => "OK", 'data' => $stmt->first()]);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>$this->message_failed_get]);
        }
    }
    public function updateAccountAuthor(Request $request){
        $update['id_negara'] = Helpers::dekrip($request->country);
        $update['id_gelar'] = Helpers::dekrip($request->bachelor_degree);
        $update['nama_depan'] = $request->first_name;
        $update['nama_tengah'] = $request->middle_name;
        $update['nama_belakang'] = $request->last_name;
        $update['jenis_kelamin'] = $request->sex;
        $update['tgl_lahir'] = $request->birthday;
        $update['pddk_terakhir'] = $request->last_education;
        $update['email'] = $request->email;
        $update['no_hp'] = $request->phone_number;
        $update['no_fax'] = $request->fax_number;
        $update['alamat'] = $request->address;
        $update['kota'] = $request->city;
        $update['institusi'] = $request->institution;
        $update['research'] = $request->research;
        $update['orcid_id'] = $request->orcid_id;
        $update['informasi_lain'] = $request->other_information;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbAuthorModel::where('id_author',Session::get('id_author'))->update($update);
        if ($stmt){
            Session::put($update);
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>$this->message_failed_save]);
        }
    }
    public function updateAccountAuthorPhoto(Request $request){
        $validated = $request->validate([
            'foto' => 'required',
            'foto.*' => 'mimes:jpg,jpeg,png|max:1000'
        ]);
        if ($validated){
            $data = $request->foto;
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $imageName = date('YmdHis').'.png';
            file_put_contents(public_path('upload/author')."/".$imageName, $data);

            $update['foto_author'] = $imageName;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbAuthorModel::where('id_author',Session::get('id_author'))->update($update);
            if ($stmt){
                if (!empty($request->foto_lama)){
                    File::delete(public_path("upload/author/".$request->foto_lama));
                }
                Session::put($update);
                return response()->json(['status' => "OK"]);
            } else {
                return response()->json(['status' => "ERROR", 'message'=>$this->message_failed_save]);
            }
        } else {
            return response()->json(['status' => "ERROR", 'message'=>$this->message_invalid_input]);
        }
    }
    public function updateAccountAuthorPassword(Request $request){
        $validated = $request->validate([
            'password_lama' => 'required|string',
            'password_baru' => 'required|string'
        ]);
        if ($validated){
            $password_lama = $request->password_lama;
            $ck = TbAuthorModel::where('id_author',Session::get('id_author'))->first();
            if ($ck->password == sha1($password_lama)){
                $update['password'] = sha1($request->password_baru);
                $update['updated_at'] = date('Y-m-d H:i:s');
                $stmt = TbAuthorModel::where('id_author',Session::get('id_author'))->update($update);
                if ($stmt){
                    return response()->json(['status' => "OK"]);
                } else {
                    return response()->json(['status' => "ERROR", 'message'=>$this->message_failed_save]);
                }
            } else {
                return response()->json(['status' => "ERROR", 'message'=>"Wrong old password password"]);
            }
        } else {
            return response()->json(['status' => "ERROR", 'message'=>$this->message_invalid_input]);
        }
    }
}
