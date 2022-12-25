<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbJurnalAuthorModel extends Model
{
    use HasFactory;
    protected $table = 'tb_jurnal_author';
    public $timestamps = false;

    protected $fillable = [
        'id_jurnal_author',
        'id_author',
        'id_jurnal',
        'id_negara',
        'nama_depan',
        'nama_tengah',
        'nama_belakang',
        'email',
        'orcid_id',
        'institusi',
        'biodate',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
