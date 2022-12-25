<?php

namespace App\Http\Controllers;

use App\Models\TbAuthorModel;
use App\Models\TbEventModel;
use App\Models\TbGelarModel;
use App\Models\TbIndexingModel;
use App\Models\TbInvitedSpeakerModel;
use App\Models\TbJenisPembayaranModel;
use App\Models\TbJurnalAuthorModel;
use App\Models\TbJurnalModel;
use App\Models\TbJurnalQAModel;
use App\Models\TbJurnalQASubModel;
use App\Models\TbKeynoteSpeakerModel;
use App\Models\TbKontakModel;
use App\Models\TbNegaraModel;
use App\Models\TbScopeModel;
use App\Models\TbSettingModel;
use App\Models\TbSosmedModel;
use App\Models\TbSubModel;
use App\Models\TbTimelineModel;
use App\Models\TbVCModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SubController extends Controller {

    public function index($slug){
        $sub = TbSubModel::select('tb_sub.*','tb_event.id_event')
            ->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
            ->where(array('tb_sub.slug'=>$slug,'tb_event.stt_aktif'=>1))
            ->first();
        $where = array('del_flage'=>0,'stt_data'=>"PUBLISH",'id_event'=>$sub->id_event);
        $dt_timeline = array();
        foreach (TbTimelineModel::where($where)->get() as $key => $item_timeline){
            $dt_timeline[$key]['date'] = date("d", strtotime($item_timeline->date));
            $dt_timeline[$key]['month'] = date("M", strtotime($item_timeline->date));
            $dt_timeline[$key]['year'] = date("Y", strtotime($item_timeline->date));
            $dt_timeline[$key]['timeline'] = $item_timeline->timeline;
        }

        $where2 = array('del_flage'=>0,'stt_data'=>"PUBLISH",'id_event'=>$sub->id_event,'id_sub'=>$sub->id_sub);
        $data['dt_invited'] = TbInvitedSpeakerModel::where($where2)->get();
        $data['dt_keynote'] = TbKeynoteSpeakerModel::where($where2)->get();

        $where = array('stt_data'=>"PUBLISH",'del_flage'=>0,'id_sub'=>$sub->id_sub);
        $data['dt_timeline'] = $dt_timeline;
        $data['dt_sub'] = $sub;
        $data['dt_vc'] = TbVCModel::where($where)->get();
        $data['dt_scope'] = TbScopeModel::where($where)->get();
        $data['dt_indexing'] = TbIndexingModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0,'id_event'=>$sub->id_event))->get();
        $data['dt_setting'] = TbSettingModel::where('id_event',$sub->id_event)->first();
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        $data['slug'] = $slug;
        $data['dt_pamflet'] = TbEventModel::where('stt_aktif',1)->first();
        return view('sub.index',$data);
    }
    public function committee($slug){
        $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
        $data['dt_committee'] = TbSettingModel::where('id_event',$id_event)->first()->committee;
        $data['slug'] = $slug;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.committee',$data);
    }
    public function list_users($slug){
        $data['slug'] = $slug;
        $data['data'] = TbAuthorModel::select('tb_author.*','tb_negara.negara')
            ->join('tb_negara','tb_negara.id_negara','=','tb_author.id_negara')
            ->where('tb_author.del_flage','=',0)->latest('tb_author.id_author')->paginate(10);
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.list_users',$data);
    }
    public function list_abstract($slug){
        $data['slug'] = $slug;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.list_abstract',$data);
    }
    public function list_videos($slug){
        $data['slug'] = $slug;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.list_videos',$data);
    }
    public function statistics_users($slug){
        $country_data = array();
        $country_ = array();
        $education_data = array();
        $education_ = array();
        $degree_data = array();
        $degree_ = array();
        $gender_data = array();
        $gender_ = array();
        $thn = TbEventModel::where('stt_aktif',1)->first()->tahun_event;
        $stmt_negara = TbAuthorModel::selectRaw("count(tb_author.id_negara) as data, tb_negara.negara as name, CONCAT('#',LPAD(CONV(ROUND(RAND()*16777215),10,16),6,0)) AS color")
            ->join('tb_negara','tb_negara.id_negara','=','tb_author.id_negara')
            ->whereYear('tb_author.created_at','=',$thn)
            ->groupBy('tb_author.id_negara')->get();
        foreach ($stmt_negara as $key => $item){
            $country_data[$key]['name'] = $item->name;
            $country_data[$key]['data'] = [(int)$item->data];
            $country_data[$key]['color'] = $item->color;
            $country_[$key] = $item->name;
        }
        $stmt_education = array('SMA','S1','S2','S3');
        foreach ($stmt_education as $key => $item){
            $education_[$key] = $item;
            $education_data[$key]['name'] = $item;
            $education_data[$key]['data'] = [TbAuthorModel::where('pddk_terakhir',$item)->whereYear('created_at','=',$thn)->count()];
            $education_data[$key]['color'] = $this->rand_color();
        }
        $stmt_degree = TbGelarModel::where('del_flage',0)->get();
        foreach ($stmt_degree as $key => $item){
            $degree_[$key] = $item->gelar;
            $degree_data[$key]['name'] = $item->gelar;
            $degree_data[$key]['data'] = [TbAuthorModel::where('id_gelar',$item->id_gelar)->whereYear('created_at','=',$thn)->count()];
            $degree_data[$key]['color'] = $this->rand_color();
        }
        $stmt_gender = array('MALE','FEMALE');
        foreach ($stmt_gender as $key => $item){
            $gender_[$key] = $item;
            $gender_data[$key]['name'] = $item;
            $gender_data[$key]['data'] = [TbAuthorModel::where('jenis_kelamin',$item)->whereYear('created_at','=',$thn)->count()];
            $gender_data[$key]['color'] = $this->rand_color();
        }
        $data['gr_country_data'] = json_encode($country_data);
        $data['gr_country'] = json_encode($country_);
        $data['gr_education_data'] = json_encode($education_data);
        $data['gr_education'] = json_encode($education_);
        $data['gr_degree_data'] = json_encode($degree_data);
        $data['gr_degree'] = json_encode($degree_);
        $data['gr_gender_data'] = json_encode($gender_data);
        $data['gr_gender'] = json_encode($gender_);
        $data['slug'] = $slug;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.statistics_users',$data);
    }
    public function statistics_abstrak($slug){
        $category_data = array();
        $category_ = array();
        $id_event = TbEventModel::where('stt_aktif',1)->first()->id_event;
        $stmt_category = TbScopeModel::select('tb_scope.scope','tb_scope.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->where('tb_sub.id_event',$id_event)->get();
        foreach ($stmt_category as $key => $item){
            $category_[$key] = $item->gelar;
            $category_data[$key]['name'] = $item->scope;
            $category_data[$key]['data'] = [TbJurnalModel::where('id_scope',$item->id_scope)->count()];
            $category_data[$key]['color'] = $this->rand_color();
        }
        $data['gr_category_data'] = json_encode($category_data);
        $data['gr_category'] = json_encode($category_);
        $data['slug'] = $slug;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.statistics_abstract',$data);
    }
    private function rand_color() {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }
    public function qa_forum($slug){
        $data['slug'] = $slug;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.qa_forum',$data);
    }
    public function qa_forum_detail($slug,$no_abstract,$id=NULL){
        $stmt = TbJurnalModel::select('tb_jurnal.*','tb_jurnal_author.nama_depan','tb_jurnal_author.nama_tengah','tb_jurnal_author.nama_belakang','tb_author.no_author','tb_sub.slug','tb_event.event','tb_event.tahun_event')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->join('tb_jurnal_author','tb_jurnal_author.id_jurnal_author','=','tb_jurnal.id_jurnal_author','LEFT')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_author.id_author','LEFT')
            ->where(array('tb_jurnal.no_abstrak'=>$no_abstract))->first();
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
        $data['slug'] = $slug;
        $data['id'] = $id;
        $data['no_abs'] = $no_abstract;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.qa_forum_detail',$data);
    }
    public function profile($slug,$no_author){
        $data['slug'] = $slug;
        $data['data'] = $author = TbAuthorModel::where('no_author','=',$no_author)->first();
        $data['jurnal'] = TbJurnalModel::where('id_author','=',$author->id_author)->get();
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.profile',$data);
    }
    public function abstract($slug,$no_abstract){
        $data['slug'] = $slug;
        $stmt = TbJurnalModel::select('tb_jurnal.*','tb_scope.scope','tb_jurnal_author.nama_depan','tb_jurnal_author.nama_tengah','tb_jurnal_author.nama_belakang','tb_author.no_author','tb_sub.slug','tb_event.event','tb_event.tahun_event')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->join('tb_event','tb_event.id_event','=','tb_jurnal.id_event')
            ->join('tb_jurnal_author','tb_jurnal_author.id_jurnal_author','=','tb_jurnal.id_jurnal_author','LEFT')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal_author.id_author','LEFT')
            ->where(array('tb_jurnal.no_abstrak'=>$no_abstract))->first();
        if (empty($stmt->nama_depan)) {
            $cor = TbJurnalModel::select('tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang')
                ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author')->where('tb_jurnal.no_abstrak',$no_abstract)->first();
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
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.abstract',$data);
    }
    public function login($slug=null){
        if (Session::has('tic-admin')){
            //return redirect(url('/admin'));
        }
        if (empty($slug)){
            $slug = TbSubModel::select('tb_sub.slug')
                ->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
                ->where('tb_event.stt_aktif',1)
                ->first()->slug;
        }
        $data['slug'] = $slug;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.login',$data);
    }
    public function forgot($slug=null){
        if (empty($slug)){
            $slug = TbSubModel::select('tb_sub.slug')
                ->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
                ->where('tb_event.stt_aktif',1)
                ->first()->slug;
        }
        $data['slug'] = $slug;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        return view('sub.forgot',$data);
    }
    public function registration($slug){
        $where = array('stt_data'=>"PUBLISH",'del_flage'=>0);
        $data['dt_pamflet'] = TbEventModel::where('stt_aktif',1)->first();
        $data['dt_negara'] = TbNegaraModel::where($where)->get();
        $data['dt_gelar'] = TbGelarModel::where($where)->get();
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        $data['slug'] = $slug;
        return view('sub.registration',$data);
    }

    public function payment($slug){
        $dt_event = TbEventModel::where('stt_aktif',1)->first();
        $setting = TbSettingModel::where('id_event',$dt_event->id_event)->first();
        $where = array('del_flage'=>0,'stt_data'=>"PUBLISH",'id_event'=>$dt_event->id_event);
        $data['dt_fee'] = $setting->fee;
        $data['dt_bank'] = TbJenisPembayaranModel::where($where)->get();
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        $data['slug'] = $slug;
        return view('sub.payment',$data);
    }

    public function download($slug){
        $sub = TbSubModel::select('tb_sub.*','tb_event.id_event')
            ->join('tb_event','tb_event.id_event','=','tb_sub.id_event')
            ->where(array('tb_sub.slug'=>$slug,'tb_event.stt_aktif'=>1))
            ->first();
        $data['dt_sub'] = $sub;
        $data['dt_kontak'] = $this->dt_kontak();
        $data['dt_sosmed'] = $this->dt_sosmed();
        $data['slug'] = $slug;
        return view('sub.download',$data);
    }
    public function login_admin(){
        return view('sub.login_admin');
    }

    public function getVideo($slug, Request $request){
        $search = $request->search;
        $offset = $request->offset;
        $stmt_data = TbJurnalModel::select('tb_jurnal.*','tb_sub_scope.scope','tb_jurnal_author.nama_depan','tb_jurnal_author.nama_tengah','tb_jurnal_author.nama_belakang')
            ->join('tb_sub_scope','tb_sub_scope.id_tb_sub_scope','=','tb_jurnal.id_tb_sub_scope')
            ->join('tb_sub','tb_sub.id_tb_sub','=','tb_sub_scope.id_tb_sub')
            ->join('tb_jurnal_author','tb_jurnal_author.id_tb_jurnal_author','=','tb_jurnal.id_tb_jurnal_author','LEFT')
            ->where(array('tb_jurnal.del_flage'=>0,'tb_sub.slug'=>$slug))
            ->whereNotNull('link_video')
            ->latest('tb_jurnal.id_tb_jurnal')->where(function($query) use ($search) {
                $query->where('tb_jurnal.judul_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('tb_jurnal.abstrak_jurnal', 'LIKE', '%'.$search.'%')
                    ->orWhere('tb_jurnal.keyword_jurnal', 'LIKE', '%'.$search.'%');
            })->offset($offset)->limit(2);

        $stmt_ttl = TbJurnalModel::where(array('del_flage'=>0,'stt_jurnal'=>"PUBLISH"))
            ->whereNotNull('link_video')
            ->latest('id_tb_jurnal')->where(function($query) use ($search) {
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
                $dt[$no]['abstrac'] = $item->abstrak_jurnal;
                $dt[$no]['keyword'] = $item->keyword_jurnal;
                $dt[$no]['scope'] = $item->scope;
                $dt[$no]['link_video'] = $item->link_video;
                $dt[$no]['link_video_embed'] = $item->link_video_embed;
                $dt[$no]['slug'] = $item->slug_jurnal;
                $dt[$no]['nama_depan'] = $item->nama_depan;
                $dt[$no]['nama_tengah'] = $item->nama_tengah;
                $dt[$no]['nama_belakang'] = $item->nama_belakang;
                $dt[$no]['ttl_qa'] = TbJurnalQAModel::where('id_tb_jurnal',$item->id_tb_jurnal)->count();;
                $dt_author_nama = "";
                $dt_author_email = "";
                $no_author = 1;
                $dt_author_ttl = TbJurnalAuthorModel::where('id_tb_jurnal',$item->id_tb_jurnal)->count();
                $dt_author_data = TbJurnalAuthorModel::where('id_tb_jurnal',$item->id_tb_jurnal)->get();
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
                $no++;
            }
            $data['data'] = $dt;
            $data['ttl'] = $stmt_ttl->count();
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>"Failed To Display Data "]);
        }
    }

    public function getForum($slug,Request $request){
        $search = $request->search;
        $offset = $request->offset;
        $order = $request->order;
        $stmt = TbJurnalQAModel::select('tb_jurnal_qa.*','tb_author_qa.foto_author as foto_author_qa','tb_author_qa.nama_depan as nama_depan_qa','tb_author_qa.nama_tengah as nama_tengah_qa','tb_author_qa.nama_belakang as nama_belakang_qa','tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang','tb_author.no_author','tb_jurnal.judul_jurnal','tb_jurnal.slug_jurnal')
            ->join('tb_author as tb_author_qa','tb_author_qa.id_tb_author','=','tb_jurnal_qa.id_tb_author')
            ->join('tb_jurnal','tb_jurnal.id_tb_jurnal','=','tb_jurnal_qa.id_tb_jurnal')
            ->join('tb_author','tb_author.id_tb_author','=','tb_jurnal.id_tb_author')
            ->where(array('tb_jurnal_qa.del_flage'=>0, 'tb_jurnal.del_flage'=>0))
            ->orderBy('tb_jurnal_qa.id_tb_jurnal_qa',$order)->offset($offset)->limit(2);
        if ($stmt){
            $dt = array();
            foreach ($stmt->get() as $key => $item){
                $dt[$key]['id'] = $item->id_tb_jurnal_qa;
                $dt[$key]['pertanyaan'] = $item->pertanyaan;
                $dt[$key]['cdate'] = $item->cdate;
                $dt[$key]['foto_author_qa'] = $item->foto_author_qa;
                $dt[$key]['nama_depan_qa'] = $item->nama_depan_qa;
                $dt[$key]['nama_tengah_qa'] = $item->nama_tengah_qa;
                $dt[$key]['nama_belakang_qa'] = $item->nama_belakang_qa;
                $dt[$key]['judul_jurnal'] = $item->judul_jurnal;
                $dt[$key]['slug_jurnal'] = $item->slug_jurnal;
                $dt[$key]['no_author'] = $item->no_author;
                $dt[$key]['nama_depan'] = $item->nama_depan;
                $dt[$key]['nama_tengah'] = $item->nama_tengah;
                $dt[$key]['nama_belakang'] = $item->nama_belakang;
                $dt[$key]['ttl'] = TbJurnalQASubModel::where(array('id_tb_jurnal_qa'=>$item->id_tb_jurnal_qa,'del_flage'=>0))->count();
            }
            $data['status'] = "OK";
            $data['data'] = $dt;
            $data['ttl'] = $stmt->count();
            return response()->json($data);
        } else {
            return response()->json(['status' => "ERROR", 'message'=>"Failed To Display Data "]);
        }
    }

    private function dt_kontak(){
        return TbKontakModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();
    }
    private function dt_sosmed(){
        return TbSosmedModel::where(array('stt_data'=>"PUBLISH",'del_flage'=>0))->get();
    }
}
