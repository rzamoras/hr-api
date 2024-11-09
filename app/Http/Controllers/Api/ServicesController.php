<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->where('is_custom', false)
            ->get();

        return response()->json($services);
    }

    public function allServices()
    {
        $services = Service::query()
            ->where('is_custom', false)
            ->get();

        $other_services = Service::query()
            ->whereHas('csm_responses', function ($q) {
                $q->where('is_custom', true);
            })
            ->get();

        $services = $services->merge($other_services);

        return response()->json($services);
    }
}
