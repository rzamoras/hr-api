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
        ], [
            'cc1.required' => 'The CC1 item is required.',
            'cc2.required' => 'The CC2 item is required.',
            'cc3.required' => 'The CC3 item is required.',
            'sqd0.required' => 'The SQD0 item is required.',
            'sqd1.required' => 'The SQD1 item is required.',
            'sqd2.required' => 'The SQD2 item is required.',
            'sqd3.required' => 'The SQD3 item is required.',
            'sqd4.required' => 'The SQD4 item is required.',
            'sqd5.required' => 'The SQD5 item is required.',
            'sqd6.required' => 'The SQD6 item is required.',
            'sqd7.required' => 'The SQD7 item is required.',
            'sqd8.required' => 'The SQD8 item is required.',
        ]);

        $response = new CsmResponse($responses);
        $response->save();

        return response()->json([$responses]);
    }

    public function responses()
    {
        $responses = CsmResponse::latest()->paginate(5);

        return response()->json($responses);
    }
}
