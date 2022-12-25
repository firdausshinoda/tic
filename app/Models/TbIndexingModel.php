<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbIndexingModel extends Model
{
    use HasFactory;
    protected $table = 'tb_indexing';
    public $timestamps = false;

    protected $fillable = [
        'id_indexing',
        'nama',
        'logo',
        'link',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
