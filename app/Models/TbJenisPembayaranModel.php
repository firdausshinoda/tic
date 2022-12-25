<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbJenisPembayaranModel extends Model
{
    use HasFactory;
    protected $table = 'tb_jenis_pembayaran';
    public $timestamps = false;

    protected $fillable = [
        'id_jenis_pembayaran',
        'id_event',
        'jenis_pembayaran',
        'nama_jenis_pembayaran',
        'nomor_jenis_pembayaran',
        'an_jenis_pembayaran',
        'logo_1',
        'logo_2',
        'logo_3',
        'logo_4',
        'logo_5',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
