<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbEventModel extends Model
{
    use HasFactory;
    protected $table = 'tb_event';
    public $timestamps = false;

    protected $fillable = [
        'id_event',
        'event',
        'slug_event',
        'tahun_event',
        'pamflet',
        'stt_aktif',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
