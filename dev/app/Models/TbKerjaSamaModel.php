<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbKerjaSamaModel extends Model
{
    use HasFactory;
    protected $table = 'tb_kerjasama';
    public $timestamps = false;

    protected $fillable = [
        'id_kerjasama',
        'id_event',
        'logo',
        'nama',
        'link'.
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
