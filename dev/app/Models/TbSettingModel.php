<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbSettingModel extends Model
{
    use HasFactory;
    protected $table = 'tb_setting';
    public $timestamps = false;

    protected $fillable = [
        'id_setting',
        'id_event',
        'tema',
        'deskripsi_singkat',
        'deskripsi_panjang',
        'deskripsi_kategori',
        'submission',
        'publication_opportunity',
        'committee',
        'call_for_paper',
        'fee',
        'about',
        'faq',
        'harga_jurnal_lokal',
        'harga_jurnal_internasional',
        'harga_participan_lokal',
        'harga_participan_internasional',
        'tgl_mulai_pendaftaran',
        'tgl_akhir_pendaftaran',
        'tgl_akhir_abstrak',
        'tgl_akhir_pembayaran',
        'tgl_akhir_full_paper',
        'tgl_akhir_video',
        'tgl_mulai_qa',
        'tgl_akhir_qa',
        'tgl_loi',
        'tgl_conference',
        'ketua_nama',
        'ketua_file_ttd',
        'bendahara_nama',
        'bendahara_file_ttd',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
