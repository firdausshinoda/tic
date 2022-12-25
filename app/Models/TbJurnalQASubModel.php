<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbJurnalQASubModel extends Model
{
    use HasFactory;
    protected $table = 'tb_jurnal_qa_sub';
    public $timestamps = false;

    protected $fillable = [
        'id_jurnal_qa_sub',
        'id_jurnal_qa',
        'id_author',
        'id_reviewer',
        'stt_user',
        'pertanyaan',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
