<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbNegaraModel extends Model
{
    use HasFactory;
    protected $table = 'tb_negara';
    public $timestamps = false;

    protected $fillable = [
        'id_negara',
        'negara',
        'phone_code',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
