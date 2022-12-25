<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbSubModel extends Model
{
    use HasFactory;
    protected $table = 'tb_sub';
    public $timestamps = false;

    protected $fillable = [
        'id_sub',
        'id_event',
        'sub',
        'slug',
        'thumbnail',
        'deskripsi',
        'template',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
