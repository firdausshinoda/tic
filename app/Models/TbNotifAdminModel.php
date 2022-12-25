<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbNotifAdminModel extends Model
{
    use HasFactory;
    protected $table = 'tb_notif_admin';
    public $timestamps = false;

    protected $fillable = [
        'id_notif_admin',
        'id_author',
        'id_participan',
        'id_jurnal',
        'judul',
        'pesan',
        'stt_view',
        'stt_notif',
        'stt_user',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
