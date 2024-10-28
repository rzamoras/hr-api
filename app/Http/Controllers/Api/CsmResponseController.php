<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CsmResponse;
use Illuminate\Http\Request;

class CsmResponseController extends Controller
{
    public function store(Request $request)
    {
        $responses = $request->validate([
            'control_no' => 'required',
            'client_type' => 'required',
            'response_date' => 'required',
            'sex' => 'required',
            'age' => 'required',
            'region' => 'required',
            'service_availed' => 'required',
            'service_type' => 'required',
            'cc1' => 'required',
            'cc2' => 'required',
            'cc3' => 'required',
            'sqd0' => 'required',
            'sqd1' => 'required',
            'sqd2' => 'required',
            'sqd3' => 'required',
            'sqd4' => 'required',
            'sqd5' => 'required',
            'sqd6' => 'required',
            'sqd7' => 'required',
            'sqd8' => 'required',
            'suggestion' => 'sometimes',
            'email' => 'sometimes',
        ]);

        CsmResponse::create($responses);

        return response()->json([$responses]);
    }
}
