<?php

namespace App\Http\Controllers;

use App\Exports\JournalExport;
use App\Models\TbJurnalAuthorModel;
use App\Models\TbJurnalModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function journal_doc(Request $request) {
        if (empty($request->abs)) {
            return redirect(url('/'));
        }
        $string_remove = "Abstract";
        $comma_single_top = array('&#39;','&rsquo;');

        $stmt = TbJurnalModel::select('tb_jurnal.*','tb_author.nama_depan','tb_author.nama_tengah','tb_author.nama_belakang','tb_jurnal.judul_jurnal',
            'tb_jurnal.abstrak_jurnal','tb_jurnal.keyword_jurnal')
            ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author')
            ->where(array('tb_jurnal.del_flage'=>0,'tb_jurnal.no_abstrak'=>$request->abs));
        if ($stmt->count() == 0) {
            return redirect(url('/'));
        } else {
            $metadata = TbJurnalAuthorModel::select('tb_jurnal_author.nama_depan','tb_jurnal_author.nama_tengah','tb_jurnal_author.nama_belakang','tb_jurnal_author.institusi',
                'tb_jurnal_author.email')
                ->join('tb_jurnal','tb_jurnal.id_jurnal','=','tb_jurnal_author.id_jurnal')
                ->where(array('tb_jurnal_author.del_flage'=>0,'tb_jurnal.no_abstrak'=>$request->abs))->get();
            $nama_metadata = null;
            $nama_institusi = null;
            $email = null;
            foreach ($metadata as $key => $item) {
                if (empty($nama_metadata)) {
                    $nama_metadata = $item->nama_depan." ".$item->nama_tengah." ".$item->nama_belakang;
                    $nama_institusi = ucwords(strtolower($item->institusi));
                    $email = $item->email;
                } else {
                    $nama_metadata .= ", ".$item->nama_depan." ".$item->nama_tengah." ".$item->nama_belakang;
                }
                $nama_metadata = ucwords(strtolower($nama_metadata));
            }
            $data = $stmt->first();
            $isi = strip_tags($data->abstrak_jurnal);
            $isi = preg_replace('/^' . preg_quote($string_remove, '/') . '/', '', $isi);
            $isi = ltrim($isi);
            $isi = str_replace($comma_single_top,"'",$isi);
            $isi = str_replace('&nbsp;'," ",$isi);
            $isi = preg_replace('/^' . preg_quote($string_remove, '/') . '/', '', $isi);
            $isi = ltrim($isi);

            $keywords = str_replace(',',";",$data->keyword_jurnal);
            $keywords = str_replace('Keywords:',"",$keywords);
            $keywords = str_replace('Keywords',"",$keywords);
            $keywords = ucwords(strtolower($keywords));

            $wordTest = new \PhpOffice\PhpWord\PhpWord();
            $newSection = $wordTest->addSection();
            $newSection->addText($data->judul_jurnal,['name'=>"Times New Roman",'size'=>14,'bold'=>true],['align'=>"center"]);
            $newSection->addText("");
            $newSection->addText($nama_metadata,['name'=>"Times New Roman",'size'=>12,'bold'=>true],['align'=>"center"]);
            $newSection->addText($nama_institusi,['name'=>"Times New Roman",'size'=>12,'bold'=>true],['align'=>"center"]);
            $newSection->addText($email,['name'=>"Times New Roman",'size'=>12],['align'=>"center"]);
            $newSection->addText("");
            $newSection->addText("ABSTRACT",['name'=>"Times New Roman",'size'=>12,'bold'=>true],['align'=>"center"]);
            $newSection->addText("");
            $newSection->addText($isi,['name'=>"Times New Roman",'size'=>12],['align'=>"both"]);
            $newSection->addText("Keywords: ".$keywords,['name'=>"Times New Roman",'size'=>10,'italic'=>true]);

            $objectWriter = \PhpOffice\PhpWord\IOFactory::createWriter($wordTest, 'Word2007');
            $nama_file = ucwords(strtolower($data->judul_jurnal));

            $replace_name = array('\'',':','/','*','?','<','>','|');
            $nama_file = str_replace($replace_name,"",$nama_file);
            try {
                $objectWriter->save(storage_path($nama_file.'.docx'));
            } catch (Exception $e) {

            }
            return response()->download(storage_path($nama_file.'.docx'));
        }
    }

    public function journal_exel() {
        $select = 'tb_jurnal.no_abstrak,
            tb_author.nama_depan,
            tb_author.nama_tengah,
            tb_author.nama_belakang,
            tb_sub.sub,
            tb_scope.scope,
            tb_jurnal.judul_jurnal,
            fnStripTags(tb_jurnal.abstrak_jurnal),
            tb_jurnal.keyword_jurnal,
            tb_jurnal.created_at';
        $stmt = TbJurnalModel::selectRaw($select)
            ->join('tb_author','tb_author.id_author','=','tb_jurnal.id_author')
            ->join('tb_scope','tb_scope.id_scope','=','tb_jurnal.id_scope')
            ->join('tb_sub','tb_sub.id_sub','=','tb_scope.id_sub')
            ->where(array('tb_jurnal.stt_jurnal'=>"COMPLETED FOR A REVIEW",'tb_jurnal.del_flage'=>0))
            ->whereNull('tb_jurnal.id_reviewer')
            ->get();
//        $data = array();
//        foreach ($stmt as $key => $item) {
//            $data[$key]['no_abstrak'] = $item->no_abstrak;
//            $data[$key]['nama_depan'] = $item->nama_depan;
//            $data[$key]['nama_tengah'] = $item->nama_tengah;
//            $data[$key]['nama_belakang'] = $item->nama_belakang;
//            $data[$key]['sub'] = $item->sub;
//            $data[$key]['scope'] = $item->scope;
//            $data[$key]['judul_jurnal'] = $item->judul_jurnal;
//            $data[$key]['abstrak_jurnal'] = $item->abstrak_jurnal;
//            $data[$key]['keyword_jurnal'] = $item->keyword_jurnal;
//            $data[$key]['created_at'] = $item->created_at;
//        }
        // return response()->json($stmt);
        return Excel::download(new JournalExport($stmt),'Journal Update 14-11-2021.xlsx');
    }

//    FUNTION STRIP_TAGS MYSQL
//DROP FUNCTION IF EXISTS fnStripTags;
//DELIMITER |
//CREATE FUNCTION fnStripTags( Dirty varchar(4000) )
//RETURNS varchar(4000)
//DETERMINISTIC
//BEGIN
//  DECLARE iStart, iEnd, iLength int;
//    WHILE Locate( '<', Dirty ) > 0 And Locate( '>', Dirty, Locate( '<', Dirty )) > 0 DO
//      BEGIN
//        SET iStart = Locate( '<', Dirty ), iEnd = Locate( '>', Dirty, Locate('<', Dirty ));
//        SET iLength = ( iEnd - iStart) + 1;
//        IF iLength > 0 THEN
//          BEGIN
//            SET Dirty = Insert( Dirty, iStart, iLength, '');
//          END;
//        END IF;
//      END;
//    END WHILE;
//    RETURN Dirty;
//END;
//|
//DELIMITER ;
}
