<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbJurnalRevisiModel extends Model
{
    use HasFactory;
    protected $table = 'tb_jurnal_revisi';
    public $timestamps = false;

    protected $fillable = [
        'id_jurnal_revisi',
        'id_jurnal',
        'revisi_ke',
        'revisi',
        'file_revisi_viewer',
        'file_revisi_author',
        'stt_revisi',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
