<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\TbJurnalModel;
use App\Models\TbJurnalRevisiModel;
use App\Models\TbKontakModel;
use App\Models\TbNotifAuthorModel;
use App\Models\TbNotifReviewerModel;
use App\Models\TbReviewerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ApiReviewerController extends Controller
{
    private $message_invalid_input = "The data you have entered is invalid!!!";
    private $message_failed_save = "Failed To Save Data...";
    private $message_failed_get = "Failed To Get Data...";

    public function getNotifReviewer(){
        $stmt = TbNotifReviewerModel::where(array('stt_view'=>0,'del_flage'=>0,'id_reviewer'=>Session::get('id_reviewer')));
        if ($stmt){
            return response()->json(['status' => "OK",'total'=>$stmt->count()]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }
    public function updateNotifReviewer(Request $request){
        $update['stt_view'] = 1;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbNotifReviewerModel::where('id_notif_reviewer',Helpers::dekrip($request->id))->update($update);
        if ($stmt){
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
        }
    }
    public function updateRevisionAdd(Request $request){
        $update['id_reviewer'] = Session::get('id_reviewer');
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbJurnalModel::where('id_jurnal',Helpers::dekrip($request->id))->update($update);
        if ($stmt){
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
        }
    }
    public function inputMyRevision(Request $request){
        $validator = Validator::make($request->all(), [
            'kode' => 'required',
            'stt_full_paper' => 'required',
            'revision' => 'required',
            'file_revisi_reviewer' => 'required|mimes:doc,docx,pdf|max:5000',
        ]);
        if (!$validator->fails()){
            $dt_jurnal = TbJurnalModel::where('no_abstrak',Helpers::dekrip($request->kode))->first();
            $stt_revisi = $request->stt_full_paper;
            $file = $request->file('file_revisi_reviewer');
            if (!empty($file)){
                $fileName = date('YmdHis').'.'. $file->extension();
                $file->move(public_path('upload/jurnal_revisi'), $fileName);
                $input['file_revisi_reviewer'] = $fileName;
            }
            if ($stt_revisi=="COPYEDITING"){
                $message_review = "Your paper has been received and will be processed for publication.";
                $update['stt_full_paper'] = "COPYEDITING";
                $update['stt_revisi_paper'] = "FILLED";
                $update['stt_progres_paper'] = "COPYEDITING";
            } else {
                $message_review = $request->revision;
                $update['stt_full_paper'] = "REVISION REQUIRED";
                $update['stt_revisi_paper'] = "EMPTY";
                $update['stt_progres_paper'] = "WAITING REVISED PAPER";
                $input['revisi_ke'] = (int)TbJurnalRevisiModel::where(array('id_jurnal'=>$dt_jurnal->id_jurnal,'stt_revisi'=>"REVISION REQUIRED",'del_flage'=>0))->count()+1;
            }
            $input['revisi'] = $request->revision;
            $input['id_jurnal'] = $dt_jurnal->id_jurnal;
            $input['stt_revisi'] = $stt_revisi;
            $input['created_at'] = date('Y-m-d H:i:s');
            $stmt = TbJurnalRevisiModel::insert($input);
            if ($stmt){
                $id_author_corresponding = $dt_jurnal->id_author_corresponding;
                if (empty($id_author_corresponding)){
                    $id_author_corresponding = $dt_jurnal->id_author;
                }
                $input2['judul'] = "Review Result";
                $input2['pesan'] = $message_review;
                $input2['id_author'] = $id_author_corresponding;
                $input2['id_jurnal'] = $dt_jurnal->id_jurnal;
                $input2['stt_notif'] = "REVISION";
                $input2['created_at'] = date('Y-m-d H:i:s');
                TbNotifAuthorModel::insert($input2);
                TbJurnalModel::where('id_jurnal',$dt_jurnal->id_jurnal)->update($update);
                return response()->json(['status' => "OK"]);
            } else {
                return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
            }
        } else {
            $error = array();
            foreach ($validator->errors()->all() as $key => $item) {
                $error[$key] = $item;
            }
            return response()->json(['status' => "ERROR", 'message' => $error]);
        }
    }
    public function updateMyRevisionAcc(Request $request){
        $id = Helpers::dekrip($request->id);
        $no_abs = $request->no_abs;

        $dt_jurnal = TbJurnalModel::where('no_abstrak',$no_abs)->first();
        $kontak_nomor = "";
        $kontak = TbKontakModel::where('judul',"Whatsapp");
        if ($kontak->count() > 0) {
            $kontak_nomor = $kontak->first()->isi;
        }

        $stmt_corresponding = TbJurnalModel::select('tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang','tb_author.email')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author_corresponding')
            ->where('tb_jurnal.no_abstrak',$no_abs)->first();
        $to_name = $stmt_corresponding->nama_depan." ".$stmt_corresponding->nama_tengah." ".$stmt_corresponding->nama_belakang;
        $to_email = $stmt_corresponding->email;
        $to_body = 'Your paper entitled <b>'.$dt_jurnal->judul_jurnal.'</b> has been received and will be processed for publication.<br/><br/>
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
        if (Mail::failures()){
            return response()->json(['status' => 'ERROR', 'message' => 'Failed to send e-mail. E-mail is unstable, please try again a few minutes later ...']);
        } else {
            $update['stt_revisi'] = "COPYEDITING";
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbJurnalRevisiModel::where('id_jurnal_revisi',$id)->update($update);
            if ($stmt){
                $update2['stt_full_paper'] = "COPYEDITING";
                $update2['stt_jurnal'] = "COPYEDITING";
                $update2['stt_revisi_paper'] = "FILLED";
                $update2['stt_progres_paper'] = "COPYEDITING";
                $update2['updated_at'] = date('Y-m-d H:i:s');
                TbJurnalModel::where('no_abstrak',$no_abs)->update($update2);

                $id_author_corresponding = $dt_jurnal->id_author_corresponding;
                if (empty($id_author_corresponding)){
                    $id_author_corresponding = $dt_jurnal->id_author;
                }
                $input3['judul'] = "Review Result";
                $input3['pesan'] = "Your paper has been received and will be processed for publication.";
                $input3['id_jurnal'] = $dt_jurnal->id_jurnal;
                $input3['id_author'] = $id_author_corresponding;
                $input3['stt_notif'] = "REVISION";
                $input3['created_at'] = date('Y-m-d H:i:s');
                TbNotifAuthorModel::insert($input3);
                return response()->json(['status' => "OK"]);
            } else {
                return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
            }
        }
    }
    public function updateAccountReviewer(Request $request){
        $update['nama_depan'] = $request->first_name;
        $update['nama_tengah'] = $request->middle_name;
        $update['nama_belakang'] = $request->last_name;
        $update['jenis_kelamin'] = $request->sex;
        $update['email'] = $request->email;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbReviewerModel::where('id_reviewer',Session::get('id_reviewer'))->update($update);
        if ($stmt){
            Session::put($update);
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>$this->message_failed_save]);
        }
    }
    public function updateAccountReviewerPhoto(Request $request){
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
            file_put_contents(public_path('upload/reviewer')."/".$imageName, $data);

            $update['foto_reviewer'] = $imageName;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbReviewerModel::where('id_reviewer',Session::get('id_reviewer'))->update($update);
            if ($stmt){
                if (!empty($request->foto_lama)){
                    File::delete(public_path("upload/reviewer/".$request->foto_lama));
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
    public function updateAccountReviewerPassword(Request $request){
        $validated = $request->validate([
            'password_lama' => 'required|string',
            'password_baru' => 'required|string'
        ]);
        if ($validated){
            $password_lama = $request->password_lama;
            $ck = TbReviewerModel::where('id_reviewer',Session::get('id_reviewer'))->first();
            if ($ck->password == sha1($password_lama)){
                $update['password'] = sha1($request->password_baru);
                $update['updated_at'] = date('Y-m-d H:i:s');
                $stmt = TbReviewerModel::where('id_reviewer',Session::get('id_reviewer'))->update($update);
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
