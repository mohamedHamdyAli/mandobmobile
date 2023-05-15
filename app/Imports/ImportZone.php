<?php

namespace App\Imports;

use App\Models\Zone;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportZone implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return Zone::updateOrCreate([
            'name_en' => $row[0],
            'name_ar' => $row[1],
        ]);
    }
}
