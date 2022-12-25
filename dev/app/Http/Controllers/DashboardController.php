<?php

namespace App\Http\Controllers;

use App\Models\TbCoHostModel;
use App\Models\TbEventModel;
use App\Models\TbGelarModel;
use App\Models\TbIndexingModel;
use App\Models\TbInvitedSpeakerModel;
use App\Models\TbKerjaSamaModel;
use App\Models\TbKeynoteSpeakerModel;
use App\Models\TbKontakModel;
use App\Models\TbNegaraModel;
use App\Models\TbSettingModel;
use App\Models\TbSosmedModel;
use App\Models\TbSubModel;
use App\Models\TbTimelineModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Models\TbJenisPembayaranModel;

class DashboardController extends Controller {

    public function perbaikan() {
        return "System Under Repair. Please visit again at 07.00 AM";
    }

    public function coba(){
//         $stmt = TbJurnalModel::select('tb_jurnal.no_abstrak','tb_jurnal.judul_jurnal','tb_jurnal.file_nama')
//             ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
//             ->where(array('tb_jurnal.del_flage'=>0,'tb_jurnal.stt_jurnal'=>"ABSTRACT ACCEPTED",'tb_scope.id_sub'=>2))
//             ->whereNotNull('tb_jurnal.file_nama');
//         if ($stmt) {
//             foreach ($stmt->get() as $key => $item) {
//                 $sintax = array(':','?','"','<','>','|','\n','\r','\'');

//                 $path1 = public_path('upload/jurnal/'.$item->file_nama);
//                 $ext = pathinfo($path1, PATHINFO_EXTENSION);
//                 $filename = $item->no_abstrak." - ".str_replace($sintax," ",$item->judul_jurnal).".".$ext;
//                 if (File::exists($path1)) {
//                     if(File::copy($path1,public_path('/upload/jurnal/fix/'.$filename))) {
//                         echo $item->no_abstrak." - Sukses <br/>";
//                     }
//                     else {
//                         echo $item->no_abstrak." - Gagal <br/>";
//                     }
// //                    echo $item->no_abstrak." - Ada <br/>";
//                 } else {
//                     echo $item->no_abstrak." - Tidak Ada <br/>";
//                 }
//             }
//         } else {
//             return "Gagal Semua";
//         }
    }

    public function index(){
        $dt_event = TbEventModel::where('stt_aktif',1)->first();
        $setting = TbSettingModel::where('id_event',$dt_event->id_event)->first();
        $where = array('del_flage'=>0,'stt_data'=>"PUBLISH",'id_event'=>$dt_event->id_event);
        $data['dt_pamflet'] = $dt_event;
        $data['dt_tema'] = $setting->tema;
        $data['dt_deskripsi_singkat'] = $setting->deskripsi_singkat;
        $data['dt_deskripsi_panjang'] = $setting->deskripsi_panjang;
        $data['dt_deskripsi_kategori'] = $setting->deskripsi_kategori;
        $data['dt_publication_opportunity'] = $setting->publication_opportunity;
        $data['dt_call_for_paper'] = $setting->call_for_paper;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        $data['dt_cohost'] = TbCoHostModel::where($where)->latest('id_cohost')->get();
        $data['dt_kerjasama'] = TbKerjaSamaModel::where($where)->latest('id_kerjasama')->get();
        $data['dt_kategori'] = TbSubModel::where($where)->get();
        $data['dt_invited'] = TbInvitedSpeakerModel::where($where)->get();
        $data['dt_keynote'] = TbKeynoteSpeakerModel::where($where)->get();
        $dt_timeline = array();
        foreach (TbTimelineModel::where($where)->get() as $key => $item_timeline){
            $dt_timeline[$key]['date'] = date("d", strtotime($item_timeline->date));
            $dt_timeline[$key]['month'] = date("M", strtotime($item_timeline->date));
            $dt_timeline[$key]['year'] = date("Y", strtotime($item_timeline->date));
            $dt_timeline[$key]['timeline'] = $item_timeline->timeline;
        }
        $data['dt_timeline'] = $dt_timeline;
        $data['dt_indexing'] = TbIndexingModel::where($where)->get();
        return view('dashboard/index',$data);
    }

    public function progress_report(){
        $data['dt_pamflet'] = TbEventModel::where('stt_aktif',1)->first();
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('dashboard/progress_report',$data);
    }

    public function contact_us(){
        $data['dt_pamflet'] = TbEventModel::where('stt_aktif',1)->first();
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('dashboard/contact_us',$data);
    }

    public function committee(){
        $data['dt_pamflet'] = TbEventModel::where('stt_aktif',1)->first();
        $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
        $data['dt_committee'] = TbSettingModel::where('id_event',$id_event)->first()->committee;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('dashboard/committee',$data);
    }

    public function faq(){
        $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
        $data['dt_pamflet'] = TbEventModel::where('stt_aktif',1)->first();
        $data['dt_isi'] = TbSettingModel::where('id_event',$id_event)->first()->faq;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('dashboard/faq',$data);
    }

    public function registration(){
        $where = array('stt_data'=>"PUBLISH",'del_flage'=>0);
        $data['dt_pamflet'] = TbEventModel::where('stt_aktif',1)->first();
        $data['dt_negara'] = TbNegaraModel::where($where)->get();
        $data['dt_gelar'] = TbGelarModel::where($where)->get();
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('dashboard/registration',$data);
    }

    public function payment(){
        $dt_event = TbEventModel::where('stt_aktif',1)->first();
        $setting = TbSettingModel::where('id_event',$dt_event->id_event)->first();
        $where = array('del_flage'=>0,'stt_data'=>"PUBLISH",'id_event'=>$dt_event->id_event);
        $data['dt_fee'] = $setting->fee;
        $data['dt_bank'] = TbJenisPembayaranModel::where($where)->get();
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('dashboard/payment',$data);
    }

    public function download(){
        $dt_event = TbEventModel::where('stt_aktif',1)->first();
        $sub = TbSubModel::where(array('id_event'=>$dt_event->id_event,'del_flage'=>0))->get();
        $data['dt_sub'] = $sub;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('dashboard/download',$data);
    }

    public function login(){
        if (Session::has('tic-author')){
            return redirect(url('/author'));
        }
        if (Session::has('tic-reviewer')){
            return redirect(url('/reviewer'));
        }
        $where = array('stt_data'=>"PUBLISH",'del_flage'=>0);
        $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
        $data['dt_isi'] = TbSettingModel::where('id_event',$id_event)->first()->submission;
        $data['dt_negara'] = TbNegaraModel::where($where)->get();
        $data['dt_gelar'] = TbGelarModel::where($where)->get();
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('dashboard/login',$data);
    }

    private function dt_kontak(){
        return TbKontakModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();
    }
    private function dt_sosmed(){
        return TbSosmedModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();
    }
}
