<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbKontakModel extends Model
{
    use HasFactory;
    protected $table = 'tb_kontak';
    public $timestamps = false;

    protected $fillable = [
        'id_kontak',
        'judul',
        'icon',
        'isi',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
