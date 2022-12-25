<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbNotifAuthorModel extends Model
{
    use HasFactory;
    protected $table = 'tb_notif_author';
    public $timestamps = false;

    protected $fillable = [
        'id_notif_author',
        'id_jurnal',
        'id_jurnal_qa',
        'id_author',
        'judul',
        'pesan',
        'stt_view',
        'stt_notif',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
