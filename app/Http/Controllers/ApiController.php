<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\TbAuthorModel;
use App\Models\TbCoHostModel;
use App\Models\TbEventModel;
use App\Models\TbGelarModel;
use App\Models\TbIndexingModel;
use App\Models\TbInvitedSpeakerModel;
use App\Models\TbJenisPembayaranModel;
use App\Models\TbJurnalAuthorModel;
use App\Models\TbJurnalModel;
use App\Models\TbJurnalQAModel;
use App\Models\TbJurnalQASubModel;
use App\Models\TbJurnalRevisiModel;
use App\Models\TbKerjaSamaModel;
use App\Models\TbKeynoteSpeakerModel;
use App\Models\TbKontakModel;
use App\Models\TbNegaraModel;
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
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ApiController extends Controller
{
    private $message_invalid_input = "The data you have entered is invalid!!!";
    private $message_failed_get = "Failed To Get Data...";
    private $message_failed_save = "Failed To Save Data...";
    private $message_failed_delete = "Failed To Delete Data...";

    public function ckAccountAuthor(Request $request){
        $sbg = $request->sebagai;
        $stmt = false;
        if ($sbg=="AUTHOR"){
            $stmt = TbAuthorModel::where(array('email'=>$request->email,'del_flage'=>0))->count();
        } elseif ($sbg=="PARTICIPAN") {
            $stmt = TbParticipanModel::where(array('email'=>$request->email,'del_flage'=>0))->count();
        } elseif ($sbg=="REVIEWER") {
            $stmt = TbReviewerModel::where(array('email'=>$request->email,'del_flage'=>0))->count();
        }
        if ($stmt > 0) {
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>"E-mail is not registered"]);
        }
    }
    public function submitForgotAuthor(Request $request){
        $password = Helpers::getRandomPassword();
        $sbg = $request->sebagai;
        $email = $request->email;
        $dt = null;
        if ($sbg=="AUTHOR"){
            $dt = TbAuthorModel::where('email',$email)->first();
        } elseif ($sbg=="PARTICIPAN") {
            $dt = TbParticipanModel::where('email',$email)->first();
        } elseif ($sbg=="REVIEWER") {
            $dt = TbReviewerModel::where('email',$email)->first();
        }
        $to_name = $dt->nama_depan." ".$dt->nama_tengah." ".$dt->nama_belakang;
        $to_email = $email;
        $to_body = "Please enter the application by using <br/>E-mail : ".$to_email."<br/>and Password : ".$password;
        $data = array('name'=>$to_name, "body" => $to_body);

        Mail::send('other.mail', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)
                ->subject('TIC Politeknik Harapan Bersama');
            $message->from('tic@poltektegal.ac.id','TIC Politeknik Harapan Bersama');
        });
        if (Mail::failures()){
            return response()->json(['status' => 'ERROR', 'message' => 'Failed send email forgot password. Please try again...']);
        } else {
            $stmt = false;
            $update['password'] = sha1($password);
            $update['updated_at'] = date('Y-m-d H:i:s');
            if ($sbg=="AUTHOR"){
                $stmt = TbAuthorModel::where('email',$email)->update($update);
            } elseif ($sbg=="PARTICIPAN") {
                $stmt = TbParticipanModel::where('email',$email)->update($update);
            } elseif ($sbg=="REVIEWER") {
                $stmt = TbReviewerModel::where('email',$email)->update($update);
            }
            if ($stmt){
                return response()->json(['status' => 'OK', 'message' => 'Successfully Forgot Password. Please check your email to get an account to enter the TIC application.. ']);
            } else {
                return response()->json(['status' => 'ERROR', 'message' => 'Failed to Forgot Password. Please try again...']);
            }
        }
    }
    public function selectNegara(Request $request){
        $term = $request->q;
        $tags = TbNegaraModel::where("negara", "like" , "%$term%")->get();
        $formatted_tags = [];
        foreach ($tags as $tag) {
            $formatted_tags[] = ['id' => $tag->id_negara, 'text' => $tag->negara];
        }
        return response()->json($formatted_tags);
    }
    public function journal(Request $request){
        $search = $request->search;
        $offset = $request->offset;
        $where['tb_jurnal.del_flage'] = 0;
        $where['tb_jurnal.stt_jurnal'] = "WILL BE PROCESSED";
        if (!empty($request->type)){
            $type = $request->type;
            if ($type=="soc"){
                $where['tb_sub.slug'] = "applied-social-science-and-humanities";
                $where['tb_event.stt_aktif'] = 1;
            } else if ($type=="sci"){
                $where['tb_sub.slug'] = "applied-sciences";
                $where['tb_event.stt_aktif'] = 1;
            }
        }
        $stmt_data = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang','tb_author.no_author','tb_event.event','tb_event.tahun_event','tb_sub.slug')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author')
            ->where($where)
            ->latest('tb_jurnal.id_jurnal')->where(function($query) use ($search) {
                $query->where('tb_jurnal.judul_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('tb_jurnal.abstrak_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('tb_jurnal.keyword_jurnal', 'LIKE', '%'.$search.'%');
            })->offset($offset)->limit(2);
        $stmt_ttl = TbJurnalModel::select('tb_jurnal.*')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author')
            ->where($where)
            ->latest('tb_jurnal.id_jurnal')->where(function($query) use ($search) {
                $query->where('tb_jurnal.judul_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('tb_jurnal.abstrak_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('tb_jurnal.keyword_jurnal', 'LIKE', '%'.$search.'%');
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
    public function detailJournal(Request $request){
        $select = array('link_video','no_abstrak','judul_jurnal','judul_jurnal','id_author');
        $stmt = TbJurnalModel::select($select)->where('no_abstrak',$request->no_abs);
        if ($stmt){
            $data = array();
            $data['status'] = "OK";
            $data['data'] = $stmt->first();
            $data['data']['kode_abs'] = Helpers::enkrip($stmt->first()->no_abstrak);
            $data['data']['id_author'] = Helpers::enkrip($stmt->first()->id_author);
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }
    public function processJournal(Request $request) {
        $update['stt_jurnal'] = "WILL BE PROCESSED";
        $update['stt_full_paper'] = "WILL BE PROCESSED";
        $update['stt_progres_paper'] = "WILL BE PROCESSED";
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbJurnalModel::where('no_abstrak',$request->no_abs)->update($update);
        if ($stmt){
            $data = array();
            $data['status'] = "OK";

            $dt_jurnal = TbJurnalModel::where('no_abstrak',$request->no_abs)->first();
            $input['id_author'] = $dt_jurnal->id_author;
            $input['judul'] = "Paper";
            $input['pesan'] = "You're paper will be processed for publication.";
            $input['id_jurnal'] = $dt_jurnal->id_jurnal;
            $input['stt_notif'] = "JURNAL";
            $input['created_at'] = date('Y-m-d H:i:s');
            TbNotifAuthorModel::insert($input);

            $dt_revisi = TbJurnalRevisiModel::where('id_jurnal',$dt_jurnal->id_jurnal)->latest('id_jurnal_revisi')->first();
            $update2['stt_revisi'] = "WILL BE PROCESSED";
            $update2['updated_at'] = date('Y-m-d H:i:s');
            TbJurnalRevisiModel::where('id_jurnal_revisi',$dt_revisi->id_jurnal_revisi)->update($update2);

            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }
    public function getVideo(Request $request){
        $search = $request->search;
        $offset = $request->offset;
        $where['tb_jurnal.del_flage'] = 0;
        if (!empty($request->slug)){
            $where['tb_sub.slug'] = $request->slug;
        }
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
            })->offset($offset)->limit(4);

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
    public function getJournalQAForum(Request $request){
        $where['tb_jurnal.no_abstrak'] = $request->no_abs;
        if (!empty($request->kd)){
            $where['tb_jurnal_qa.id_jurnal_qa'] = $request->kd;
        }
        $stmt = TbJurnalQAModel::select(DB::raw('tb_jurnal_qa.*, tb_author.nama_depan, tb_author.nama_tengah, tb_author.nama_belakang, tb_author.no_author, tb_author.foto_author, tb_reviewer.nama_depan as r_nama_depan, tb_reviewer.nama_tengah as r_nama_tengah, tb_reviewer.nama_belakang as r_nama_belakang, tb_reviewer.foto_reviewer, tb_sub.sub'))
            ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_qa.id_jurnal')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_qa.id_author','LEFT')
            ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal_qa.id_reviewer','LEFT')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->where($where)
            ->latest('tb_jurnal_qa.id_jurnal_qa');
        if ($stmt){
            $dt_qa = array();
            foreach ($stmt->get() as $key => $item){
                $dt_qa[$key]['nama_author'] = $item->stt_user == "AUTHOR" ? $item->nama_depan." ".$item->nama_tengah." ".$item->nama_belakang : $item->r_nama_depan." ".$item->r_nama_tengah." ".$item->r_nama_belakang."(Reviewer)";
                $dt_qa[$key]['foto_author'] = $item->stt_user == "AUTHOR" ? $item->foto_author : $item->foto_reviewer;
                $dt_qa[$key]['no_author'] = $item->stt_user == "AUTHOR" ? $item->no_author : "";
                $dt_qa[$key]['stt_user'] = $item->stt_user;
                $dt_qa[$key]['pertanyaan'] = $item->pertanyaan;
                $dt_qa[$key]['created_at'] = $item->created_at;
                $stmt_2 = TbJurnalQASubModel::select(DB::raw('tb_jurnal_qa_sub.*,tb_author.nama_depan,tb_author.nama_tengah,tb_author.nama_belakang,tb_author.no_author,tb_author.foto_author, tb_reviewer.nama_depan as r_nama_depan, tb_reviewer.nama_tengah as r_nama_tengah, tb_reviewer.nama_belakang as r_nama_belakang, tb_reviewer.foto_reviewer, tb_sub.sub'))
                    ->join('tb_jurnal_qa','tb_jurnal_qa.id_jurnal_qa','=','tb_jurnal_qa_sub.id_jurnal_qa')
                    ->join('tb_author','tb_author.id_author','=','tb_jurnal_qa_sub.id_author','LEFT')
                    ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal_qa_sub.id_reviewer','LEFT')
                    ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_qa.id_jurnal')
                    ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
                    ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
                    ->where('tb_jurnal_qa_sub.id_jurnal_qa',$item->id_jurnal_qa);
                $dt_qa_sub = array();
                foreach ($stmt_2->get() as $key2 => $item_2){
                    $dt_qa_sub[$key2]['nama_author'] = $item_2->stt_user == "AUTHOR" ? $item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang : $item_2->r_nama_depan." ".$item_2->r_nama_tengah." ".$item_2->r_nama_belakang;
                    $dt_qa_sub[$key2]['foto_author'] = $item_2->stt_user == "AUTHOR" ? $item_2->foto_author : $item_2->foto_reviewer;
                    $dt_qa_sub[$key2]['no_author'] = $item_2->stt_user == "AUTHOR" ? $item_2->no_author : "";
                    $dt_qa_sub[$key2]['stt_user'] = $item_2->stt_user;
                    $dt_qa_sub[$key2]['pertanyaan'] = $item_2->pertanyaan;
                    $dt_qa_sub[$key2]['created_at'] = $item_2->created_at;
                }
                $dt_qa[$key]['sub'] = $dt_qa_sub;
            }
            return response()->json(['status' => "OK", 'data' => $dt_qa]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }
    public function getForum(Request $request){
        $search = $request->search;
        $offset = $request->offset;
        $order = $request->order;

        $where['tb_jurnal_qa.del_flage'] = 0;
        $where['tb_jurnal.del_flage'] = 0;
        $where['tb_event.stt_aktif'] = 0;
        if (!empty($request->type)){
            $type = $request->type;
            if ($type=="soc"){
                $where['tb_sub.slug'] = "applied-social-science-and-humanities";
                $where['tb_event.stt_aktif'] = 1;
            } else if ($type=="sci"){
                $where['tb_sub.slug'] = "applied-sciences";
                $where['tb_event.stt_aktif'] = 1;
            }
        }
        $stmt = TbJurnalQAModel::selectRaw('tb_jurnal_qa.*, tb_jurnal.id_author_corresponding, tb_author.foto_author, tb_author.nama_depan, tb_author.nama_tengah, tb_author.nama_belakang, tb_jurnal.judul_jurnal, tb_jurnal.no_abstrak, tb_reviewer.nama_depan as r_nama_depan, tb_reviewer.nama_tengah as r_nama_tengah, tb_reviewer.nama_belakang as r_nama_belakang, tb_reviewer.foto_reviewer')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_qa.id_author','LEFT')
            ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal_qa.id_reviewer','LEFT')
            ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_qa.id_jurnal')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->where($where)
            ->orderBy('tb_jurnal_qa.id_jurnal_qa',$order)->offset($offset)->limit(5);
        $stmt_ttl = TbJurnalQAModel::selectRaw('tb_jurnal_qa.*, tb_jurnal.id_author_corresponding, tb_author.foto_author, tb_author.nama_depan, tb_author.nama_tengah, tb_author.nama_belakang, tb_jurnal.judul_jurnal, tb_jurnal.no_abstrak, tb_reviewer.nama_depan as r_nama_depan, tb_reviewer.nama_tengah as r_nama_tengah, tb_reviewer.nama_belakang as r_nama_belakang, tb_reviewer.foto_reviewer')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_qa.id_author','LEFT')
            ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal_qa.id_reviewer','LEFT')
            ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_qa.id_jurnal')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->where($where)
            ->orderBy('tb_jurnal_qa.id_jurnal_qa',$order);
        if ($stmt && $stmt_ttl){
            $dt = array();
            foreach ($stmt->get() as $key => $item){
                $id_corresponding = $item->id_author_corresponding;
                if (empty($id_corresponding)){
                    $id_corresponding = $item->id_author;
                }
                $st_cor = TbAuthorModel::where('id_author',$id_corresponding)->first();
                $dt[$key]['id'] = $item->id_jurnal_qa;
                $dt[$key]['pertanyaan'] = $item->pertanyaan;
                $dt[$key]['foto_author_qa'] = $item->stt_user == "AUTHOR" ? $item->foto_author : $item->foto_reviewer;
                $dt[$key]['nama_depan_qa'] = $item->stt_user == "AUTHOR" ? $item->nama_depan : $item->r_nama_depan;
                $dt[$key]['nama_tengah_qa'] = $item->stt_user == "AUTHOR" ? $item->nama_tengah : $item->r_nama_tengah;
                $dt[$key]['nama_belakang_qa'] = $item->stt_user == "AUTHOR" ? $item->nama_belakang : $item->r_nama_belakang;
                $dt[$key]['judul_jurnal'] = $item->judul_jurnal;
                $dt[$key]['stt_user'] = $item->stt_user;
                $dt[$key]['no_abstrak'] = $item->no_abstrak;
                $dt[$key]['no_author'] = $st_cor->no_author;
                $dt[$key]['nama_depan'] = $st_cor->nama_depan;
                $dt[$key]['nama_tengah'] = $st_cor->nama_tengah;
                $dt[$key]['nama_belakang'] = $st_cor->nama_belakang;
                $dt[$key]['created_at'] = $item->created_at;
                $dt[$key]['ttl'] = TbJurnalQASubModel::where(array('id_jurnal_qa'=>$item->id_jurnal_qa,'del_flage'=>0))->count();
            }
            $data['status'] = "OK";
            $data['data'] = $dt;
            $data['ttl'] = $stmt_ttl->count();
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>$this->message_failed_get]);
        }
    }
    public function insertQAForum(Request $request){
        $dt_jurnal = TbJurnalModel::where('no_abstrak',Helpers::dekrip($request->no_abs))->first();
        if (Session::has('id_author')){
            $input['id_author'] = Session::get('id_author');
            $input['stt_user'] = "AUTHOR";
        }
        if (Session::has('id_reviewer')){
            $input['id_reviewer'] = Session::get('id_reviewer');
            $input['stt_user'] = "REVIEWER";
        }
        $input['id_jurnal'] = $dt_jurnal->id_jurnal;
        $input['pertanyaan'] = $request->et_question;
        $input['created_at'] = date('Y-m-d H:i:s');
        $stmt = TbJurnalQAModel::insertGetId($input);
        if ($stmt){
            if (Session::has('id_author')){
                if (Helpers::dekrip($request->kd_author) != Session::get('id_author')){
                    $input2['id_author'] = Helpers::dekrip($request->kd_author);
                    $input2['judul'] = "QA Forum - Someone gave feedback about your journal";
                    $input2['pesan'] = strip_tags($request->et_question);
                    $input2['id_jurnal'] = $dt_jurnal->id_jurnal;
                    $input2['id_jurnal_qa'] = $stmt;
                    $input2['stt_notif'] = "QA FORUM";
                    $input2['created_at'] = date('Y-m-d H:i:s');
                    TbNotifAuthorModel::insert($input2);
                }
            } else {
                $id_author_corres = $dt_jurnal->id_author;
                if (empty($id_author_corres)){
                    $id_author_corres = $dt_jurnal->id_author_corresponding;
                }
                $input2['id_author'] = $id_author_corres;
                $input2['judul'] = "QA Forum - Someone gave feedback about your journal";
                $input2['pesan'] = strip_tags($request->et_question);
                $input2['id_jurnal'] = $dt_jurnal->id_jurnal;
                $input2['id_jurnal_qa'] = $stmt;
                $input2['stt_notif'] = "QA FORUM";
                $input2['created_at'] = date('Y-m-d H:i:s');
                TbNotifAuthorModel::insert($input2);
            }
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }
    public function detailQAForum(Request $request){
        $kode_abs = Helpers::dekrip($request->kd);
        $stmt = TbJurnalModel::select('tb_jurnal.*','tb_jurnal.no_abstrak','tb_jurnal.judul_jurnal','tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang','tb_author.no_author','tb_event.event','tb_event.tahun_event','tb_sub.slug')
            ->join('tb_jurnal_author','tb_jurnal_author.id_jurnal_author','=','tb_jurnal.id_jurnal_author')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_author.id_author')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->where('tb_jurnal.no_abstrak',$request->no_abs);
        $stmt2 = TbJurnalQASubModel::select(DB::raw('tb_jurnal_qa_sub.*,tb_author.nama_depan,tb_author.nama_tengah,tb_author.nama_belakang,tb_author.foto_author,tb_reviewer.nama_depan as r_nama_depan,tb_reviewer.nama_tengah as r_nama_tengah,tb_reviewer.nama_belakang as r_nama_belakang,tb_reviewer.foto_reviewer'))
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_qa_sub.id_author','LEFT')
            ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal_qa_sub.id_reviewer','LEFT')
            ->join('tb_jurnal_qa','tb_jurnal_qa.id_jurnal_qa','=','tb_jurnal_qa_sub.id_jurnal_qa')
            ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_qa.id_jurnal')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->where(array('tb_jurnal_qa_sub.id_jurnal_qa'=>$kode_abs,'tb_jurnal_qa_sub.del_flage'=>0));
        $stmt3 = TbJurnalQAModel::select(DB::raw('tb_jurnal_qa.*,tb_author.nama_depan,tb_author.nama_tengah,tb_author.nama_belakang,tb_author.foto_author,tb_author.no_author,tb_reviewer.nama_depan as r_nama_depan,tb_reviewer.nama_tengah as r_nama_tengah,tb_reviewer.nama_belakang as r_nama_belakang,tb_reviewer.foto_reviewer'))
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_qa.id_author','LEFT')
            ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal_qa.id_reviewer','LEFT')
            ->where(array('tb_jurnal_qa.del_flage'=>0,'tb_jurnal_qa.id_jurnal_qa'=>$kode_abs));
        if ($stmt && $stmt2 && $stmt3){
            $dt = $stmt->first();
            $dt2 = $stmt3->first();
            $dt_author_nama = "";
            $no_author = 1;
            $dt_author_ttl = $sdt_jurnal_author = TbJurnalAuthorModel::select('tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang')
                ->join('tb_author','tb_author.id_author','=','tb_jurnal_author.id_author')
                ->where(array('tb_jurnal_author.del_flage'=>0,'tb_jurnal_author.id_jurnal'=>$dt->id_jurnal));
            foreach ($sdt_jurnal_author->get() as $item){
                if ($no_author==1){
                    $dt_author_nama = strtoupper($item->nama_depan)." ".strtoupper($item->nama_tengah)." ".strtoupper($item->nama_belakang);
                } else {
                    if ($dt_author_ttl->count() > 2){
                        if ($no_author == ($dt_author_ttl->count()-1)){
                            $dt_author_nama .= " and ".strtoupper($item->nama_depan)." ".strtoupper($item->nama_tengah)." ".strtoupper($item->nama_belakang);
                        } else {
                            $dt_author_nama .= ", ".strtoupper($item->nama_depan)." ".strtoupper($item->nama_tengah)." ".strtoupper($item->nama_belakang);
                        }
                    } else {
                        $dt_author_nama .= " and ".strtoupper($item->nama_depan)." ".strtoupper($item->nama_tengah)." ".strtoupper($item->nama_belakang);
                    }
                }
                $no_author++;
            }

            $jurnal['no_abstrak'] = $dt->no_abstrak;
            $jurnal['kode_abs'] = Helpers::enkrip($dt->no_abstrak);
            $jurnal['no_author'] = $dt->no_author;
            $jurnal['judul_jurnal'] = $dt->judul_jurnal;
            $jurnal['nama_depan'] = $dt->nama_depan;
            $jurnal['nama_tengah'] = $dt->nama_tengah;
            $jurnal['nama_belakang'] = $dt->nama_belakang;
            $jurnal['slug'] = $dt->slug;
            $jurnal['event'] = $dt->event;
            $jurnal['tahun_event'] = $dt->tahun_event;
            $jurnal['link_video'] = $dt->link_video;
            $jurnal['nama_author'] = $dt_author_nama;
            $jurnal['pertanyaan'] = $dt2->pertanyaan;

            $jurnal['stt_user'] = $dt2->stt_user;
            $jurnal['qa_no_author'] = $dt2->stt_user == "AUTHOR" ? $dt2->no_author : "";
            $jurnal['qa_nama_depan'] = $dt2->stt_user == "AUTHOR" ? $dt2->nama_depan : $dt2->r_nama_depan;
            $jurnal['qa_nama_tengah'] = $dt2->stt_user == "AUTHOR" ? $dt2->nama_tengah : $dt2->r_nama_tengah;
            $jurnal['qa_nama_belakang'] = $dt2->stt_user == "AUTHOR" ? $dt2->nama_belakang : $dt2->r_nama_belakang;
            $jurnal['qa_foto_author'] = $dt2->stt_user == "AUTHOR" ? $dt2->foto_author : $dt2->foto_reviewer;
            $jurnal['created_at'] = $dt2->created_at;
            $data['status'] = "OK";
            $data['jurnal'] = $jurnal;
            $data['qa'] = $stmt2->get();
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }
    public function insertQAForumSub(Request $request){
        $id_author = Session::get('id_author');
        $id_reviewer = Session::get('id_reviewer');
        $tx_kd = Helpers::dekrip($request->tx_kd);
        $tx_abs = Helpers::dekrip($request->tx_abs);
        if (Session::has('id_reviewer')){
            $input['stt_user'] = "REVIEWER";
        }
        $input['id_author'] = $id_author;
        $input['id_reviewer'] = $id_reviewer;
        $input['id_jurnal_qa'] = $tx_kd;
        $input['pertanyaan'] = $request->et_question;
        $input['created_at'] = date('Y-m-d H:i:s');
        $stmt = TbJurnalQASubModel::insert($input);
        if ($stmt){
            $dt = TbJurnalModel::where('no_abstrak',$tx_abs)->first();
            $dt_qa = TbJurnalQAModel::where('id_jurnal_qa',$tx_kd)->first();
            if (Session::has('id_author')){
                if ($dt_qa->stt_user == "AUTHOR"){
                    if ($id_author != $dt->id_author){
                        $id_author_corres = $dt->id_author_corresponding;
                        if (empty($id_author_corres)){
                            $id_author_corres = $dt->id_author;
                        }
                        $input2['judul'] = "QA Forum - Other writers ask back about your journal ";
                        $input2['id_author'] = $id_author_corres;
                        $input2['stt_notif'] = "QA FORUM";
                        $input2['pesan'] = strip_tags($request->et_question);
                        $input2['id_jurnal'] = $dt->id_jurnal;
                        $input2['id_jurnal_qa'] = $tx_kd;
                        $input2['created_at'] = date('Y-m-d H:i:s');
                        TbNotifAuthorModel::insert($input2);
                    } else {
                        $input2['judul'] = "My Question - The author replied to your question";
                        $input2['stt_notif'] = "MY QUESTION";
                        $input2['id_author'] = $dt_qa->id_author;
                        $input2['pesan'] = strip_tags($request->et_question);
                        $input2['id_jurnal'] = $dt->id_jurnal;
                        $input2['id_jurnal_qa'] = $tx_kd;
                        $input2['created_at'] = date('Y-m-d H:i:s');
                        TbNotifAuthorModel::insert($input2);
                    }
                } else {
                    $input2['judul'] = "My Question - The author replied to your question";
                    $input2['stt_notif'] = "MY QUESTION";
                    $input2['id_reviewer'] = $dt_qa->id_reviewer;
                    $input2['pesan'] = strip_tags($request->et_question);
                    $input2['id_jurnal'] = $dt->id_jurnal;
                    $input2['id_jurnal_qa'] = $tx_kd;
                    $input2['created_at'] = date('Y-m-d H:i:s');
                    TbNotifReviewerModel::insert($input2);
                }
            } else if (Session::has('id_reviewer')) {
                $id_author_corres = $dt->id_author_corresponding;
                if (empty($id_author_corres)){
                    $id_author_corres = $dt->id_author;
                }
                $input2['judul'] = "QA Forum - Other writers ask back about your journal ";
                $input2['id_author'] = $id_author_corres;
                $input2['stt_notif'] = "QA FORUM";
                $input2['pesan'] = strip_tags($request->et_question);
                $input2['id_jurnal'] = $dt->id_jurnal;
                $input2['id_jurnal_qa'] = $tx_kd;
                $input2['created_at'] = date('Y-m-d H:i:s');
                TbNotifAuthorModel::insert($input2);
            }
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
        }
    }
    public function updateJournalConfirmation(Request $request){
        $where['no_abstrak'] = $request->no_abs;
        $dt_jurnal = TbJurnalModel::where($where)->first();
        $jurnal = $dt_jurnal->judul_jurnal;
        if ($request->type=="TERIMA"){
            $event = TbEventModel::where('stt_aktif',1)->first();
            $id_event = $event->id_event;
            $setting = TbSettingModel::where('id_event',$id_event)->first();
            $kontak_nomor = "";
            $kontak = TbKontakModel::where('judul',"Whatsapp");
            if ($kontak->count() > 0) {
                $kontak_nomor = $kontak->first()->isi;
            }

            $information = '<br/><br/>Best Regards,<br/>
                            Organizing Committee TIC-MS 2022 Conference<br/>Politeknik Harapan Bersama<br/>
                            Kampus 1: Jl. Mataram No. 9 Tegal, Indonesia<br/>Kampus 2: Jl. Dewi Sartika No. 71 Tegal, Indonesia<br/>
                            Email     : tic@poltektegal.ac.id<br/>
                            Website : https://tic.poltektegal.ac.id/<br/>
                            CP         : '.$kontak_nomor;

            $update['stt_jurnal'] = "ABSTRACT ACCEPTED";
            $message_confirm = 'Your abstract entitled <b>'.$jurnal.'</b> has ben reviewed and accepted to be presented virtually at '.$event->event.' conference held on '.Helpers::setTglSurat($setting->tgl_conference).'. Please check your email to see notification or <a href="'.url('author/my_journal/detail?abs='.$dt_jurnal->no_abstrak).'">LoA File (Click Here)</a> to download The LOA (LETTER OF ACCEPTANCE) file attachment.';
        } else {
            $update['stt_jurnal'] = "NOT ACCEPTED";
            $message_confirm = "Your abstract entitled <b>".$jurnal."</b> is rejected.";
        }
        $update['updated_at'] = date('Y-m-d H:i:s');
        $stmt = TbJurnalModel::where($where)->update($update);
        if ($stmt){
            $id_author_corresponding = $dt_jurnal->id_author_corresponding;
            if (empty($id_author_corresponding)){
                $id_author_corresponding = $dt_jurnal->id_author;
            }
            $message_confirm = 'Your abstract entitled <b>'.$jurnal.'</b> has ben reviewed and accepted to be presented virtually at '.$event->event.' conference held on '.Helpers::setTglSurat($setting->tgl_conference).'. Please check your email to see notification or <a href="'.url('download_loa?abs='.$dt_jurnal->no_abstrak).'">LoA File (Click Here)</a> to download The LOA (LETTER OF ACCEPTANCE) file attachment.';
            $input_notif['id_jurnal'] = $id_jurnal = $dt_jurnal->id_jurnal;
            $input_notif['id_author'] = $id_author_corresponding;
            $input_notif['judul'] = "Abstract Confirmation";
            $input_notif['pesan'] = $message_confirm;
            $input_notif['stt_notif'] = "JURNAL";
            $input_notif['created_at'] = date('Y-m-d H:i:s');
            TbNotifAuthorModel::insert($input_notif);

            $dt_author_data = TbJurnalAuthorModel::where('id_jurnal',$id_jurnal)->get();
            foreach ($dt_author_data as $item_2){
                $to_name = $item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang;
                $to_email = $item_2->email;
                $to_body = $message_confirm.$information;
                $data_email = array('name'=>$to_email, "body" => $to_body);

                Mail::send('other.mail', $data_email, function($message) use ($to_name, $to_email) {
                    $message->to($to_email, $to_name)
                        ->subject('TIC Politeknik Harapan Bersama');
                    $message->from('tic@poltektegal.ac.id','TIC Politeknik Harapan Bersama');
                });
            }
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_save]);
        }
    }

    public function detailTypePayment(Request $request) {
        $where['id_jenis_pembayaran'] = Helpers::dekrip($request->kd_bank);
        $stmt = TbJenisPembayaranModel::select('nomor_jenis_pembayaran','an_jenis_pembayaran')->where($where)->first();
        if ($stmt) {
            $data['id'] = Helpers::enkrip($stmt->id_jenis_pembayaran);
            $data['nomor_jenis_pembayaran'] = $stmt->nomor_jenis_pembayaran;
            $data['an_jenis_pembayaran'] = $stmt->an_jenis_pembayaran;
            return response()->json(['status' => "OK",'data' => $data]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_get]);
        }
    }

    public function updateMyJournalPaymentAdmin(Request $request) {
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
            $update['stt_pembayaran'] = "PAID";
            $update['stt_pembayaran_konfirmasi'] = "ACCEPTED";
            $update['stt_pembayaran_date_upload'] = date('Y-m-d H:i:s');
            $update['updated_at'] = date('Y-m-d H:i:s');
            $stmt = TbJurnalModel::where('no_abstrak',$request->no_abs)->update($update);
            if ($stmt){
                $ft_lama = $request->file_pembayaran;
                if ($ft_lama != "0"){
                    File::delete(public_path("/upload/pembayaran/".$ft_lama));
                }
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

    public function download(Request $request)
    {
        $type = $request->type;
        $file = $request->file;
        if ($type=="jurnal_pendukung"){
            $name = explode('.',$file,2)[0];
            $path = "upload/jurnal_pendukung/".$file;
        } else if ($type=="revision_author_reviewer") {
            $judul_jurnal = TbJurnalModel::where('no_abstrak',$request->abs)->first()->judul_jurnal;
            $path = "upload/jurnal_revisi/".$file;
            $name = $judul_jurnal."-".$file;
        } else if ($type=="jurnal") {
            $judul_jurnal = TbJurnalModel::where('no_abstrak',$request->abs)->first()->judul_jurnal;
            $path = "upload/jurnal/".$file;
            $name = $judul_jurnal;
        } else if ($type=="payment") {
            $judul_jurnal = TbJurnalModel::where('no_abstrak',$request->abs)->first()->judul_jurnal;
            $path = "upload/pembayaran/".$file;
            $name = "Pembayaran - ".$judul_jurnal;
        } else if ($type=="event") {
            $path = "upload/event/".$file;
            $name = "Pamphlet ".$request->name;
        } else if ($type=="sub_template") {
            $path = "upload/sub/template/".$file;
            $name = "Template Journal Sub ".$request->name;
        } else if ($type=="guideline") {
            if ($request->us == "author") {
                $path = "upload/manual_book_author.pdf";
                $name = "Guideline Author";
            }
        }

        $filePath = public_path($path);
        $headers = ['Content-Type: '. mime_content_type($filePath)];
        $fileName = $name.".".pathinfo($filePath, PATHINFO_EXTENSION);;
        return response()->download($filePath, $fileName, $headers);
    }

    public function download_loa(Request $request) {
        $jurnalModel = TbJurnalModel::where('no_abstrak',$request->abs)->first();
        $id_jurnal = $jurnalModel->id_jurnal;
        $dt_author_nama = "";
        $no_author = 1;
        $dt_author_ttl_ = $dt_author_data_ = TbJurnalAuthorModel::where(array('id_jurnal'=>$id_jurnal,'del_flage'=>0));
        $dt_author_ttl = $dt_author_ttl_->count();
        $dt_author_data = $dt_author_data_->get();
        foreach ($dt_author_data as $item_2){
            if ($no_author==1){
                $dt_author_nama = ucwords(strtolower($item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang));
            } else {
                if ($dt_author_ttl > 2){
                    if ($no_author == ($dt_author_ttl-1)){
                        $dt_author_nama .= ", ".ucwords(strtolower($item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang));
                    } else {
                        $dt_author_nama .= ", ".ucwords(strtolower($item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang));
                    }
                } else {
                    $dt_author_nama .= ", ".ucwords(strtolower($item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang));
                }
            }
            $no_author++;
        }
        $event = TbEventModel::where('stt_aktif',1)->first();
        $id_event = $event->id_event;
        $bank = TbJenisPembayaranModel::where(array('jenis_pembayaran'=>"BANK",'id_event'=>$id_event,'del_flage'=>0,'stt_data'=>"PUBLISH"))->first();
        $setting = TbSettingModel::where('id_event',$id_event)->first();

        $template = asset('img/template_loa.jpg');
        $fpdf = new Fpdf;
        $fpdf->SetMargins(10,10,10);
        $fpdf->AddPage('P',"A4");
        $fpdf->SetFont('Times', '', 12);
        $fpdf->Image("$template",0,0,210,300);
        $fpdf->SetMargins(15,15,15);
        $fpdf->cell(0,35,"",0,1);
        $fpdf->Cell(0,0,"Date : ".Helpers::setTglSurat(date('Y-m-d')),0,1,'L');
        $fpdf->cell(0,30,"",0,1);
        $fpdf->SetFont('Times','BU','14');
        $fpdf->Cell(0,5,"LETTER OF ACCEPTANCE",0,1,'C');
        $fpdf->Cell(0,20,"",0,1);
        $fpdf->SetFont('Times','','12');
        $fpdf->MultiCell(0,6,"Dear Author(s): ".$dt_author_nama,0,'J',false);
        $fpdf->Cell(0,5,"",0,1);
        $fpdf->MultiCell(0,6,"On behalf of the 1st ".$event->event." committee, we are pleased to inform you that your abstract, entitled:",0,'J',false);
        $fpdf->SetFont('Times','BU','12');
        $fpdf->Cell(0,5,"",0,1);
        $fpdf->MultiCell(0,10,strtoupper($jurnalModel->judul_jurnal),0,"C",false);
        $fpdf->Cell(0,5,"",0,1);
        $fpdf->SetFont('Times','','12');
        $fpdf->MultiCell(0,6,"has been reviewed and accepted to be presented virtually at ".$event->event." conference held on ".Helpers::setTglSurat($setting->tgl_conference).".",0,'J',false);
        $fpdf->Cell(0,5,"",0,1);
        $fpdf->MultiCell(0,6,"Please make the payment for registration fee to Bank Account: ".$bank->nama_jenis_pembayaran." (".$bank->nomor_jenis_pembayaran.") a/n : ".$bank->an_jenis_pembayaran." before the deadline ".Helpers::setTglSurat($setting->tgl_akhir_pembayaran).". Visit our website for further information.",0,'J',false);
        $fpdf->Cell(0,15,"",0,1);
        $fpdf->Cell(0,6,"Thank you",0,1,'L');
        $fpdf->Cell(0,6,"Best Regards,",0,1,'L');
        if (empty($setting->ketua_file_ttd)) {
        $fpdf->SetTextColor(151,151,151);
            $fpdf->Cell(0,30,"TTD Ketua Belum Tersedia",0,1,'L');
            $fpdf->SetTextColor(0,0,0);
        } else {
            $xPos=$fpdf->GetX();
            $file_ttd = asset('/upload/ttd/'.$setting->ketua_file_ttd);
            $fpdf->Image("$file_ttd",$xPos,null,80);
        }
        $yPos=$fpdf->GetY();
        $fpdf->SetXY(15 , $yPos-16);
        $fpdf->Cell(0,6,$setting->ketua_nama,0,1,'L');
        $fpdf->Cell(0,6,$event->event." Conference Chair",0,1,'L');

        $replace_name = array('\'',':','/','*','?','<','>','|');
        $judul_jurnal = $jurnalModel->judul_jurnal;
        $judul_jurnal = str_replace(array("\n", "\r"), '', $judul_jurnal);
        $judul_jurnal = str_replace($replace_name,"",strip_tags($judul_jurnal));
        $fpdf->Output('I','LoA (Letter Of Acceptance) Journal '.(string)$judul_jurnal.'.pdf');
        exit;
    }

    public function download_loi(Request $request) {
        $jurnalModel = TbJurnalModel::where('no_abstrak',$request->abs)->first();
        $id_jurnal = $jurnalModel->id_jurnal;
        $dt_author_nama = "";
        $no_author = 1;
        $dt_author_ttl_ = $dt_author_data_ = TbJurnalAuthorModel::where(array('id_jurnal'=>$id_jurnal,'del_flage'=>0));
        $dt_author_ttl = $dt_author_ttl_->count();
        $dt_author_data = $dt_author_data_->get();
        foreach ($dt_author_data as $item_2){
            if ($no_author==1){
                $dt_author_nama = $item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang;
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
            }
            $no_author++;
        }
        $event = TbEventModel::where('stt_aktif',1)->first();
        $id_event = $event->id_event;
        $bank = TbJenisPembayaranModel::where(array('jenis_pembayaran'=>"BANK",'id_event'=>$id_event))->first();
        $setting = TbSettingModel::where('id_event',$id_event)->first();

        $template = asset('img/template_loa.jpg');
        $fpdf = new Fpdf;
        $fpdf->SetMargins(10,10,10);
        $fpdf->AddPage('P',"A4");
        $fpdf->SetFont('Times', '', 12);
        $fpdf->Image("$template",0,0,210,300);
        $fpdf->SetMargins(15,15,15);
        $fpdf->cell(0,35,"",0,1);
        $fpdf->Cell(0,0,"Date : ".Helpers::setTglSurat(date('Y-m-d')),0,1,'L');
        $fpdf->cell(0,30,"",0,1);
        $fpdf->SetFont('Times','BU','14');
        $fpdf->Cell(0,5,"LETTER OF INVITATION",0,1,'C');
        $fpdf->Cell(0,20,"",0,1);
        $fpdf->SetFont('Times','','12');
        $fpdf->MultiCell(0,6,"Dear Author(s): ".$dt_author_nama,0,'J',false);
        $fpdf->Cell(0,5,"",0,1);
        $fpdf->MultiCell(0,6,"On behalf of the 1st ".$event->event." committee, we are pleased to invite you to attend 1st Tegal Vitual International Conference on Multidisciplinary Studies ".$event->event." which will be held online on ".
            Helpers::setTglSurat($setting->tgl_conference).". See the rundown in the attachment for more details.",0,'J',false);
        $fpdf->Cell(0,5,"",0,1);
        $fpdf->Cell(35,5,"Day/Date", 0,0);
        $fpdf->Cell(5,5,":", 0,0, 'C');
        $fpdf->Cell(0,5,Helpers::setTglSuratFormal($setting->tgl_conference), 0,1);
        $fpdf->Cell(35,5,"Time", 0,0);
        $fpdf->Cell(5,5,":", 0,0, 'C');
        $fpdf->Cell(0,5,"08.00-16.00 Western Indonesia Time (GMT+7)", 0,1);
        $fpdf->Cell(35,5,"Link Zoom", 0,0);
        $fpdf->Cell(5,5,":", 0,0, 'C');
        $fpdf->Cell(0,5,"", 0,1);
        $fpdf->Cell(35,5,"Meeting ID", 0,0);
        $fpdf->Cell(5,5,":", 0,0, 'C');
        $fpdf->Cell(0,5,"", 0,1);
        $fpdf->Cell(35,5,"Passcode", 0,0);
        $fpdf->Cell(5,5,":", 0,0, 'C');
        $fpdf->Cell(0,5,"", 0,1);
        $fpdf->Cell(0,5,"",0,1);
        $fpdf->MultiCell(0,6,"Furthermore, please use the virtual background that has been provided. Link for virtual background:",0,'J',false);
        $fpdf->MultiCell(0,6,"Please join the meeting 10 minutes before the program starts. Please confirm if you have received this information. Thank you for your cooperation.",0,'J',false);
        $fpdf->Cell(0,15,"",0,1);
        $fpdf->Cell(0,6,"Sincerely Yours",0,1,'L');
        if (empty($setting->ketua_file_ttd)) {
        $fpdf->SetTextColor(151,151,151);
            $fpdf->Cell(0,30,"TTD Ketua Belum Tersedia",0,1,'L');
            $fpdf->SetTextColor(0,0,0);
        } else {
            $xPos=$fpdf->GetX();
            $file_ttd = asset('/upload/ttd/'.$setting->ketua_file_ttd);
            $fpdf->Image("$file_ttd",$xPos,null,30);
        }
        $fpdf->Cell(0,6,$setting->ketua_nama,0,1,'L');
        $fpdf->Cell(0,6,$event->event." Conference Chair",0,1,'L');

        $replace_name = array('\'',':','/','*','?','<','>','|');
        $judul_jurnal = $jurnalModel->judul_jurnal;
        $judul_jurnal = str_replace(array("\n", "\r"), '', $judul_jurnal);
        $judul_jurnal = str_replace($replace_name,"",strip_tags($judul_jurnal));
        $fpdf->Output('I','LoI (Letter Of Invitation) Journal '.(string)$judul_jurnal.'.pdf');
        exit;
    }

    public function download_payment_receipt(Request $request) {
        $payment = array();
        $jurnalModel = TbJurnalModel::where('no_abstrak',$request->abs)->first();
        $authorModel = TbAuthorModel::where('id_author',$jurnalModel->id_author)->first();
        $cohostModel = TbCoHostModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();

        array_push($payment,"Politeknik Harapan Bersama");
        foreach ($cohostModel as $key => $item) {
            array_push($payment,$item->nama);
        }
        $id_jurnal = $jurnalModel->id_jurnal;
        $dt_author_nama = "";
        $no_author = 1;
        $dt_author_ttl_ = $dt_author_data_ = TbJurnalAuthorModel::where(array('id_jurnal'=>$id_jurnal,'del_flage'=>0));
        $dt_author_ttl = $dt_author_ttl_->count();
        $dt_author_data = $dt_author_data_->get();
        foreach ($dt_author_data as $item_2){
            if ($no_author==1){
                $dt_author_nama = $item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang;
            } else {
                if ($dt_author_ttl > 2){
                    if ($no_author == ($dt_author_ttl-1)){
                        $dt_author_nama .= ", ".$item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang;
                    } else {
                        $dt_author_nama .= ", ".$item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang;
                    }
                } else {
                    $dt_author_nama .= ", ".$item_2->nama_depan." ".$item_2->nama_tengah." ".$item_2->nama_belakang;
                }
            }
            $no_author++;
        }
        $event = TbEventModel::where('stt_aktif',1)->first();
        $id_event = $event->id_event;
        $setting = TbSettingModel::where('id_event',$id_event)->first();

        $template = asset('img/template_loa.jpg');
        $fpdf = new Fpdf;
        $fpdf->SetMargins(10,10,10);
        $fpdf->AddPage('P',"A4");
        $fpdf->SetFont('Times', '', 12);
        $fpdf->Image("$template",0,0,210,300);
        $fpdf->SetMargins(15,15,15);
        $fpdf->cell(0,35,"",0,1);
        $fpdf->Cell(0,0,"Date : ".Helpers::setTglSurat(date('Y-m-d')),0,1,'L');
        $fpdf->cell(0,30,"",0,1);
        $fpdf->SetFont('Times','BU','14');
        $fpdf->Cell(0,5,"PAYMENT RECEIPT",0,1,'C');
        $fpdf->Cell(0,20,"",0,1);
        $fpdf->SetFont('Times','','12');
        $fpdf->MultiCell(0,6,"The Organizing Committee of ".$event->event." acknowledges the following payment for registration fee,",0,'J',false);
        $fpdf->Cell(0,5,"",0,1);
        $fpdf->Cell(35,5,"     Article Title", 0,0);
        $fpdf->Cell(5,5,":", 0,0, 'C');
        $fpdf->MultiCell(0,5,$jurnalModel->judul_jurnal, 0);
        $fpdf->Cell(35,5,"     Author(s)", 0,0);
        $fpdf->Cell(5,5,":", 0,0, 'C');
        $fpdf->MultiCell(0,5,$dt_author_nama, 0,'J',false);
        $fpdf->Cell(35,5,"     Paid Amount", 0,0);
        $fpdf->Cell(5,5,":", 0,0, 'C');

        $harga = $setting->harga_jurnal_lokal;
        foreach ($payment as $item) {
            if ($authorModel->institusi == $item) {
                $harga = "1500000";
            }
        }

        $fpdf->Cell(0,5,"IDR ".str_replace(",",".",number_format($harga)), 0,1);
        $fpdf->Cell(35,5,"     Paid By", 0,0);
        $fpdf->Cell(5,5,":", 0,0, 'C');
        $fpdf->Cell(0,5,$jurnalModel->pembayaran_bank." a/n ".$jurnalModel->pembayaran_an, 0,1);
        $fpdf->Cell(0,5,"",0,1);
        $fpdf->Cell(35,5,"Thank You.", 0,0);
        $fpdf->Cell(0,25,"",0,1);
        $fpdf->Cell(0,6,"Best Regards,",0,1,'L');
        if (empty($setting->bendahara_file_ttd)) {
            $fpdf->SetTextColor(151,151,151);
            $fpdf->Cell(0,30,"TTD Bendahara Belum Tersedia",0,1,'L');
            $fpdf->SetTextColor(0,0,0);
        } else {
            $xPos=$fpdf->GetX();
            $file_ttd = asset('/upload/ttd/'.$setting->bendahara_file_ttd);
            $fpdf->Image("$file_ttd",$xPos,null,60);
        }
        $fpdf->SetFont('Times','BU','12');
        $fpdf->Cell(0,6,$setting->bendahara_nama,0,1,'L');
        $fpdf->SetFont('Times','','12');
        $fpdf->Cell(0,6,"Conference Treasurer",0,1,'L');

        $replace_name = array('\'',':','/','*','?','<','>','|');
        $judul_jurnal = $jurnalModel->judul_jurnal;
        $judul_jurnal = str_replace(array("\n", "\r"), '', $judul_jurnal);
        $judul_jurnal = str_replace($replace_name,"",strip_tags($judul_jurnal));
        $fpdf->Output('I','Payment Receipt Journal '.(string)$judul_jurnal.'.pdf');
        exit;
    }

    public function deleteData(Request $request){
        $type = $request->str;
        $id = $request->id;
        $stmt = false;
        $update = array('deleted_at'=>date('Y-m-d H:i:s'),'del_flage'=>1);
        if ($type!="my_journal") {
            $id = Helpers::dekrip($id);
        }
        if ($type=="author"){
            $stmt = TbAuthorModel::where('id_author',$id)->update($update);
        } else if ($type=="contact"){
            $stmt = TbKontakModel::where('id_kontak',$id)->update($update);
        } else if ($type=="country"){
            $stmt = TbNegaraModel::where('id_negara',$id)->update($update);
        } else if ($type=="degree"){
            $stmt = TbGelarModel::where('id_gelar',$id)->update($update);
        } else if ($type=="events"){
            $stmt = TbEventModel::where('id_event',$id)->update($update);
        } else if ($type=="notification_admin"){
            $stmt = TbNotifAdminModel::where('id_notif_admin',$id)->update($update);
        } else if ($type=="reviewers"){
            $stmt = TbReviewerModel::where('id_reviewer',$id)->update($update);
        } else if ($type=="sosmed"){
            $stmt = TbSosmedModel::where('id_sosmed',$id)->update($update);
        } else if ($type=="co_host"){
            $stmt = TbCoHostModel::where('id_cohost',$id)->update($update);
        } else if ($type=="indexing"){
            $stmt = TbIndexingModel::where('id_indexing',$id)->update($update);
        } else if ($type=="type_payment"){
            $stmt = TbJenisPembayaranModel::where('id_jenis_pembayaran',$id)->update($update);
        } else if ($type=="kerjasama"){
            $stmt = TbKerjaSamaModel::where('id_kerjasama',$id)->update($update);
        } else if ($type=="keynote_speaker"){
            $stmt = TbKeynoteSpeakerModel::where('id_keynote_speaker',$id)->update($update);
        } else if ($type=="invited_speaker"){
            $stmt = TbInvitedSpeakerModel::where('id_invited_speaker',$id)->update($update);
        } else if ($type=="sub"){
            $stmt = TbSubModel::where('id_sub',$id)->update($update);
        } else if ($type=="scope"){
            $stmt = TbScopeModel::where('id_scope',$id)->update($update);
        } else if ($type=="vc"){
            $stmt = TbVCModel::where('id_vc',$id)->update($update);
        } else if ($type=="timeline"){
            $stmt = TbTimelineModel::where('id_timeline',$id)->update($update);
        } else if ($type=="my_question"){
            $stmt = TbJurnalQAModel::where('id_jurnal_qa',$id)->update($update);
        } else if ($type=="notification_reviewer"){
            $stmt = TbNotifReviewerModel::where('id_notif_reviewer',$id)->update($update);
        } else if ($type=="jurnal_revisi"){
            $stmt = TbJurnalRevisiModel::where('id_jurnal_revisi',$id)->update($update);
        } else if ($type=="my_journal"){
            $stmt = TbJurnalModel::where('id_jurnal',$id)->update($update);
        } else if ($type=="notification_author"){
            $stmt = TbNotifAuthorModel::where('id_notif_author',$id)->update($update);
        } else if ($type=="notification_participan"){
            $stmt = TbNotifParticipanModel::where('id_notif_participan',$id)->update($update);
        }

        if ($stmt){
            return response()->json(['status' => "OK"]);
        } else {
            return response()->json(['status' => "ERROR",'message'=>$this->message_failed_delete]);
        }
    }
}
