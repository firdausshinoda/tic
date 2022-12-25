<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbJurnalPendukungModel extends Model
{
    use HasFactory;
    protected $table = 'tb_jurnal_pendukung';
    public $timestamps = false;

    protected $fillable = [
        'id_jurnal_pendukung',
        'id_jurnal',
        'file_nama',
        'file_pendukung',
        'file_tipe',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
