<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbCoHostModel extends Model
{
    use HasFactory;
    protected $table = 'tb_cohost';
    public $timestamps = false;

    protected $fillable = [
        'id_cohost',
        'id_event',
        'thumbnail',
        'nama',
        'link',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
