<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\TbEventModel;
use App\Models\TbGelarModel;
use App\Models\TbJurnalAuthorModel;
use App\Models\TbJurnalModel;
use App\Models\TbJurnalQAModel;
use App\Models\TbNegaraModel;
use App\Models\TbScopeModel;
use App\Models\TbSettingModel;
use App\Models\TbSubModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthorController extends Controller {

    public function __construct() {
        $this->middleware(function ($request, $next){
            if (!Session::has('tic-author')){
                return redirect(url('/'));
            }
            return $next($request);
        });
    }

    public function index(){
        $id = Session::get('id_author');
        $data['ttl_all_journal'] = TbJurnalModel::where('stt_jurnal',"PUBLISH")->count();
        $data['ttl_my_journal'] = TbJurnalModel::where(array('id_author'=>$id))->count();
        $data['ttl_qa_forum'] = TbJurnalQAModel::select('tb_jurnal_qa')
            ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_qa.id_jurnal')
            ->where(array('tb_jurnal.id_author'=>$id,'tb_jurnal.del_flage'=>0))->count();
        $data['ttl_my_question'] = TbJurnalQAModel::where(array('id_author'=>$id))->count();
        return view('author/index',$data);
    }
    public function notification(){
        return view('author/notification');
    }
    public function journal(){
        return view('author/journal');
    }
    public function my_journal(){
        $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
        $tgl_abstract = TbSettingModel::where('id_event',$id_event)->first()->tgl_akhir_abstrak;
        $data['abstract_button'] = date('Y-m-d') <= $tgl_abstract;
        $data['abstract_tgl'] = $tgl_abstract;
        return view('author/my_journal',$data);
    }
    public function my_journal_add(){
        $option = null;
        $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
        $stmt = TbSubModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0,'id_event'=>$id_event))->get();
        foreach ($stmt as $item){
            $option .= '<optgroup label="'.$item->sub.'">';
            $stmt_2 = TbScopeModel::where(array('id_sub'=>$item->id_sub,'stt_data'=>"PUBLISH",'del_flage'=>0))->get();
            foreach ($stmt_2 as $item_2){
                $option .= '<option value="'.$item_2->id_scope.'">'.$item_2->scope.'</option>';
            }
            $option .= '</optgroup>';
        }
        $data['dt_scope'] = $option;
        $data['dt_negara'] = TbNegaraModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();
        return view('author/my_journal_add',$data);
    }
    public function my_journal_detail(){
        return view('author/my_journal_detail');
    }
    public function my_journal_edit(Request $request){
        $option = null;
        $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
        $stmt = TbSubModel::select('tb_scope.*','tb_sub.sub')
            ->join('tb_scope','tb_scope.id_sub','=','tb_sub.id_sub')
            ->where(array('tb_sub.stt_data'=>"PUBLISH",'tb_sub.del_flage'=>0,'tb_sub.id_event'=>$id_event))->get();
        $data['dt_scope'] = $stmt;
        return view('author/my_journal_edit',$data);
    }
    public function my_journal_edit_metadata(){
        $data['dt_negara'] = TbNegaraModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();
        return view('author/my_journal_edit_metadata',$data);
    }
    public function videos(){
        return view('author/videos');
    }
    public function videos_abstract(Request $request){
        $stmt = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_jurnal_author.nama_depan','tb_jurnal_author.nama_tengah','tb_jurnal_author.nama_belakang','tb_author.no_author','tb_sub.slug','tb_event.event','tb_event.tahun_event')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->join('tb_jurnal_author','tb_jurnal_author.id_jurnal_author','=','tb_jurnal.id_jurnal_author','LEFT')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_author.id_author','LEFT')
            ->where(array('tb_jurnal.no_abstrak'=>$request->abs))->first();
        if (empty($stmt->nama_depan)) {
            $cor = TbJurnalModel::select('tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang')
                ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author')->where('tb_jurnal.no_abstrak',$request->abs)->first();
            $data['corresponding'] = $cor->nama_depan." ".$cor->nama_tengah." ".$cor->nama_belakang;
        } else {
            $data['corresponding'] = $stmt->nama_depan." ".$stmt->nama_tengah." ".$stmt->nama_belakang;
        }
        $data['detail'] = $stmt;
        $dt_author_nama = "";
        $dt_author_email = "";
        $dt_author_institusi = "";
        $no_author = 1;
        $dt_author_ttl = TbJurnalAuthorModel::where('id_jurnal',$stmt->id_jurnal)->count();
        $dt_author_data = TbJurnalAuthorModel::where('id_jurnal',$stmt->id_jurnal)->get();
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
        $data['author_nama'] = $dt_author_nama;
        $data['author_email'] = $dt_author_email;
        $data['author_institusi'] = $dt_author_institusi;
        return view('author/videos_abstract',$data);
    }
    public function videos_forum(Request $request){
        $stmt = TbJurnalModel::select('tb_jurnal.*','tb_jurnal_author.nama_depan','tb_jurnal_author.nama_tengah','tb_jurnal_author.nama_belakang','tb_author.no_author','tb_sub.slug','tb_event.event','tb_event.tahun_event')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->join('tb_jurnal_author','tb_jurnal_author.id_jurnal_author','=','tb_jurnal.id_jurnal_author','LEFT')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_author.id_author','LEFT')
            ->where(array('tb_jurnal.no_abstrak'=>$request->abs))->first();
        $data['detail'] = $stmt;
        $dt_author_nama = "";
        $no_author = 1;
        $dt_author_ttl = TbJurnalAuthorModel::where('id_jurnal',$stmt->id_jurnal)->count();
        $dt_author_data = TbJurnalAuthorModel::where('id_jurnal',$stmt->id_jurnal)->get();
        foreach ($dt_author_data as $item_2){
            if ($no_author==1){
                $dt_author_nama = strtoupper($item_2->nama_depan)." ".strtoupper($item_2->nama_tengah)." ".strtoupper($item_2->nama_belakang);
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
            }
            $no_author++;
        }
        $data['author_nama'] = $dt_author_nama;
        return view('author/videos_forum',$data);
    }
    public function my_question(){
        return view('author/my_question');
    }
    public function my_question_detail(){
        return view('author/my_question_detail');
    }
    public function qa_forum(){
        return view('author/qa_forum');
    }
    public function qa_forum_detail(){
        return view('author/qa_forum_detail');
    }
    public function revision(){
        $event = TbEventModel::where(array('stt_aktif'=>1,'del_flage'=>0))->first();
        $setting = TbSettingModel::where('id_event',$event->id_event)->first();
        $data['tgl_mulai'] = $tgl_mulai = $setting->tgl_mulai_revisi;
        $data['tgl_akhir'] = $tgl_akhir = $setting->tgl_akhir_revisi;
        return view('author/revision',$data);
    }
    public function revision_detail(){
        $event = TbEventModel::where(array('stt_aktif'=>1,'del_flage'=>0))->first();
        $setting = TbSettingModel::where('id_event',$event->id_event)->first();
        $data['tgl_mulai'] = $tgl_mulai = $setting->tgl_mulai_revisi;
        $data['tgl_akhir'] = $tgl_akhir = $setting->tgl_akhir_revisi;
        return view('author/revision_detail',$data);
    }
    public function account(){
        return view('author/account');
    }
    public function account_edit(){
        $data['dt_gelar'] = TbGelarModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();
        $data['dt_negara'] = TbNegaraModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();
        return view('author/account_edit',$data);
    }
    public function modal(Request $request) {
        $page = $request->page;
        $str1 = $request->str1;
        $str2 = $request->str2;
        if ($page == "viewIMG"){
            $data['file'] = $str1;
        } elseif ($page == "upload-journal"){
            $data['no_abs'] = Helpers::enkrip($str1);
        }  else if ($page == "payment-journal"){
            $stmt = TbJurnalModel::where('no_abstrak',$str1)->first();
            $data['no_abs'] = $str1;
            $data['id'] = $str2;
            $data['file_pembayaran'] = $stmt->file_pembayaran;
            $data['no_abstrak'] = str_replace("TIC-","",$stmt->no_abstrak);
        } else if ($page == "payment-view") {
            $stmt = TbJurnalModel::where('no_abstrak',$str1)->first();
            $data['data'] = $stmt;
        } else if ($page == "journal-edit-video"){
            $data['data'] = TbJurnalModel::where('no_abstrak',$str1)->first();
        } elseif ($page == "revision-author"){
            $data['no_abs'] = $str1;
            $data['id'] = $str2;
        }
        $data['page'] = $page;
        return view("other/modal_author",$data);
    }
    public function logout(Request $request){
        $request->session()->flush();
        return redirect(url('/'));
    }
}
