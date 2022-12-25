<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\TbAuthorModel;
use App\Models\TbEventModel;
use App\Models\TbJenisPembayaranModel;
use App\Models\TbJurnalAuthorModel;
use App\Models\TbJurnalModel;
use App\Models\TbJurnalQAModel;
use App\Models\TbNotifAdminModel;
use App\Models\TbNotifParticipanModel;
use App\Models\TbParticipanModel;
use App\Models\TbSettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class ApiParticipanController extends Controller
{
    private $message_invalid_input = "The data you have entered is invalid!!!";
    private $message_failed_save = "Failed To Save Data...";
    private $message_failed_get = "Failed To Get Data...";

    public function getNotifParticipan(){
        $stmt = TbNotifParticipanModel::where(array('stt_view'=>0,'del_flage'=>0,'id_participan'=>Session::get('id_participan')));
        if ($stmt){
            return response()->json(['status' => "OK",'total'=>$stmt->count()]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }
    public function updateNotifParticipan(Request $request){
        $update['stt_view'] = 1;
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbNotifParticipanModel::where('id_notif_participan',Helpers::dekrip($request->id))->update($update);
        if ($stmt){
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
        }
    }
    public function participanPayment(){
        $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
        $stmt = TbParticipanModel::select('tb_participan.*','tb_jenis_pembayaran.jenis_pembayaran')
            ->join('tb_jenis_pembayaran','tb_jenis_pembayaran.id_jenis_pembayaran','=','tb_participan.id_jenis_pembayaran','LEFT')
            ->where('tb_participan.id_participan',Session::get('id_participan'));
        $stmt2 = TbJenisPembayaranModel::where(array('id_event'=>$id_event,'stt_data'=>"PUBLISH"));
        $stmt3 = TbSettingModel::where('id_event',$id_event);
        if ($stmt && $stmt2 && $stmt3){
            $data = array();
            $data['status'] = "OK";

            $dt_akun = array();
            $data['data_akun'] = $stmt->first();
            $data['data_akun']['id_jenis_pembayaran'] = Helpers::enkrip($stmt->first()->id_jenis_pembayaran);

            $dt_payment = array();
            foreach ($stmt2->get() as $key => $item){
                $dt_payment[$key]['id_jenis_pembayaran'] = Helpers::enkrip($item->id_jenis_pembayaran);
                $dt_payment[$key]['jenis_pembayaran'] = $item->jenis_pembayaran;
                $dt_payment[$key]['nama_jenis_pembayaran'] = $item->nama_jenis_pembayaran;
                $dt_payment[$key]['nomor_jenis_pembayaran'] = $item->nomor_jenis_pembayaran;
                $dt_payment[$key]['an_jenis_pembayaran'] = $item->an_jenis_pembayaran;
                $dt_payment[$key]['logo_1'] = $item->logo_1;
                $dt_payment[$key]['logo_2'] = $item->logo_2;
                $dt_payment[$key]['logo_3'] = $item->logo_3;
                $dt_payment[$key]['logo_4'] = $item->logo_4;
                $dt_payment[$key]['logo_5'] = $item->logo_5;
            }
            $data['data_payment'] = $dt_payment;
            $data['data_setting'] = $stmt3->first();
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }
    public function updateParticipanPayment(Request $request){
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

            $update['id_jenis_pembayaran'] = Helpers::dekrip($request->id);
            $update['file_pembayaran'] = $fileName;
            $update['tipe_pembayaran'] = $ext;
            $update['pembayaran_bank'] = $request->bank_name;
            $update['pembayaran_an'] = $request->account_holder;
            $update['pembayaran_invoice'] = $request->pembayaran_invoice;
            $update['stt_pembayaran_konfirmasi'] = "WAITING FOR CONFIRMATION";
            $update['stt_pembayaran_date_upload'] = date('Y-m-d H:i:s');
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbParticipanModel::where('id_participan',Session::get('id_participan'))->update($update);
            if ($stmt){
                $ft_lama = $request->file_pembayaran;
                if ($ft_lama != "0"){
                    File::delete(public_path("/upload/pembayaran/".$ft_lama));
                }
                $input3['judul'] = "PAYMENT PARTICIPAN - Payment upload.";
                $input3['pesan'] = "The user has uploaded proof of payment transfer. Please check to confirm payment.";
                $input3['id_participan'] = Session::get('id_participan');
                $input3['stt_user'] = "ADMIN";
                $input3['stt_notif'] = "PAYMENT-PARTICIPAN";
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
    public function journalParticipan(Request $request){
        $search = $request->search;
        $offset = $request->offset;
        $id_event = TbParticipanModel::where('id_participan',Session::get('id_participan'))->first()->id_event;
        $stmt_data = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang','tb_author.no_author','tb_event.event','tb_event.tahun_event','tb_sub.slug')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author')
            ->where(array('tb_jurnal.del_flage'=>0,'tb_jurnal.stt_jurnal'=>"COPYEDITING",'tb_jurnal.id_event'=>$id_event))
            ->latest('tb_jurnal.id_jurnal')->where(function($query) use ($search) {
                $query->where('tb_jurnal.judul_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('tb_jurnal.abstrak_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('tb_jurnal.keyword_jurnal', 'LIKE', '%'.$search.'%');
            })->offset($offset)->limit(2);

        $stmt_ttl = TbJurnalModel::where(array('del_flage'=>0,'stt_jurnal'=>"COPYEDITING"))
            ->latest('id_jurnal')->where(function($query) use ($search) {
                $query->where('judul_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('abstrak_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('keyword_jurnal', 'LIKE', '%'.$search.'%');
            });
        if ($stmt_data && $stmt_ttl){
            $data['status'] = "OK";
            $no = 0;
            $dt = array();
            foreach ($stmt_data->get() as $item){
                $dt[$no]['event'] = $item->event;
                $dt[$no]['tahun_event'] = $item->tahun_event;
                $dt[$no]['slug'] = $item->slug;
                $dt[$no]['no_abstrak'] = $item->no_abstrak;
                $dt[$no]['title'] = $item->judul_jurnal;
                $dt[$no]['abstrac'] = $item->abstrak_jurnal;
                $dt[$no]['keyword'] = $item->keyword_jurnal;
                $dt[$no]['scope'] = $item->scope;
                if (empty($item->id_author_corresponding)){
                    $dt[$no]['nama_depan'] = $item->nama_depan;
                    $dt[$no]['nama_tengah'] = $item->nama_tengah;
                    $dt[$no]['nama_belakang'] = $item->nama_belakang;
                    $dt[$no]['no_author'] = $item->no_author;
                } else {
                    $st_author_corresponding = TbAuthorModel::where('id_author',$item->id_author_corresponding)->first();
                    $dt[$no]['nama_depan'] = $st_author_corresponding->nama_depan;
                    $dt[$no]['nama_tengah'] = $st_author_corresponding->nama_tengah;
                    $dt[$no]['nama_belakang'] = $st_author_corresponding->nama_belakang;
                    $dt[$no]['no_author'] = $st_author_corresponding->no_author;
                }
                $dt_author_nama = "";
                $dt_author_email = "";
                $dt_author_institusi = "";
                $no_author = 1;
                $dt_author_ttl_ = $dt_author_data_ = TbJurnalAuthorModel::where('id_jurnal',$item->id_jurnal);
                $dt_author_ttl = $dt_author_ttl_->count();
                $dt_author_data = $dt_author_data_->get();
                foreach ($dt_author_data as $item_2){
                    if ($no_author==1){
                        $dt_author_nama = $item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang;
                        $dt_author_email = $item_2->email;
                        $dt_author_institusi = $item_2->institusi;
                    } else {
                        if ($dt_author_ttl > 2){
                            if ($no_author == ($dt_author_ttl-1)){
                                $dt_author_nama .= " and ".$item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang;
                            } else {
                                $dt_author_nama .= ", ".$item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang;
                            }
                        } else {
                            $dt_author_nama .= " and ".$item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang;
                        }
                        $dt_author_email .= ", ".$item_2->email;
                    }
                    $no_author++;
                }
                $dt[$no]['author_nama'] = $dt_author_nama;
                $dt[$no]['author_email'] = $dt_author_email;
                $dt[$no]['author_institusi'] = $dt_author_institusi;
                $no++;
            }
            $data['data'] = $dt;
            $data['ttl'] = $stmt_ttl->count();
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>$this->message_failed_get]);
        }
    }
    public function getVideoParticipan(Request $request){
        $search = $request->search;
        $offset = $request->offset;
        $id_event = TbParticipanModel::where('id_participan',Session::get('id_participan'))->first()->id_event;
        $where['tb_jurnal.del_flage'] = 0;
        $where['tb_jurnal.id_event'] = $id_event;
        $stmt_data = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_jurnal_author.nama_depan','tb_jurnal_author.nama_tengah','tb_jurnal_author.nama_belakang','tb_author.no_author','tb_sub.slug','tb_event.event','tb_event.tahun_event')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->join('tb_jurnal_author','tb_jurnal_author.id_jurnal_author','=','tb_jurnal.id_jurnal_author','LEFT')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_author.id_author','LEFT')
            ->where($where)
            ->whereNotNull('link_video')
            ->latest('tb_jurnal.id_jurnal')->where(function($query) use ($search) {
                $query->where('tb_jurnal.judul_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('tb_jurnal.abstrak_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('tb_jurnal.keyword_jurnal', 'LIKE', '%'.$search.'%');
            })->offset($offset)->limit(2);

        $stmt_ttl = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_jurnal_author.nama_depan','tb_jurnal_author.nama_tengah','tb_jurnal_author.nama_belakang','tb_author.no_author','tb_sub.slug','tb_event.event','tb_event.tahun_event')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->join('tb_jurnal_author','tb_jurnal_author.id_jurnal_author','=','tb_jurnal.id_jurnal_author','LEFT')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_author.id_author','LEFT')
            ->where($where)
            ->whereNotNull('link_video')
            ->latest('id_jurnal')->where(function($query) use ($search) {
                $query->where('judul_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('abstrak_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('keyword_jurnal', 'LIKE', '%'.$search.'%');
            });
        if ($stmt_data && $stmt_ttl){
            $data['status'] = "OK";
            $no = 0;
            $dt = array();
            foreach ($stmt_data->get() as $item){
                $dt[$no]['title'] = $item->judul_jurnal;
                $dt[$no]['no_abstrac'] = $item->no_abstrak;
                $dt[$no]['no_author'] = $item->no_author;
                $dt[$no]['abstrac'] = $item->abstrak_jurnal;
                $dt[$no]['keyword'] = $item->keyword_jurnal;
                $dt[$no]['scope'] = $item->scope;
                $dt[$no]['slug'] = $item->slug;
                $dt[$no]['link_video'] = $item->link_video;
                $dt[$no]['link_video_embed'] = $item->link_video_embed;
                $dt[$no]['nama_depan'] = $item->nama_depan;
                $dt[$no]['nama_tengah'] = $item->nama_tengah;
                $dt[$no]['nama_belakang'] = $item->nama_belakang;
                $dt[$no]['event'] = $item->event;
                $dt[$no]['tahun_event'] = $item->tahun_event;
                $dt[$no]['ttl_qa'] = TbJurnalQAModel::where('id_jurnal',$item->id_jurnal)->count();;
                $dt_author_nama = "";
                $dt_author_email = "";
                $no_author = 1;
                $dt_author_ttl = TbJurnalAuthorModel::where('id_jurnal',$item->id_jurnal)->count();
                $dt_author_data = TbJurnalAuthorModel::where('id_jurnal',$item->id_jurnal)->get();
                foreach ($dt_author_data as $item_2){
                    if ($no_author==1){
                        $dt_author_nama = strtoupper($item_2->nama_depan)." ".strtoupper($item_2->nama_tengah)." ".strtoupper($item_2->nama_belakang);
                        $dt_author_email = $item_2->email;
                        $dt_author_institusi = $item_2->institusi;
                    } else {
                        if ($dt_author_ttl > 2){
                            if ($no_author == ($dt_author_ttl-1)){
                                $dt_author_nama .= " and ".strtoupper($item_2->nama_depan)." ".strtoupper($item_2->nama_tengah)." ".strtoupper($item_2->nama_belakang);
                            } else {
                                $dt_author_nama .= ", ".strtoupper($item_2->nama_depan)." ".strtoupper($item_2->nama_tengah)." ".strtoupper($item_2->nama_belakang);
                            }
                        } else {
                            $dt_author_nama .= " and ".strtoupper($item_2->nama_depan)." ".strtoupper($item_2->nama_tengah)." ".strtoupper($item_2->nama_belakang);
                        }
                        $dt_author_email .= ", ".$item_2->email;
                    }
                    $no_author++;
                }
                $dt[$no]['author_nama'] = $dt_author_nama;
                $no++;
            }
            $data['data'] = $dt;
            $data['ttl'] = $stmt_ttl->count();
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>"Failed To Display Data "]);
        }
    }
    public function getAccountParticipan(){
        $stmt = TbParticipanModel::select('tb_participan.*','tb_gelar.gelar','tb_negara.negara')
            ->join('tb_gelar','tb_gelar.id_gelar','=','tb_participan.id_gelar','LEFT')
            ->join('tb_negara','tb_negara.id_negara','=','tb_participan.id_negara','LEFT')
            ->where('tb_participan.id_participan',Session::get('id_participan'));
        if ($stmt){
            return response()->json(['status' => "OK", 'data' => $stmt->first()]);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>$this->message_failed_get]);
        }
    }
    public function updateAccountParticipan(Request $request){
        $update['id_gelar'] = Helpers::dekrip($request->bachelor_degree);
        $update['id_negara'] = Helpers::dekrip($request->country);
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
        $stmt = TbParticipanModel::where('id_participan',Session::get('id_participan'))->update($update);
        if ($stmt){
            Session::put($update);
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>$this->message_failed_save]);
        }
    }
    public function updateAccountParticipanPhoto(Request $request){
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
            file_put_contents(public_path('upload/participan')."/".$imageName, $data);

            $update['foto_participan'] = $imageName;
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbParticipanModel::where('id_participan',Session::get('id_participan'))->update($update);
            if ($stmt){
                if (!empty($request->foto_lama)){
                    File::delete(public_path("upload/participan/".$request->foto_lama));
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
    public function updateAccountParticipanPassword(Request $request){
        $validated = $request->validate([
            'password_lama' => 'required|string',
            'password_baru' => 'required|string'
        ]);
        if ($validated){
            $password_lama = $request->password_lama;
            $ck = TbParticipanModel::where('id_participan',Session::get('id_participan'))->first();
            if ($ck->password == sha1($password_lama)){
                $update['password'] = sha1($request->password_baru);
                $update['updated_at'] = date('Y-m-d H:i:s');
                $stmt = TbParticipanModel::where('id_participan',Session::get('id_participan'))->update($update);
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
