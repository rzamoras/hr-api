<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CsmResponse;
use App\Models\Report;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Process;
use function PHPSTORM_META\map;

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
            'service_id' => 'required',
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

        if (is_array($request->service_id) && isset($request->service_id['id'])) {
            $response->service_id = $request->service_id['id'];
        } else {
            $service = Service::query()
                ->where('name', $request->service_id)
                ->first();

            if (!$service) {
                $service = new Service;
                $service->name = $request->service_id;
                $service->save();
            }

            $response->service()->associate($service);
        }
        $response->save();

        return response()->json([$responses]);
    }

    public function responses()
    {
        $responses = CsmResponse::latest()->paginate(5);

        return response()->json($responses);
    }

    public function otherTransactions(Request $request)
    {
        $others = CsmResponse::with('service')
            ->whereYear("response_date", "2024")
            ->latest('response_date')
            ->get();

        $others = $others
            ->groupBy(function ($item) {
                return Carbon::parse($item->response_date)->format("Y-m");
            })
            ->map(function ($group) {
                return $group->groupBy(function ($item) {
                    return $item->service->name;
                })->map(function ($serviceGroup) {
                    $service_name = $serviceGroup->first()->service->name;
                    $is_others = (boolean)$serviceGroup->first()->service->is_custom;
                    $date = $serviceGroup->first()->response_date;
                    return [
                        "internal" => $serviceGroup->where('service_type', 'Internal Service')->count(),
                        "external" => $serviceGroup->where('service_type', 'External Service')->count(),
                        "service" => $service_name,
                        "is_others" => $is_others,
                        "date" => $date,
                    ];
                })->values();
            });

        return response()->json($others);
    }

    public function clientTransactions(Request $request)
    {
        $transactions = CsmResponse::with('service')
            ->whereYear("response_date", "2024")
            ->latest('response_date')
            ->get();

        $transactions = $transactions
            ->groupBy(function ($item) {
                return Carbon::parse($item->response_date)->format("Y-m");
            })
            ->map(function ($group) {
                return [
                    "basic_services" => [
                        "internal" => $group
                            ->where("service.name", "Avail Basic Services")
                            ->where("service_type", "Internal Service")
                            ->count(),
                        "external" => $group
                            ->where("service.name", "Avail Basic Services")
                            ->where("service_type", "External Service")
                            ->count(),
                    ],
                    "inquiry" => [
                        "internal" => $group
                            ->where("service.name", "Inquiry or Follow up Transactions")
                            ->where("service_type", "Internal Service")
                            ->count(),
                        "external" => $group
                            ->where("service.name", "Inquiry or Follow up Transactions")
                            ->where("service_type", "External Service")
                            ->count(),
                    ],
                    "documents" => [
                        "internal" => $group
                            ->where("service.name", "Pick up or Drop Off Documents")
                            ->where("service_type", "Internal Service")
                            ->count(),
                        "external" => $group
                            ->where("service.name", "Pick up or Drop Off Documents")
                            ->where("service_type", "External Service")
                            ->count(),
                    ],
                    "appointment" => [
                        "internal" => $group
                            ->where("service.name", "Meeting or Appointment")
                            ->where("service_type", "Internal Service")
                            ->count(),
                        "external" => $group
                            ->where("service.name", "Meeting or Appointment")
                            ->where("service_type", "External Service")
                            ->count(),
                    ],
                    "date" => $group
                        ->select('response_date')
                        ->first(),
                ];
            });

        // Count basic services
        $sum_basic_services_in = CsmResponse::query()
            ->whereHas('service', function ($query) {
                $query->where('name', 'Avail Basic Services');
            })
            ->where("service_type", "Internal Service")
            ->whereYear('response_date', "2024")
            ->count();

        $sum_basic_services_ex = CsmResponse::query()
            ->whereHas('service', function ($query) {
                $query->where('name', 'Avail Basic Services');
            })
            ->whereYear('response_date', "2024")
            ->where("service_type", "External Service")
            ->count();

        // Count inquiry
        $sum_inquiry_in = CsmResponse::query()
            ->whereHas('service', function ($query) {
                $query->where('name', 'Inquiry or Follow up Transactions');
            })
            ->whereYear('response_date', "2024")
            ->where("service_type", "Internal Service")
            ->count();

        $sum_inquiry_ex = CsmResponse::query()
            ->whereHas('service', function ($query) {
                $query->where('name', 'Inquiry or Follow up Transactions');
            })
            ->whereYear('response_date', "2024")
            ->where("service_type", "External Service")
            ->count();

        // Count documents
        $sum_documents_in = CsmResponse::query()
            ->whereHas('service', function ($query) {
                $query->where('name', 'Pick up or Drop Off Documents');
            })
            ->whereYear('response_date', "2024")
            ->where("service_type", "Internal Service")
            ->count();

        $sum_documents_ex = CsmResponse::query()
            ->whereHas('service', function ($query) {
                $query->where('name', 'Pick up or Drop Off Documents');
            })
            ->whereYear('response_date', "2024")
            ->where("service_type", "External Service")
            ->count();

        // Count appointment
        $sum_appointment_in = CsmResponse::query()
            ->whereHas('service', function ($query) {
                $query->where('name', 'Meeting or Appointment');
            })
            ->whereYear('response_date', "2024")
            ->where("service_type", "Internal Service")
            ->count();

        $sum_appointment_ex = CsmResponse::query()
            ->whereHas('service', function ($query) {
                $query->where('name', 'Meeting or Appointment');
            })
            ->whereYear('response_date', "2024")
            ->where("service_type", "External Service")
            ->count();

        $others = $this->otherTransactions($request);

        return response()->json([
            "transactions" => $transactions,
            "sum_basic_services_in" => $sum_basic_services_in,
            "sum_basic_services_ex" => $sum_basic_services_ex,
            "sum_inquiry_in" => $sum_inquiry_in,
            "sum_inquiry_ex" => $sum_inquiry_ex,
            "sum_documents_in" => $sum_documents_in,
            "sum_documents_ex" => $sum_documents_ex,
            "sum_appointment_in" => $sum_appointment_in,
            "sum_appointment_ex" => $sum_appointment_ex,
            "other_transactions" => $others->original,
        ]);
    }

    public function desktopTransactions(Request $request)
    {
        $transactions = CsmResponse::with('service')
            ->whereYear("response_date", "2024")
            ->latest('response_date')
            ->get();

        $transactions = $transactions
            ->groupBy(function ($item) {
                return Carbon::parse($item->response_date)->format("Y-m");
            })
            ->map(function ($group) {
                return [
                    "basic_services" => [
                        "internal" => $group
                            ->where("service.name", "Avail Basic Services")
                            ->where("service_type", "Internal Service")
                            ->count(),
                        "external" => $group
                            ->where("service.name", "Avail Basic Services")
                            ->where("service_type", "External Service")
                            ->count(),
                    ],
                    "inquiry" => [
                        "internal" => $group
                            ->where("service.name", "Inquiry or Follow up Transactions")
                            ->where("service_type", "Internal Service")
                            ->count(),
                        "external" => $group
                            ->where("service.name", "Inquiry or Follow up Transactions")
                            ->where("service_type", "External Service")
                            ->count(),
                    ],
                    "documents" => [
                        "internal" => $group
                            ->where("service.name", "Pick up or Drop Off Documents")
                            ->where("service_type", "Internal Service")
                            ->count(),
                        "external" => $group
                            ->where("service.name", "Pick up or Drop Off Documents")
                            ->where("service_type", "External Service")
                            ->count(),
                    ],
                    "appointment" => [
                        "internal" => $group
                            ->where("service.name", "Meeting or Appointment")
                            ->where("service_type", "Internal Service")
                            ->count(),
                        "external" => $group
                            ->where("service.name", "Meeting or Appointment")
                            ->where("service_type", "External Service")
                            ->count(),
                    ],
                    "date" => [
                        "month" => Carbon::parse($group->first()->response_date)->format("F"),
                    ]
                ];
            })
            ->values();

        return response()->json($transactions);
    }

    public function generateCsmReport(Request $request)
    {
        $auth = Auth::user();

        $file_name = 'CSM_REPORT' . now()->format('_Y-m-d_H-i-s');
        $command = [
            "D:\Test\app\DotNetConsoleReporter.exe",
            $file_name,
            $request->office,
            $request->current_year
        ];
        $console = Process::run($command);

        $report = new Report([
            'generated_by' => $auth->id,
            'name' => 'csm_report',
            'file_name' => $file_name . ".xlsx",
            'file_path' => "C:\Users\ray\Documents\Test"
        ]);
        $report->save();

        if ($console->successful()) {
            return response()->json($console->output());
        } else {
            return response()->json($console->errorOutput());
        }
    }
}
