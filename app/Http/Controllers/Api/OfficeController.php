<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Imports\OfficeImport;
use App\Models\Office;
use App\Models\OfficeSection;
use Maatwebsite\Excel\Facades\Excel;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::with('sections')->get();

        return response()->json($offices);
    }

    public function importOffices()
    {
        Excel::import(new OfficeImport, './public/csv/department.csv');

        return response()->json('success');
    }

    public function sections($id)
    {
        $sections = OfficeSection::where('office_id', $id)->get();

        return response()->json($sections);
    }
}
