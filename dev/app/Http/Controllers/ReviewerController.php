<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Models\TbEventModel;
use App\Models\TbJurnalAuthorModel;
use App\Models\TbJurnalModel;
use App\Models\TbJurnalQAModel;
use App\Models\TbSettingModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewerController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            if (!Session::has('tic-reviewer')){
                return redirect(url('/'));
            }
            return $next($request);
        });
    }
    public function index(){
        $data['ttl_my_revision'] = TbJurnalModel::where(array('id_reviewer'=>Session::get('id_reviewer')))->count();
        $data['ttl_my_question'] = TbJurnalQAModel::where(array('id_reviewer'=>Session::get('id_reviewer')))->count();
        return view('reviewer/index',$data);
    }
    public function notification(){
        return view('reviewer/notification');
    }
    public function journal(){
        return view('reviewer/journal');
    }
    public function journal_detail(){
        return view('reviewer/journal_detail');
    }
    public function abstract(){
        return view('reviewer/abstract');
    }
    public function videos()
    {
        return view('reviewer/videos');
    }
    public function videos_abstract(Request $request)
    {
        $stmt = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_jurnal_author.nama_depan','tb_jurnal_author.nama_tengah','tb_jurnal_author.nama_belakang','tb_author.no_author','tb_sub.slug','tb_event.event','tb_event.tahun_event')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->join('tb_jurnal_author','tb_jurnal_author.id_jurnal_author','=','tb_jurnal.id_jurnal_author','LEFT')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_author.id_author','LEFT')
            ->where(array('tb_jurnal.no_abstrak'=>$request->abs))->first();
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
        return view('reviewer/videos_abstract',$data);
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
        return view('reviewer/videos_forum',$data);
    }
    public function my_question(){
        return view('reviewer/my_question');
    }
    public function my_question_detail(){
        return view('reviewer/my_question_detail');
    }
    public function revision(){
        return view('reviewer/revision');
    }
    public function revision_detail(){
        return view('reviewer/revision_detail');
    }
    public function my_review(){
        $event = TbEventModel::where(array('stt_aktif'=>1,'del_flage'=>0))->first();
        $setting = TbSettingModel::where('id_event',$event->id_event)->first();
        $data['tgl_mulai'] = $tgl_mulai = $setting->tgl_mulai_mereview;
        $data['tgl_akhir'] = $tgl_akhir = $setting->tgl_akhir_mereview;
        return view('reviewer/my_review',$data);
    }
    public function my_review_detail(){
        $event = TbEventModel::where(array('stt_aktif'=>1,'del_flage'=>0))->first();
        $setting = TbSettingModel::where('id_event',$event->id_event)->first();
        $data['tgl_mulai'] = $tgl_mulai = $setting->tgl_mulai_mereview;
        $data['tgl_akhir'] = $tgl_akhir = $setting->tgl_akhir_mereview;
        return view('reviewer/my_review_detail',$data);
    }
    public function account(){
        return view('reviewer/account');
    }
    public function account_edit(){
        return view('reviewer/account_edit');
    }
    public function modal(Request $request)
    {
        $page = $request->page;
        $str1 = $request->str1;
        $str2 = $request->str2;
        if ($page == "viewIMG"){
            $data['file'] = $str1;
        } else if ($page == "revision-reviewer") {
            $data['kode'] = Helpers::enkrip($str1);
        }
        $data['page'] = $page;
        return view("other/modal_reviewer",$data);
    }
    public function logout(Request $request){
        $request->session()->flush();
        return redirect(url('/'));
    }
}
