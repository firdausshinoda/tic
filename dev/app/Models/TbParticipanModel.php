<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbParticipanModel extends Model
{
    use HasFactory;
    protected $table = 'tb_participan';
    public $timestamps = false;

    protected $fillable = [
        'id_participan',
        'id_gelar',
        'id_negara',
        'id_event',
        'no_participan',
        'foto_participan',
        'nama_depan',
        'nama_tengah',
        'nama_belakang',
        'jenis_kelamin',
        'tgl_lahir',
        'pddk_terakhir',
        'institusi',
        'research',
        'email',
        'alamat',
        'kota',
        'kode_pos',
        'no_hp',
        'no_fax',
        'orcid_id',
        'informasi_lain',
        'password',
        'email_password',
        'pembayaran_bank',
        'pembayaran_an',
        'pembayaran_invoice',
        'stt_pembayaran',
        'stt_pembayaran_konfirmasi',
        'file_pembayaran',
        'tipe_pembayaran',
        'stt_pembayaran_date_upload',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
