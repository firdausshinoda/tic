<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbInvitedSpeakerModel extends Model
{
    use HasFactory;
    protected $table = 'tb_invited_speaker';
    public $timestamps = false;

    protected $fillable = [
        'id_invited_speaker',
        'id_event',
        'thumbnail',
        'nama',
        'institusi',
        'topik',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
