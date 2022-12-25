<?php

namespace App\Exports;

use App\Models\TbJurnalModel;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JournalExport  implements FromCollection, WithHeadings {

    protected $data;
    function __construct($data) {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            ['No Abstrak','Nama Depan','Nama Tengah','Nama Belakang','Sub','Scope','Judul','Abstrak','Keyword','Tanggal']
        ];
    }
}

