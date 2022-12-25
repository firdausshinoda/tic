<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbGelarModel extends Model
{
    use HasFactory;
    protected $table = 'tb_gelar';
    public $timestamps = false;

    protected $fillable = [
        'id_gelar',
        'gelar',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
