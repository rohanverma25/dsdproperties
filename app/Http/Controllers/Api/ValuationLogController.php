<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ValuationLog;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ValuationLogController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
        ]);

        $log = ValuationLog::create([
            'whatsapp_no' => $request->input('phone'),
            'form_data'   => $request->except('phone'),
        ]);

        return response()->json([
            'success' => true,
            'id'      => $log->id,
        ], 201);
    }
}