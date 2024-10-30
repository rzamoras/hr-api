<?php

namespace App\Imports;

use App\Models\OfficeSection;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OfficeSectionImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Model|OfficeSection|null
     */
    public function model(array $row): Model|OfficeSection|null
    {
        return new OfficeSection([
            'office_code' => $row['office_code'],
            'name' => $row['name'],
            'code' => $row['code'],
        ]);
    }
}
