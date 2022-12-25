<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbTimelineModel extends Model
{
    use HasFactory;
    protected $table = 'tb_timeline';
    public $timestamps = false;

    protected $fillable = [
        'id_timeline',
        'id_event',
        'timeline',
        'date',
        'stt_data',
        'created_at',
        'updated_at',
        'deleted_at',
        'del_flage'
    ];
}
