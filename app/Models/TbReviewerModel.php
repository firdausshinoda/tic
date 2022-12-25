<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbReviewerModel extends Model
{
    use HasFactory;
    protected $table = 'tb_reviewer';
    public $timestamps = false;

    protected $fillable = [
        'id_reviewer',
        'foto_reviewer',
        'password',
        'email',
        'nama_depan',
        'nama_tengah',
        'nama_belakang',
        'jenis_kelamin',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
