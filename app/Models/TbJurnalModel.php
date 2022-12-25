<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbJurnalModel extends Model
{
    use HasFactory;
    protected $table = 'tb_jurnal';
    public $timestamps = false;

    protected $fillable = [
        'id_jurnal',
        'id_event',
        'id_scope',
        'id_author',
        'id_jurnal_author',
        'id_author_corresponding',
        'id_jenis_pembayaran',
        'id_reviewer',
        'no_abstrak',
        'slug_jurnal',
        'judul_jurnal',
        'abstrak_jurnal',
        'abstrak_jurnal_normal',
        'file_nama',
        'file_pembayaran',
        'tipe_pembayaran',
        'keyword_jurnal',
        'link_video',
        'pembayaran_an',
        'pembayaran_bank',
        'pembayaran_invoice',
        'stt_pembayaran',
        'stt_pembayaran_date_upload',
        'stt_pembayaran_konfirmasi',
        'stt_jurnal',
        'stt_full_paper',
        'stt_revisi_paper',
        'stt_progres_paper',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
