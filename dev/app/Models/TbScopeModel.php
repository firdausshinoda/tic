<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbScopeModel extends Model
{
    use HasFactory;
    protected $table = 'tb_scope';
    public $timestamps = false;

    protected $fillable = [
        'id_scope',
        'id_sub',
        'scope',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
