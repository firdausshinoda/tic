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
use App\Models\TbJurnalModel;
use App\Models\TbJurnalQAModel;
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
use Faker\Extension\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PHPUnit\TextUI\Help;
use Yajra\DataTables\DataTables;

class TableController extends Controller
{
    public function dtTableProgressReport(Request $request) {
        if ($request->ajax()) {
            $orWhere = array();
            if ($request->page=="PROGRESS-REPORT") {
                $orWhere['tb_jurnal.stt_jurnal'] = "WILL BE PROCESSED";
            }
            $where['tb_jurnal.stt_jurnal'] = "ABSTRACT ACCEPTED";
            if ($request->paper != "ALL") {
                if ($request->paper == "NO"){
                    $where_raw = "tb_jurnal.file_nama IS NULL";
                } else {
                    $where_raw = "tb_jurnal.file_nama IS NOT NULL";
                }
                $where['tb_jurnal.del_flage'] = 0;
            } else {
                $where_raw = "tb_jurnal.del_flage = 0";
            }
            if ($request->paperstt!="ALL") {
                $where['tb_jurnal.stt_full_paper'] = $request->payment;
            }
            if ($request->paperrevised!="ALL") {
                if ($request->paperrevised=="YES") {
                    $where['tb_jurnal.stt_revisi_paper'] = "FILLED";
                } else {
                    $where['tb_jurnal.stt_revisi_paper'] = "EMPTY";
                }
            }
            if ($request->progress!="ALL") {
                $where['tb_jurnal.stt_progres_paper'] = $request->progress;
            }
            $data = TbJurnalModel::selectRaw('tb_author.no_author, tb_jurnal.no_abstrak, tb_jurnal.stt_full_paper, tb_jurnal.file_nama, tb_jurnal.stt_revisi_paper, tb_jurnal.stt_progres_paper, tb_jurnal_author.nama_depan, tb_jurnal_author.nama_tengah, tb_jurnal_author.nama_belakang, tb_reviewer.nama_depan as nama_depan_reviewer, tb_reviewer.nama_tengah as nama_tengah_reviewer, tb_reviewer.nama_belakang as nama_belakang_reviewer')
                ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author')
                ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal.id_reviewer','LEFT')
                ->join('tb_jurnal_author', 'tb_jurnal_author.id_jurnal_author' , '=','tb_jurnal.id_jurnal_author','left')
                ->where($where)
                ->orWhere($orWhere)
                ->whereRaw($where_raw)
                ->latest('tb_jurnal.id_jurnal')->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
    public function dtTableNotifParticipan(Request $request) {
        if ($request->ajax()) {
            $data = TbNotifParticipanModel::where(array('del_flage'=>0,'id_participan'=>Session::get('id_participan')))
                ->latest('id_notif_participan')->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_notif_participan'] = Helpers::enkrip($item->id_notif_participan);
                $dt[$key]['judul'] = $item->judul;
                $dt[$key]['pesan'] = $item->pesan;
                $dt[$key]['stt_view'] = $item->stt_view;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableNotifReviewer(Request $request) {
        if ($request->ajax()) {
            $data = TbNotifReviewerModel::select('tb_notif_reviewer.*','tb_jurnal.no_abstrak')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_notif_reviewer.id_jurnal','left')
                ->where(array('tb_notif_reviewer.del_flage'=>0,'tb_notif_reviewer.id_reviewer'=>Session::get('id_reviewer')))
                ->latest('tb_notif_reviewer.id_notif_reviewer')->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['stt_notif'] = $item->stt_notif;
                $dt[$key]['no_abstrak'] = $item->no_abstrak;
                $dt[$key]['id_jurnal_qa'] = Helpers::enkrip($item->id_jurnal_qa);
                $dt[$key]['id_notif_reviewer'] = Helpers::enkrip($item->id_notif_reviewer);
                $dt[$key]['judul'] = $item->judul;
                $dt[$key]['pesan'] = $item->pesan;
                $dt[$key]['stt_view'] = $item->stt_view;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableMyQuestionReviewer(Request $request){
        if ($request->ajax()) {
            $data = TbJurnalQAModel::select('tb_jurnal.judul_jurnal','tb_jurnal.no_abstrak','tb_jurnal_qa.*')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_qa.id_jurnal')
                ->latest('tb_jurnal_qa.id_jurnal_qa')
                ->where(array('tb_jurnal_qa.id_reviewer'=>Session::get('id_reviewer'),'tb_jurnal_qa.del_flage'=>0))->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['no_abstrak'] = $item->no_abstrak;
                $dt[$key]['id_jurnal_qa'] = Helpers::enkrip($item->id_jurnal_qa);
                $dt[$key]['judul_jurnal'] = $item->judul_jurnal;
                $dt[$key]['pertanyaan'] = $item->pertanyaan;
                $dt[$key]['created_at'] = $item->created_at;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableMyJournal(Request $request){
        if ($request->ajax()) {
            $where["tb_jurnal.id_author"] = Session::get('id_author');
            $where["tb_jurnal.del_flage"] = 0;
            $data = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope')
                ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
                ->latest('tb_jurnal.id_jurnal')
                ->where($where)
                ->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
    public function dtTableNotifAuthor(Request $request) {
        if ($request->ajax()) {
            $data = TbNotifAuthorModel::select('tb_notif_author.*','tb_jurnal.no_abstrak')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_notif_author.id_jurnal','left')
                ->where(array('tb_notif_author.del_flage'=>0,'tb_notif_author.id_author'=>Session::get('id_author')))
                ->latest('tb_notif_author.id_notif_author')->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_notif_author'] = Helpers::enkrip($item->id_notif_author);
                $dt[$key]['id_jurnal'] = Helpers::enkrip($item->id_jurnal);
                $dt[$key]['id_jurnal_qa'] = Helpers::enkrip($item->id_jurnal_qa);
                $dt[$key]['id_author'] = Helpers::enkrip($item->id_author);
                $dt[$key]['no_abstrak'] = $item->no_abstrak;
                $dt[$key]['judul'] = $item->judul;
                $dt[$key]['pesan'] = $item->pesan;
                $dt[$key]['stt_view'] = $item->stt_view;
                $dt[$key]['stt_notif'] = $item->stt_notif;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableMyJurnalQuestion(Request $request){
        if ($request->ajax()) {
            $data = TbJurnalQAModel::select('tb_jurnal.judul_jurnal','tb_jurnal.slug_jurnal','tb_jurnal_qa.*')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_qa.id_jurnal')
                ->latest('tb_jurnal_qa.id_jurnal_qa')
                ->where(array('tb_jurnal.no_abstrak'=>$request->no_abs,'tb_jurnal_qa.del_flage'=>0))->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
    public function dtTableJournalRevision(Request $request) {
        if ($request->ajax()) {
            $data = TbJurnalRevisiModel::select('tb_jurnal_revisi.*')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_revisi.id_jurnal')
                ->latest('tb_jurnal_revisi.id_jurnal_revisi')
                ->where(array('tb_jurnal.no_abstrak'=>$request->no_abs,'tb_jurnal_revisi.del_flage'=>0))->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
    public function dtTableMyQuestionAuthor(Request $request){
        if ($request->ajax()) {
            $data = TbJurnalQAModel::select('tb_jurnal.judul_jurnal','tb_jurnal.no_abstrak','tb_jurnal_qa.*')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_qa.id_jurnal')
                ->latest('tb_jurnal_qa.id_jurnal_qa')
                ->where(array('tb_jurnal_qa.id_author'=>Session::get('id_author'),'tb_jurnal_qa.del_flage'=>0))->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['no_abstrak'] = $item->no_abstrak;
                $dt[$key]['kode_qa'] = Helpers::enkrip($item->id_jurnal_qa);
                $dt[$key]['judul_jurnal'] = $item->judul_jurnal;
                $dt[$key]['pertanyaan'] = $item->pertanyaan;
                $dt[$key]['created_at'] = $item->created_at;
                $dt[$key]['pertanyaan'] = $item->pertanyaan;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableQAForum(Request $request){
        if ($request->ajax()) {
            $data = TbJurnalQAModel::select('tb_jurnal.judul_jurnal','tb_jurnal.no_abstrak','tb_jurnal_qa.*')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_qa.id_jurnal')
                ->latest('tb_jurnal_qa.id_jurnal_qa')
                ->where(array('tb_jurnal.id_author'=>Session::get('id_author'),'tb_jurnal_qa.del_flage'=>0))->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['no_abstrak'] = $item->no_abstrak;
                $dt[$key]['kode'] = Helpers::enkrip($item->id_jurnal_qa);
                $dt[$key]['judul_jurnal'] = $item->judul_jurnal;
                $dt[$key]['pertanyaan'] = $item->pertanyaan;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableRevision(Request $request){
        if ($request->ajax()) {
            $dt = array();
            if (Session::has('tic-author')){
                $data = TbJurnalModel::select('tb_jurnal.*','tb_reviewer.nama_depan','tb_reviewer.nama_tengah','tb_reviewer.nama_belakang')
                    ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal.id_reviewer','LEFT')
                    ->where(array('tb_jurnal.del_flage'=>0,'tb_jurnal.id_author'=>Session::get('id_author')))
                    ->orWhere(array('tb_jurnal.id_author_corresponding'=>Session::get('id_author')))
                    ->whereNotNull('tb_jurnal.file_nama')->latest('tb_jurnal.id_jurnal')->get();
                foreach ($data as $key => $item) {
                    $dt[$key]['no_abstrak'] = $item->no_abstrak;
                    $dt[$key]['judul_jurnal'] = $item->judul_jurnal;
                    $dt[$key]['stt_full_paper'] = $item->stt_full_paper;
                    $dt[$key]['stt_revisi_paper'] = $item->stt_revisi_paper;
                    $dt[$key]['stt_progres_paper'] = $item->stt_progres_paper;
                }
            } else {
                $data = TbJurnalModel::select('tb_jurnal.*','tb_reviewer.nama_depan','tb_reviewer.nama_tengah','tb_reviewer.nama_belakang')
                    ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal.id_reviewer','LEFT')
                    ->latest('tb_jurnal.id_jurnal')
                    ->where(array('tb_jurnal.stt_jurnal'=>"ABSTRACT ACCEPTED",'tb_jurnal.del_flage'=>0))
                    ->whereNotNull('tb_jurnal.file_nama')->get();
                foreach ($data as $key => $item){
                    $dt[$key]['no_abstrak'] = $item->no_abstrak;
                    $dt[$key]['judul_jurnal'] = $item->judul_jurnal;
                    $dt[$key]['stt_full_paper'] = $item->stt_full_paper;
                    $dt[$key]['stt_revisi_paper'] = $item->stt_revisi_paper;
                    $dt[$key]['stt_progres_paper'] = $item->stt_progres_paper;
                    $dt[$key]['nama_depan'] = $item->nama_depan;
                    $dt[$key]['nama_tengah'] = $item->nama_tengah;
                    $dt[$key]['nama_belakang'] = $item->nama_belakang;
                    $dt[$key]['id_reviewer'] = empty($item->id_reviewer) ? null : Helpers::enkrip($item->id_reviewer);
                    $dt[$key]['id_jurnal'] = Helpers::enkrip($item->id_jurnal);
                }
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableMyReviewReviewer(Request $request){
        if ($request->ajax()) {
            $data = TbJurnalModel::select('tb_jurnal.*','tb_reviewer.nama_depan','tb_reviewer.nama_tengah','tb_reviewer.nama_belakang','tb_jurnal.file_nama')
                ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal.id_reviewer','LEFT')
                ->latest('tb_jurnal.id_jurnal')
                ->where(array('tb_jurnal.del_flage'=>0,'tb_jurnal.id_reviewer'=>Session::get('id_reviewer')))->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['no_abstrak'] = $item->no_abstrak;
                $dt[$key]['judul_jurnal'] = $item->judul_jurnal;
                $dt[$key]['stt_full_paper'] = $item->stt_full_paper;
                $dt[$key]['stt_revisi_paper'] = $item->stt_revisi_paper;
                $dt[$key]['stt_progres_paper'] = $item->stt_progres_paper;
                $dt[$key]['file_nama'] = $item->file_nama;
                $dt[$key]['id_jurnal'] = Helpers::enkrip($item->id_jurnal);
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableRevisionAuthorDetail(Request $request) {
        if ($request->ajax()) {
            $data = TbJurnalRevisiModel::select('tb_jurnal_revisi.*')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_revisi.id_jurnal')
                ->latest('tb_jurnal_revisi.id_jurnal_revisi')
                ->where(array('tb_jurnal.no_abstrak'=>$request->no_abs,'tb_jurnal_revisi.del_flage'=>0))->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_jurnal_revisi'] = Helpers::enkrip($item->id_jurnal_revisi);
                $dt[$key]['revisi_ke'] = $item->revisi_ke;
                $dt[$key]['revisi'] = $item->revisi;
                $dt[$key]['file_revisi_reviewer'] = $item->file_revisi_reviewer;
                $dt[$key]['file_revisi_author'] = $item->file_revisi_author;
                $dt[$key]['stt_revisi'] = $item->stt_revisi;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableRevisionDetail(Request $request){
        if ($request->ajax()) {
            $data = TbJurnalRevisiModel::select('tb_jurnal_revisi.*')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_revisi.id_jurnal')
                ->latest('tb_jurnal_revisi.id_jurnal_revisi')
                ->where(array('tb_jurnal.no_abstrak'=>$request->no_abs,'tb_jurnal_revisi.del_flage'=>0))->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_jurnal_revisi'] = Helpers::enkrip($item->id_jurnal_revisi);
                $dt[$key]['revisi_ke'] = $item->revisi_ke;
                $dt[$key]['revisi'] = $item->revisi;
                $dt[$key]['file_revisi_reviewer'] = $item->file_revisi_reviewer;
                $dt[$key]['file_revisi_author'] = $item->file_revisi_author;
                $dt[$key]['stt_revisi'] = $item->stt_revisi;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableNotifAdmin(Request $request) {
        if ($request->ajax()) {
            $data = TbNotifAdminModel::select('tb_notif_admin.*','tb_jurnal.no_abstrak')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_notif_admin.id_jurnal','left')
                ->where('tb_notif_admin.del_flage',0)->latest('tb_notif_admin.id_notif_admin')->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_notif_admin'] = Helpers::enkrip($item->id_notif_admin);
                $dt[$key]['no_abstrak'] = $item->no_abstrak;
                $dt[$key]['judul'] = $item->judul;
                $dt[$key]['pesan'] = $item->pesan;
                $dt[$key]['stt_notif'] = $item->stt_notif;
                $dt[$key]['stt_view'] = $item->stt_view;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableJournalConfirm(Request $request){
        if ($request->ajax()) {
            $data = TbJurnalModel::select('tb_jurnal.*','tb_sub.sub','tb_scope.scope','tb_reviewer.nama_depan','tb_reviewer.nama_tengah','tb_reviewer.nama_belakang')
                ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
                ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
                ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
                ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal.id_reviewer','LEFT')
                ->latest('tb_jurnal.created_at')
                ->where(array('tb_jurnal.stt_jurnal'=>"COMPLETED FOR A REVIEW",'tb_jurnal.del_flage'=>0,'tb_event.stt_aktif'=>1))
                ->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
    public function dtTableJournalDraft(Request $request){
        if ($request->ajax()) {
            $data = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang','tb_author.no_author')
                ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
                ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
                ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author')
                ->latest('tb_jurnal.id_jurnal')
                ->where(array('tb_jurnal.stt_jurnal'=>"DRAFT",'tb_jurnal.del_flage'=>0,'tb_event.stt_aktif'=>1))
                ->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
    public function dtTableJournalProcess(Request $request){
        if ($request->ajax()) {
            $where['tb_jurnal.stt_jurnal'] = "ABSTRACT ACCEPTED";
            $where['tb_event.stt_aktif'] = 1;
            if ($request->sub!="ALL") {
                $where['tb_scope.id_sub'] = $request->sub;
            }
            if ($request->payment!="ALL") {
                $where['tb_jurnal.stt_pembayaran'] = $request->payment;
            }
            if ($request->reviewer!="ALL") {
                $where['tb_jurnal.id_reviewer'] = $request->reviewer;
            }
            if ($request->paper!="ALL") {
                if ($request->paper == 0){
                    $where_raw = "tb_jurnal.file_nama IS NULL";
                } else {
                    $where_raw = "tb_jurnal.file_nama IS NOT NULL";
                }
                $where['tb_jurnal.del_flage'] = 0;
            } else {
                $where_raw = "tb_jurnal.del_flage = 0";
            }
            $data = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_sub.sub','tb_reviewer.nama_depan','tb_reviewer.nama_tengah','tb_reviewer.nama_belakang','tb_author.institusi','tb_author.nama_depan as nama_depan_a','tb_author.nama_tengah as nama_tengah_a','tb_author.nama_belakang as nama_belakang_a')
                ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
                ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
                ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author_corresponding')
                ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal.id_reviewer','LEFT')
                ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub','LEFT')
                ->latest('tb_jurnal.id_jurnal')
                ->where($where)
                ->whereRaw($where_raw)
                ->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
    public function dtTableJournalFinal(Request $request) {
        if ($request->ajax()) {
            $where['tb_jurnal.stt_jurnal'] = "WILL BE PROCESSED";
            $where['tb_event.stt_aktif'] = 1;
            $where['tb_jurnal.del_flage'] = 0;
            $data = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_sub.sub','tb_reviewer.nama_depan','tb_reviewer.nama_tengah','tb_reviewer.nama_belakang','tb_author.institusi','tb_author.nama_depan as nama_depan_a','tb_author.nama_tengah as nama_tengah_a','tb_author.nama_belakang as nama_belakang_a')
                ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
                ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
                ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author_corresponding')
                ->join('tb_reviewer','tb_reviewer.id_reviewer','=','tb_jurnal.id_reviewer','LEFT')
                ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub','LEFT')
                ->latest('tb_jurnal.id_jurnal')
                ->where($where)
                ->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
    public function dtTablePaymentJournal(Request $request) {
        if ($request->ajax()) {
            $data = TbJurnalModel::select('tb_jurnal.*','tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang')
                ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author')
                ->where('tb_jurnal.del_flage',0)
                ->whereNotNull('tb_jurnal.file_pembayaran')
                ->latest('tb_jurnal.stt_pembayaran_date_upload')->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
    public function dtTablePaymentParticipan(Request $request) {
        if ($request->ajax()) {
            $data = TbParticipanModel::where('del_flage',0)
                ->whereNotNull('file_pembayaran')
                ->latest('stt_pembayaran_date_upload')->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
    public function dtTableAuthors(Request $request) {
        if ($request->ajax()) {
            if ($request->education != "ALL") {
                $where['pddk_terakhir'] = $request->education;
            }
            if ($request->institution != "ALL") {
                $where['institusi'] = $request->institution;
            }
            $where["del_flage"] = 0;
            $data = TbAuthorModel::where($where)->latest('id_author')->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_author'] = Helpers::enkrip($item->id_author);
                $dt[$key]['no_author'] = $item->no_author;
                $dt[$key]['nama_depan'] = $item->nama_depan;
                $dt[$key]['nama_tengah'] = $item->nama_tengah;
                $dt[$key]['nama_belakang'] = $item->nama_belakang;
                $dt[$key]['email'] = $item->email;
                $dt[$key]['pddk_terakhir'] = $item->pddk_terakhir;
                $dt[$key]['institusi'] = $item->institusi;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableReviewers(Request $request) {
        if ($request->ajax()) {
            $data = TbReviewerModel::where('del_flage',0)->latest()->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_reviewer'] = Helpers::enkrip($item->id_reviewer);
                $dt[$key]['foto_reviewer'] = $item->foto_reviewer;
                $dt[$key]['nama_depan'] = $item->nama_depan;
                $dt[$key]['nama_tengah'] = $item->nama_tengah;
                $dt[$key]['nama_belakang'] = $item->nama_belakang;
                $dt[$key]['email'] = $item->email;
                $dt[$key]['jenis_kelamin'] = $item->jenis_kelamin;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableParticipan(Request $request) {
        if ($request->ajax()) {
            $data = TbParticipanModel::select('tb_participan.*','tb_event.event')
                ->join('tb_event','tb_event.id_event','=','tb_participan.id_event','LEFT')
                ->where('tb_participan.del_flage',0)->latest()->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_participan'] = Helpers::enkrip($item->id_participan);
                $dt[$key]['no_participan'] = $item->no_participan;
                $dt[$key]['nama_depan'] = $item->nama_depan;
                $dt[$key]['nama_tengah'] = $item->nama_tengah;
                $dt[$key]['nama_belakang'] = $item->nama_belakang;
                $dt[$key]['event'] = $item->event;
                $dt[$key]['pddk_terakhir'] = $item->pddk_terakhir;
                $dt[$key]['institusi'] = $item->institusi;
                $dt[$key]['stt_pembayaran_konfirmasi'] = $item->stt_pembayaran_konfirmasi;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableCountry(Request $request) {
        if ($request->ajax()) {
            $data = TbNegaraModel::where('del_flage',0)->latest()->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_negara'] = Helpers::enkrip($item->id_negara);
                $dt[$key]['negara'] = $item->negara;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableDegree(Request $request) {
        if ($request->ajax()) {
            $data = TbGelarModel::where('del_flage',0)->latest()->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_gelar'] = Helpers::enkrip($item->id_gelar);
                $dt[$key]['gelar'] = $item->gelar;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableSosmed(Request $request) {
        if ($request->ajax()) {
            $data = TbSosmedModel::where('del_flage',0)->latest()->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_sosmed'] = Helpers::enkrip($item->id_sosmed);
                $dt[$key]['sosmed'] = $item->sosmed;
                $dt[$key]['icon'] = $item->icon;
                $dt[$key]['link'] = $item->link;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableContact(Request $request) {
        if ($request->ajax()) {
            $data = TbKontakModel::where('del_flage',0)->latest()->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_kontak'] = Helpers::enkrip($item->id_kontak);
                $dt[$key]['judul'] = $item->judul;
                $dt[$key]['icon'] = $item->icon;
                $dt[$key]['isi'] = $item->isi;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableEvents(Request $request) {
        if ($request->ajax()) {
            $data = TbEventModel::where('del_flage',0)->latest('id_event')->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_event'] = Helpers::enkrip($item->id_event);
                $dt[$key]['slug_event'] = $item->slug_event;
                $dt[$key]['tahun_event'] = $item->tahun_event;
                $dt[$key]['pamflet'] = $item->pamflet;
                $dt[$key]['event'] = $item->event;
                $dt[$key]['stt_aktif'] = $item->stt_aktif;
                $dt[$key]['stt_aktif'] = $item->stt_aktif;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTablecohost(Request $request) {
        if ($request->ajax()) {
            $data = TbCoHostModel::select('tb_cohost.*')
                ->join('tb_event','tb_event.id_event','=','tb_cohost.id_event')
                ->latest('tb_cohost.id_cohost')
                ->where(array('tb_cohost.del_flage'=>0,'tb_event.slug_event'=>$request->slug))
                ->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_cohost'] = Helpers::enkrip($item->id_cohost);
                $dt[$key]['nama'] = $item->nama;
                $dt[$key]['thumbnail'] = $item->thumbnail;
                $dt[$key]['link'] = $item->link;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableindexing(Request $request) {
        if ($request->ajax()) {
            $data = TbIndexingModel::select('tb_indexing.*')
                ->join('tb_event','tb_event.id_event','=','tb_indexing.id_event')
                ->latest('tb_indexing.id_indexing')
                ->where(array('tb_indexing.del_flage'=>0,'tb_event.slug_event'=>$request->slug))
                ->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_indexing'] = Helpers::enkrip($item->id_indexing);
                $dt[$key]['nama'] = $item->nama;
                $dt[$key]['logo'] = $item->logo;
                $dt[$key]['link'] = $item->link;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableTypePayment(Request $request) {
        if ($request->ajax()) {
            $data = TbJenisPembayaranModel::select('tb_jenis_pembayaran.*')
                ->join('tb_event','tb_event.id_event','=','tb_jenis_pembayaran.id_event')
                ->latest('tb_jenis_pembayaran.id_jenis_pembayaran')
                ->where(array('tb_jenis_pembayaran.del_flage'=>0,'tb_event.slug_event'=>$request->slug))
                ->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_jenis_pembayaran'] = Helpers::enkrip($item->id_jenis_pembayaran);
                $dt[$key]['jenis_pembayaran'] = $item->jenis_pembayaran;
                $dt[$key]['nama_jenis_pembayaran'] = $item->nama_jenis_pembayaran;
                $dt[$key]['nomor_jenis_pembayaran'] = $item->nomor_jenis_pembayaran;
                $dt[$key]['an_jenis_pembayaran'] = $item->an_jenis_pembayaran;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableCollaboration(Request $request) {
        if ($request->ajax()) {
            $data = TbKerjaSamaModel::select('tb_kerjasama.*')
                ->join('tb_event','tb_event.id_event','=','tb_kerjasama.id_event')
                ->latest('tb_kerjasama.id_kerjasama')
                ->where(array('tb_kerjasama.del_flage'=>0,'tb_event.slug_event'=>$request->slug))
                ->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_kerjasama'] = Helpers::enkrip($item->id_kerjasama);
                $dt[$key]['nama'] = $item->nama;
                $dt[$key]['logo'] = $item->logo;
                $dt[$key]['link'] = $item->link;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableKeynoteSpeaker(Request $request) {
        if ($request->ajax()) {
            $data = TbKeynoteSpeakerModel::select('tb_keynote_speaker.*','tb_sub.sub')
                ->join('tb_event','tb_event.id_event','=','tb_keynote_speaker.id_event')
                ->join('tb_sub','tb_sub.id_sub','=','tb_keynote_speaker.id_sub','LEFT')
                ->latest('tb_keynote_speaker.id_keynote_speaker')
                ->where(array('tb_keynote_speaker.del_flage'=>0,'tb_event.slug_event'=>$request->slug))
                ->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_keynote_speaker'] = Helpers::enkrip($item->id_keynote_speaker);
                $dt[$key]['sub'] = $item->sub;
                $dt[$key]['nama'] = $item->nama;
                $dt[$key]['thumbnail'] = $item->thumbnail;
                $dt[$key]['institusi'] = $item->institusi;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableInvitedSpeaker(Request $request) {
        if ($request->ajax()) {
            $data = TbInvitedSpeakerModel::select('tb_invited_speaker.*','tb_sub.sub')
                ->join('tb_event','tb_event.id_event','=','tb_invited_speaker.id_event')
                ->join('tb_sub','tb_sub.id_sub','=','tb_invited_speaker.id_sub','LEFT')
                ->latest('tb_invited_speaker.id_invited_speaker')
                ->where(array('tb_invited_speaker.del_flage'=>0,'tb_event.slug_event'=>$request->slug))
                ->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_invited_speaker'] = Helpers::enkrip($item->id_invited_speaker);
                $dt[$key]['sub'] = $item->sub;
                $dt[$key]['nama'] = $item->nama;
                $dt[$key]['thumbnail'] = $item->thumbnail;
                $dt[$key]['institusi'] = $item->institusi;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableSetting(Request $request){
        $stmt = TbSettingModel::select('tb_setting.*')
            ->join('tb_event','tb_event.id_event','=','tb_setting.id_event')
            ->latest('tb_setting.id_setting')
            ->where('tb_event.slug_event',$request->slug)->first();
        $data[0] = array('nama'=>"THEME",'deskripsi'=>strip_tags($stmt->tema),'key'=>"tema",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[1] = array('nama'=>"SHORT DESCRIPTION",'deskripsi'=>strip_tags($stmt->deskripsi_singkat),'key'=>"deskripsi_singkat",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[2] = array('nama'=>"LONG DESCRIPTION",'deskripsi'=>strip_tags($stmt->deskripsi_panjang),'key'=>"deskripsi_panjang",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[3] = array('nama'=>"CATEGORY DESCRIPTION",'deskripsi'=>strip_tags($stmt->deskripsi_kategori),'key'=>"deskripsi_kategori",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[4] = array('nama'=>"SUBMISSION",'deskripsi'=>strip_tags($stmt->submission),'key'=>"submission",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[5] = array('nama'=>"PUBLICATION OPPORTUNITY",'deskripsi'=>strip_tags($stmt->publication_opportunity),'key'=>"publication_opportunity",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[6] = array('nama'=>"COMMITTE",'deskripsi'=>strip_tags($stmt->committee),'key'=>"committee",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[7] = array('nama'=>"CALL FOR PAPER",'deskripsi'=>strip_tags($stmt->call_for_paper),'key'=>"call_for_paper",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[8] = array('nama'=>"FEE",'deskripsi'=>strip_tags($stmt->fee),'key'=>"fee",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[9] = array('nama'=>"ABOUT",'deskripsi'=>strip_tags($stmt->about),'key'=>"about",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[10] = array('nama'=>"FAQ",'deskripsi'=>strip_tags($stmt->faq),'key'=>"faq",'stt_edit'=>"FULL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[11] = array('nama'=>"LOCAL JOURNAL PRICES",'deskripsi'=>"Rp ".str_replace(',','.',number_format($stmt->harga_jurnal_lokal)),'key'=>"harga_jurnal_lokal",'stt_edit'=>"NUMBER",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[12] = array('nama'=>"INTERNATIONAL JOURNAL PRICES",'deskripsi'=>"$ ".$stmt->harga_jurnal_internasional,'key'=>"harga_jurnal_internasional",'stt_edit'=>"NUMBER",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[13] = array('nama'=>"LOCAL PARTICIPANT PRICES",'deskripsi'=>"Rp ".str_replace(',','.',number_format($stmt->harga_participan_lokal)),'key'=>"harga_participan_lokal",'stt_edit'=>"NUMBER",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[14] = array('nama'=>"INTERNATIONAL PARTICIPANT PRICES",'deskripsi'=>"$ ".$stmt->harga_participan_internasional,'key'=>"harga_participan_internasional",'stt_edit'=>"NUMBER",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[15] = array('nama'=>"REGISTRATION START DATE",'deskripsi'=>$stmt->tgl_mulai_pendaftaran,'key'=>"tgl_mulai_pendaftaran",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[16] = array('nama'=>"REGISTRATION END DATE",'deskripsi'=>$stmt->tgl_akhir_pendaftaran,'key'=>"tgl_akhir_pendaftaran",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[17] = array('nama'=>"END DATE ABSTRACT",'deskripsi'=>$stmt->tgl_akhir_abstrak,'key'=>"tgl_akhir_abstrak",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[18] = array('nama'=>"PAYMENT END DATE",'deskripsi'=>$stmt->tgl_akhir_pembayaran,'key'=>"tgl_akhir_pembayaran",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[19] = array('nama'=>"FULL PAPER END DATE",'deskripsi'=>$stmt->tgl_akhir_full_paper,'key'=>"tgl_akhir_full_paper",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[20] = array('nama'=>"END DATE VIDEO",'deskripsi'=>$stmt->tgl_akhir_video,'key'=>"tgl_akhir_video",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[21] = array('nama'=>"QA START DATE",'deskripsi'=>$stmt->tgl_mulai_qa,'key'=>"tgl_mulai_qa",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[22] = array('nama'=>"QA END DATE",'deskripsi'=>$stmt->tgl_akhir_qa,'key'=>"tgl_akhir_qa",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[23] = array('nama'=>"DATE LOI",'deskripsi'=>$stmt->tgl_loi,'key'=>"tgl_loi",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[24] = array('nama'=>"DATE LOA",'deskripsi'=>$stmt->tgl_loa,'key'=>"tgl_loa",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[25] = array('nama'=>"START DATE REVIEW",'deskripsi'=>$stmt->tgl_mulai_mereview,'key'=>"tgl_mulai_mereview",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[26] = array('nama'=>"END DATE REVIEW",'deskripsi'=>$stmt->tgl_akhir_mereview,'key'=>"tgl_akhir_mereview",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[27] = array('nama'=>"START DATE REVISION",'deskripsi'=>$stmt->tgl_mulai_revisi,'key'=>"tgl_mulai_revisi",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[28] = array('nama'=>"END DATE REVISION",'deskripsi'=>$stmt->tgl_akhir_revisi,'key'=>"tgl_akhir_revisi",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[29] = array('nama'=>"DATE CONFERENCE",'deskripsi'=>$stmt->tgl_conference,'key'=>"tgl_conference",'stt_edit'=>"TGL",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[30] = array('nama'=>"KETUA NAMA",'deskripsi'=>$stmt->ketua_nama,'key'=>"ketua_nama",'stt_edit'=>"TEXT",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[31] = array('nama'=>"KETUA FILE TTD",'deskripsi'=>$stmt->ketua_file_ttd,'key'=>"ketua_file_ttd",'stt_edit'=>"FOTO",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[32] = array('nama'=>"BENDAHARA NAMA",'deskripsi'=>$stmt->bendahara_nama,'key'=>"bendahara_nama",'stt_edit'=>"TEXT",'id'=>Helpers::enkrip($stmt->id_setting));
        $data[33] = array('nama'=>"BENDAHARA FILE TTD",'deskripsi'=>$stmt->bendahara_file_ttd,'key'=>"bendahara_file_ttd",'stt_edit'=>"FOTO",'id'=>Helpers::enkrip($stmt->id_setting));
        return Datatables::of($data)->addIndexColumn()->make(true);
    }
    public function dtTableSub(Request $request) {
        if ($request->ajax()) {
            $data = TbSubModel::select('tb_sub.*')
                ->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
                ->latest('tb_sub.id_sub')
                ->where(array('tb_sub.del_flage'=>0,'tb_event.slug_event'=>$request->slug))
                ->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_sub'] = Helpers::enkrip($item->id_sub);
                $dt[$key]['thumbnail'] = $item->thumbnail;
                $dt[$key]['sub'] = $item->sub;
                $dt[$key]['deskripsi'] = $item->deskripsi;
                $dt[$key]['template'] = $item->template;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableScope(Request $request) {
        if ($request->ajax()) {
            $data = TbScopeModel::select('tb_scope.*','tb_sub.sub')
                ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
                ->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
                ->latest('tb_scope.id_scope')
                ->where(array('tb_scope.del_flage'=>0,'tb_event.slug_event'=>$request->slug))
                ->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_scope'] = Helpers::enkrip($item->id_scope);
                $dt[$key]['sub'] = $item->sub;
                $dt[$key]['scope'] = $item->scope;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableVC(Request $request) {
        if ($request->ajax()) {
            $data = TbVCModel::select('tb_vc.*','tb_sub.sub')
                ->join('tb_sub','tb_sub.id_sub','=','tb_vc.id_sub')
                ->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
                ->latest('tb_vc.id_vc')
                ->where(array('tb_vc.del_flage'=>0,'tb_event.slug_event'=>$request->slug))
                ->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_vc'] = Helpers::enkrip($item->id_vc);
                $dt[$key]['sub'] = $item->sub;
                $dt[$key]['vc'] = $item->vc;
                $dt[$key]['icon'] = $item->icon;
                $dt[$key]['link'] = $item->link;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }
    public function dtTableTimeline(Request $request) {
        if ($request->ajax()) {
            $data = TbTimelineModel::select('tb_timeline.*')
                ->join('tb_event','tb_event.id_event','=','tb_timeline.id_event')
                ->where(array('tb_timeline.del_flage'=>0,'tb_event.slug_event'=>$request->slug))
                ->get();
            $dt = array();
            foreach ($data as $key => $item){
                $dt[$key]['id_timeline'] = Helpers::enkrip($item->id_timeline);
                $dt[$key]['timeline'] = $item->timeline;
                $dt[$key]['date'] = $item->date;
                $dt[$key]['stt_data'] = $item->stt_data;
                $dt[$key]['created_at'] = $item->created_at;
            }
            return Datatables::of($dt)->addIndexColumn()->make(true);
        }
    }

    public function dtTableAbstract(Request $request) {
        if ($request->ajax()) {
            $data = TbJurnalModel::select('tb_jurnal.*','tb_sub.sub','tb_scope.scope')
                ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
                ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
                ->latest('tb_jurnal.id_jurnal')
                ->where(array('tb_jurnal.id_reviewer'=>Session::get('id_reviewer'),'tb_jurnal.del_flage'=>0))
                ->get();
            return Datatables::of($data)->addIndexColumn()->make(true);
        }
    }
}
