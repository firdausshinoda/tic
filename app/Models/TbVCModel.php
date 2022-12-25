<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbVCModel extends Model
{
    use HasFactory;
    protected $table = 'tb_vc';
    public $timestamps = false;

    protected $fillable = [
        'id_vc',
        'id_sub',
        'vc',
        'icon',
        'link',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
