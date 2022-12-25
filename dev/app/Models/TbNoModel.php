<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbNoModel extends Model
{
    use HasFactory;
    protected $table = 'tb_no';
    public $timestamps = false;

    protected $fillable = [
        'id_no',
        'id_event',
        'no_abs',
        'no_author',
        'no_participan',
        'created_at',
        'updated_at'
    ];
}
