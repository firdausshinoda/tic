<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbNotifReviewerModel extends Model
{
    use HasFactory;
    protected $table = 'tb_notif_reviewer';
    public $timestamps = false;

    protected $fillable = [
        'id_notif_reviewer',
        'id_jurnal',
        'id_jurnal_qa',
        'id_reviewer',
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
