<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbAuthorModel extends Model
{
    use HasFactory;
    protected $table = 'tb_author';
    public $timestamps = false;

    protected $fillable = [
        'id_author',
        'id_gelar',
        'id_negara',
        'no_author',
        'foto_author',
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
        'email_password'.
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
