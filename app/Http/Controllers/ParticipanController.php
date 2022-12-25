<?php

namespace App\Http\Controllers;

use App\Models\TbGelarModel;
use App\Models\TbJurnalAuthorModel;
use App\Models\TbJurnalModel;
use App\Models\TbNegaraModel;
use App\Models\TbParticipanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ParticipanController extends Controller
{
    public function __construct() {
        $this->middleware(function ($request, $next){
            if (!Session::has('tic-participan')){
                return redirect(url('/'));
            }
            return $next($request);
        });
    }

    public function index(){
        $data['ttl_journal'] = TbJurnalModel::where(array('stt_jurnal'=>"ACCEPTED",'del_flage'=>0))->count();
        $data['ttl_videos'] = TbJurnalModel::where(array('stt_jurnal'=>"ACCEPTED",'del_flage'=>0))->whereNotNull('link_video')->count();
        return view('participan/index',$data);
    }

    public function notification(){
        return view('participan/notification');
    }

    public function payment(){
        return view('participan/payment');
    }
    public function journal(){
        $data['stt_pembayaran'] = TbParticipanModel::where('id_participan',Session::get('id_participan'))->first()->stt_pembayaran == "PAID" ? true : false;
        return view('participan/journal',$data);
    }
    public function videos()
    {
        $data['stt_pembayaran'] = TbParticipanModel::where('id_participan',Session::get('id_participan'))->first()->stt_pembayaran == "PAID" ? true : false;
        return view('participan/videos',$data);
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
        return view('participan/videos_abstract',$data);
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
        return view('participan/videos_forum',$data);
    }
    public function account(){
        return view('participan/account');
    }
    public function account_edit(){
        $data['dt_gelar'] = TbGelarModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();
        $data['dt_negara'] = TbNegaraModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();
        return view('participan/account_edit',$data);
    }
    public function modal(Request $request) {
        $page = $request->page;
        $str1 = $request->str1;
        $str2 = $request->str2;
        if ($page == "payment-participan"){
            $stmt = TbParticipanModel::where('id_participan',Session::get('id_participan'))->first();
            $data['no_abs'] = $str1;
            $data['id'] = $str1;
            $data['file_pembayaran'] = $stmt->file_pembayaran;
            $data['no_participan'] = str_replace("TIC-","",$stmt->no_participan);
        } else if ($page == "payment-view") {
            $stmt = TbParticipanModel::where('id_participan',Session::get('id_participan'))->first();
            $data['data'] = $stmt;
        }
        $data['page'] = $page;
        return view("other/modal_participan",$data);
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect(url('/'));
    }
}
