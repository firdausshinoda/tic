<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbSosmedModel extends Model
{
    use HasFactory;
    protected $table = 'tb_sosmed';
    public $timestamps = false;

    protected $fillable = [
        'id_sosmed',
        'icon',
        'sosmed',
        'link',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
