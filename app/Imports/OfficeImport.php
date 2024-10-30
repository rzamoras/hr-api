<?php

namespace App\Imports;

use App\Models\Office;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OfficeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Model|Office|null
     */
    public function model(array $row): Model|Office|null
    {
        return new Office([
            'code' => $row['code'],
            'department' => $row['department'],
        ]);
    }
}
