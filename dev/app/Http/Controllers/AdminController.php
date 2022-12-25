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
use App\Models\TbKerjaSamaModel;
use App\Models\TbKeynoteSpeakerModel;
use App\Models\TbKontakModel;
use App\Models\TbNegaraModel;
use App\Models\TbParticipanModel;
use App\Models\TbReviewerModel;
use App\Models\TbScopeModel;
use App\Models\TbSettingModel;
use App\Models\TbSosmedModel;
use App\Models\TbSubModel;
use App\Models\TbTimelineModel;
use App\Models\TbVCModel;
use Faker\Extension\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next){
            if (!Session::has('tic-admin')){
                return redirect(url('/'));
            }
            return $next($request);
        });
    }

    public function index(){
        return view('admin/index');
    }
    public function notification(){
        return view('admin/notification');
    }
    public function journal(){
        return view('admin/journal');
    }
    public function journal_process(){
        $data['sub'] = TbSubModel::select('tb_sub.*')->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
            ->where(array('tb_event.stt_aktif'=>1,'tb_event.del_flage'=>0,'tb_sub.del_flage'=>0))->get();
        $data['reviewer'] = TbReviewerModel::where(array('del_flage'=>0))->get();
        return view('admin/journal_process',$data);
    }
    public function journal_confirmation(){
        return view('admin/journal_confirmation');
    }
    public function journal_draft(){
        return view('admin/journal_draft');
    }
    public function journal_detail(){
        return view('admin/journal_detail');
    }
    public function revision(){
        return view('admin/revision');
    }
    public function revision_detail(){
        return view('admin/revision_detail');
    }
    public function payment_journal(){
        return view('admin/payment_journal');
    }
    public function payment_participan(){
        return view('admin/payment_participan');
    }
    public function videos(){
        return view('admin/videos');
    }
    public function videos_abstract(Request $request){
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
        return view('admin/videos_abstract',$data);
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
        return view('admin/videos_forum',$data);
    }
    public function authors(){
        $data['institusi'] = TbAuthorModel::where('del_flage',0)->groupBy('institusi')->get();
        return view('admin/authors',$data);
    }
    public function authors_detail(Request $request){
        $data['data'] = TbAuthorModel::select('tb_author.*','tb_gelar.gelar','tb_negara.negara')
            ->join('tb_gelar','tb_gelar.id_gelar','=','tb_author.id_gelar','LEFT')
            ->join('tb_negara','tb_negara.id_negara','=','tb_author.id_negara','LEFT')
            ->where('tb_author.no_author',$request->atr)->first();
        return view('admin/authors_detail',$data);
    }
    public function reviewers(){
        return view('admin/reviewers');
    }
    public function reviewers_add(){
        return view('admin/reviewers_add');
    }
    public function reviewers_edit(Request $request){
        $stmt = TbReviewerModel::where('id_reviewer',Helpers::dekrip($request->id));
        if ($stmt->count() > 0){
            $data['data'] = $stmt->first();
            $data['data']['id_reviewer'] = Helpers::enkrip($stmt->first()->id_reviewer);
            return view('admin/reviewers_edit',$data);
        } else {
            return redirect(url('/admin/reviewers'));
        }
    }
    public function participan(){
        return view('admin/participan');
    }
    public function participan_detail(Request $request){
        $data['data'] = TbParticipanModel::select('tb_participan.*','tb_gelar.gelar','tb_negara.negara','tb_event.event')
            ->join('tb_gelar','tb_gelar.id_gelar','=','tb_participan.id_gelar','LEFT')
            ->join('tb_negara','tb_negara.id_negara','=','tb_participan.id_negara','LEFT')
            ->join('tb_event','tb_event.id_event','=','tb_participan.id_event','LEFT')
            ->where('tb_participan.no_participan',$request->atr)->first();
        return view('admin/participan_detail',$data);
    }
    public function country(){
        return view('admin/country');
    }
    public function country_add(){
        return view('admin/country_add');
    }
    public function country_edit(Request $request){
        $data['data'] = TbNegaraModel::where('id_negara',Helpers::dekrip($request->id))->first();
        return view('admin/country_edit',$data);
    }
    public function degree(){
        return view('admin/degree');
    }
    public function degree_add(){
        return view('admin/degree_add');
    }
    public function degree_edit(Request $request){
        $data['data'] = TbGelarModel::where('id_gelar',Helpers::dekrip($request->id))->first();
        return view('admin/degree_edit',$data);
    }
    public function sosmed(){
        return view('admin/sosmed');
    }
    public function sosmed_add(){
        return view('admin/sosmed_add');
    }
    public function sosmed_edit(Request $request){
        $data['data'] = TbSosmedModel::where('id_sosmed',Helpers::dekrip($request->id))->first();
        return view('admin/sosmed_edit',$data);
    }
    public function contact(){
        return view('admin/contact');
    }
    public function contact_add(){
        return view('admin/contact_add');
    }
    public function contact_edit(Request $request){
        $data['data'] = TbKontakModel::where('id_kontak',Helpers::dekrip($request->id))->first();
        return view('admin/contact_edit',$data);
    }
    public function events(){
        return view('admin/events');
    }
    public function events_add(){
        return view('admin/events_add');
    }
    public function events_edit(Request $request){
        $data['data'] = TbEventModel::where('id_event',Helpers::dekrip($request->id))->first();
        return view('admin/events_edit',$data);
    }
    public function events_detail($slug){
        $data['slug'] = $slug;
        return view('admin/events_detail',$data);
    }
    public function events_detail_edit($slug,$kode){
        $arr = explode("-", $kode, 3);
        $id = Helpers::dekrip($arr[0]);
        $data['id'] = Helpers::enkrip($id);
        $stt_edit = $arr[1];
        $data['key'] = $key = $arr[2];
        $dt = TbSettingModel::where('id_setting',$id)->first();
        if ($key == "tema"){
            $data['nama'] = "THEME"; $data['deskripsi'] = $dt->tema;
        } else if ($key == "deskripsi_singkat"){
            $data['nama'] = "SORT DESCRIPTION"; $data['deskripsi'] = $dt->deskripsi_singkat;
        } else if ($key == "deskripsi_panjang"){
            $data['nama'] = "LONG DESCRIPTION"; $data['deskripsi'] = $dt->deskripsi_panjang;
        } else if ($key == "deskripsi_kategori"){
            $data['nama'] = "CATEGORY DESCRIPTION"; $data['deskripsi'] = $dt->deskripsi_kategori;
        } else if ($key == "submission"){
            $data['nama'] = "SUBMISSION"; $data['deskripsi'] = $dt->submission;
        } else if ($key == "publication_opportunity"){
            $data['nama'] = "PUBLICATION OPPORTUNITY"; $data['deskripsi'] = $dt->publication_opportunity;
        } else if ($key == "committee"){
            $data['nama'] = "COMMITTEE"; $data['deskripsi'] = $dt->committee;
        } else if ($key == "call_for_paper"){
            $data['nama'] = "CALL FOR PAPER"; $data['deskripsi'] = $dt->call_for_paper;
        } else if ($key == "fee"){
            $data['nama'] = "FEE"; $data['deskripsi'] = $dt->fee;
        } else if ($key == "about"){
            $data['nama'] = "ABOUT"; $data['deskripsi'] = $dt->about;
        } else if ($key == "faq"){
            $data['nama'] = "FAQ"; $data['deskripsi'] = $dt->faq;
        } else if ($key == "harga_jurnal_lokal"){
            $data['nama'] = "LOCAL JOURNAL PRICES"; $data['deskripsi'] = $dt->harga_jurnal_lokal;
        } else if ($key == "harga_jurnal_internasional"){
            $data['nama'] = "INTERNATIONAL JOURNAL PRICES"; $data['deskripsi'] = $dt->harga_jurnal_internasional;
        } else if ($key == "harga_participan_lokal"){
            $data['nama'] = "LOCAL PARTICIPANT PRICES"; $data['deskripsi'] = $dt->harga_praticipan_lokal;
        } else if ($key == "harga_participan_internasional"){
            $data['nama'] = "INTERNATIONAL PARTICIPANT PRICES"; $data['deskripsi'] = $dt->harga_participan_internasional;
        } else if ($key == "tgl_mulai_pendaftaran"){
            $data['nama'] = "REGISTRATION START DATE"; $data['deskripsi'] = $dt->tgl_mulai_pendaftaran;
        } else if ($key == "tgl_akhir_pendaftaran"){
            $data['nama'] = "REGISTRATION END DATE"; $data['deskripsi'] = $dt->tgl_akhir_pendaftaran;
        } else if ($key == "tgl_akhir_abstrak"){
            $data['nama'] = "END DATE ABSTRACT"; $data['deskripsi'] = $dt->tgl_akhir_abstrak;
        } else if ($key == "tgl_akhir_pembayaran"){
            $data['nama'] = "PAYMENT END DATE"; $data['deskripsi'] = $dt->tgl_akhir_pembayaran;
        } else if ($key == "tgl_akhir_full_paper"){
            $data['nama'] = "FULL PAPER END DATE"; $data['deskripsi'] = $dt->tgl_akhir_full_paper;
        } else if ($key == "tgl_akhir_video"){
            $data['nama'] = "END DATE VIDEO"; $data['deskripsi'] = $dt->tgl_akhir_video;
        } else if ($key == "tgl_mulai_qa"){
            $data['nama'] = "QA START DATE"; $data['deskripsi'] = $dt->tgl_mulai_qa;
        } else if ($key == "tgl_akhir_qa"){
            $data['nama'] = "QA END DATE"; $data['deskripsi'] = $dt->tgl_akhir_qa;
        } else if ($key == "tgl_loi"){
            $data['nama'] = "DATE LOI"; $data['deskripsi'] = $dt->tgl_loi;
        } else if ($key == "tgl_loa"){
            $data['nama'] = "DATE LOA"; $data['deskripsi'] = $dt->tgl_loa;
        } else if ($key == "tgl_mulai_mereview"){
            $data['nama'] = "START DATE REVIEW"; $data['deskripsi'] = $dt->tgl_mulai_mereview;
        } else if ($key == "tgl_akhir_mereview"){
            $data['nama'] = "END DATE REVIEW"; $data['deskripsi'] = $dt->tgl_akhir_mereview;
        } else if ($key == "tgl_mulai_revisi"){
            $data['nama'] = "START DATE REVISION"; $data['deskripsi'] = $dt->tgl_mulai_revisi;
        } else if ($key == "tgl_akhir_revisi"){
            $data['nama'] = "END DATE REVISION"; $data['deskripsi'] = $dt->tgl_akhir_revisi;
        } else if ($key == "tgl_conference"){
            $data['nama'] = "DATE CONFERENCE"; $data['deskripsi'] = $dt->tgl_conference;
        } else if ($key == "ketua_nama"){
            $data['nama'] = "KETUA NAMA"; $data['deskripsi'] = $dt->ketua_nama;
        } else if ($key == "ketua_file_ttd"){
            $data['nama'] = "KETUA FILE TTD"; $data['deskripsi'] = $dt->ketua_file_ttd;
        } else if ($key == "bendahara_nama"){
            $data['nama'] = "BENDAHARA NAMA"; $data['deskripsi'] = $dt->bendahara_nama;
        } else if ($key == "bendahara_file_ttd"){
            $data['nama'] = "BENDAHARA FILE TTD"; $data['deskripsi'] = $dt->bendahara_file_ttd;
        }
        if ($stt_edit=="FULL"){
            $page = "setting-edit-full";
        } else if ($stt_edit=="NUMBER"){
            $page = "setting-edit-number";
        } else if ($stt_edit=="TEXT"){
            $page = "setting-edit-text";
        } else if ($stt_edit=="TGL"){
            $page = "setting-edit-date";
        } else if ($stt_edit=="FOTO"){
            $page = "setting-edit-foto";
        }
        $data['page'] = $page;
        return view('admin/events_detail_edit',$data);
    }
    public function account(){
        return view('admin/account');
    }
    public function account_edit(){
        return view('admin/account_edit');
    }
    public function account_password(){
        return view('admin/account_password');
    }
    public function logout(Request $request){
        $request->session()->flush();
        return redirect(url('/'));
    }

    public function modal(Request $request){
        $page = $request->page;
        $str1 = $request->str1;
        $str2 = $request->str2;
        if ($page == "viewIMG"){
            $data['file'] = $str1;
        } else if ($page=="payment-journal-view"){
            $data['data'] = TbJurnalModel::where('no_abstrak',$str1)->first();
        } else if ($page=="payment-participan-view"){
            $data['data'] = TbParticipanModel::where('no_participan',$str1)->first();
        } else if ($page=="reviewers-photo"){
            $data['data'] = TbReviewerModel::where('id_reviewer',Helpers::dekrip($str1))->first();
        } else if ($page=="cohost-add"){
            $data['kode'] = Helpers::enkrip($str1);
        } else if ($page == "cohost-edit"){
            $data['data'] = TbCoHostModel::where('id_cohost',Helpers::dekrip($str1))->first();
        } else if ($page == "indexing-add"){
            $data['kode'] = Helpers::enkrip($str1);
        } else if ($page == "indexing-edit"){
            $data['data'] = TbIndexingModel::where('id_indexing',Helpers::dekrip($str1))->first();
        } else if ($page == "type-payment-add"){
            $data['kode'] = Helpers::enkrip($str1);
        } else if ($page == "type-payment-edit"){
            $data['data'] = TbJenisPembayaranModel::where('id_jenis_pembayaran',Helpers::dekrip($str1))->first();
        } else if ($page == "type-payment-detail"){
            $data['data'] = TbJenisPembayaranModel::where('id_jenis_pembayaran',Helpers::dekrip($str1))->first();
        } else if ($page == "collaboration-add"){
            $data['kode'] = Helpers::enkrip($str1);
        } else if ($page == "collaboration-edit"){
            $data['data'] = TbKerjaSamaModel::where('id_kerjasama',Helpers::dekrip($str1))->first();
        } else if ($page == "keynote-speaker-add"){
            $event = TbEventModel::where('stt_aktif',1)->first();
            $data['sub'] = TbSubModel::where(array('id_event'=>$event->id_event,'stt_data'=>"PUBLISH",'del_flage'=>0))->get();
            $data['kode'] = Helpers::enkrip($str1);
        } else if ($page == "keynote-speaker-edit"){
            $event = TbEventModel::where('stt_aktif',1)->first();
            $data['sub'] = TbSubModel::where(array('id_event'=>$event->id_event,'stt_data'=>"PUBLISH",'del_flage'=>0))->get();
            $dt_detail = TbKeynoteSpeakerModel::select('tb_keynote_speaker.*','tb_sub.id_sub')
                ->join('tb_sub','tb_sub.id_sub','=','tb_keynote_speaker.id_sub','LEFT')
                ->where('tb_keynote_speaker.id_keynote_speaker',Helpers::dekrip($str1))
                ->first();
            $data['data'] = $dt_detail;
            $data['data_id'] = Helpers::enkrip($dt_detail->id_sub);
        } else if ($page == "keynote-speaker-detail"){
            $data['data'] = TbKeynoteSpeakerModel::where('id_keynote_speaker',Helpers::dekrip($str1))->first();
        } else if ($page == "invited-speaker-add"){
            $event = TbEventModel::where('stt_aktif',1)->first();
            $data['sub'] = TbSubModel::where(array('id_event'=>$event->id_event,'stt_data'=>"PUBLISH",'del_flage'=>0))->get();
            $data['kode'] = Helpers::enkrip($str1);
        } else if ($page == "invited-speaker-edit"){
            $event = TbEventModel::where('stt_aktif',1)->first();
            $data['sub'] = TbSubModel::where(array('id_event'=>$event->id_event,'stt_data'=>"PUBLISH",'del_flage'=>0))->get();
            $dt_detail = TbInvitedSpeakerModel::select('tb_invited_speaker.*','tb_sub.id_sub')
                ->join('tb_sub','tb_sub.id_sub','=','tb_invited_speaker.id_sub','LEFT')
                ->where('tb_invited_speaker.id_invited_speaker',Helpers::dekrip($str1))
                ->first();
            $data['data'] = $dt_detail;
            $data['data_id'] = Helpers::enkrip($dt_detail->id_sub);
        } else if ($page == "invited-speaker-detail"){
            $data['data'] = TbInvitedSpeakerModel::where('id_invited_speaker',Helpers::dekrip($str1))->first();
        } else if ($page == "sub-add"){
            $data['kode'] = Helpers::enkrip($str1);
        } else if ($page == "sub-edit"){
            $data['data'] = TbSubModel::where('id_sub',Helpers::dekrip($str1))->first();
        } else if ($page == "scope-add"){
            $data['sub'] = TbSubModel::select('tb_sub.*')->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
                ->latest('tb_sub.id_sub')->where(array('tb_sub.del_flage'=>0,'tb_event.slug_event'=>Helpers::dekrip($str1)))->get();
        } else if ($page == "scope-edit"){
            $data['sub'] = TbSubModel::select('tb_sub.*')->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
                ->latest('tb_sub.id_sub')->where(array('tb_sub.del_flage'=>0,'tb_event.slug_event'=>Helpers::dekrip($str1)))->get();
            $data['data'] = TbScopeModel::where('id_scope',Helpers::dekrip($str2))->first();
        } else if ($page == "vc-add"){
            $data['sub'] = TbSubModel::select('tb_sub.*')->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
                ->latest('tb_sub.id_sub')->where(array('tb_sub.del_flage'=>0,'tb_event.slug_event'=>Helpers::dekrip($str1)))->get();
        } else if ($page == "vc-edit"){
            $data['sub'] = TbSubModel::select('tb_sub.*')->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
                ->latest('tb_sub.id_sub')->where(array('tb_sub.del_flage'=>0,'tb_event.slug_event'=>Helpers::dekrip($str1)))->get();
            $data['data'] = TbVCModel::where('id_vc',Helpers::dekrip($str2))->first();
        } else if ($page == "timeline-add"){
            $data['kode'] = Helpers::enkrip($str1);
        } else if ($page == "timeline-edit"){
            $data['data'] = TbTimelineModel::where('id_timeline',Helpers::dekrip($str1))->first();
        } else if ($page == "journal-add-reviewer"){
            $data['data'] = TbReviewerModel::where('del_flage',0)->get();
            $data['abs'] = Helpers::enkrip($str1);
            $data['kode'] = $str2 == "0" ? "0" : Helpers::enkrip($str2);
        } else if ($page == "payment-journal") {
            $stmt = TbJurnalModel::where('no_abstrak',$str1)->first();
            $data['no_abs'] = $str1;
            $data['file_pembayaran'] = $stmt->file_pembayaran;
            $data['no_abstrak'] = str_replace("TIC-","",$stmt->no_abstrak);
            $data['jenis_pembayaran'] = TbJenisPembayaranModel::select('tb_jenis_pembayaran.*')
                ->join('tb_event','tb_event.id_event','=','tb_jenis_pembayaran.id_event')
                ->where(array('tb_event.stt_aktif'=>1,'tb_event.del_flage'=>0,'tb_jenis_pembayaran.del_flage'=>0,'tb_jenis_pembayaran.stt_data'=>"PUBLISH"))
                ->get();
        } else if ($page == "payment-view") {
            $stmt = TbJurnalModel::where('no_abstrak',$str1)->first();
            $data['data'] = $stmt;
        }
        $data['page'] = $page;
        return view("other/modal_admin",$data);
    }
}
