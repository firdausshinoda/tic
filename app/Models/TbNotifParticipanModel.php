<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbNotifParticipanModel extends Model
{
    use HasFactory;
    protected $table = 'tb_notif_participan';
    public $timestamps = false;

    protected $fillable = [
        'id_notif_participan',
        'id_participan',
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
