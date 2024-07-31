<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Visit;

use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'qr_code' => 'required',
            'plate_no' => 'required',
            'email' => 'nullable|email',
            'phone_no' => 'nullable',
            'entry_guard_id' => 'required|exists:users,id',
            'entry_gate_id' => 'required|exists:gates,id',
        ]);

        try {
            $visit = Visit::create($request->all());

            return response()->json($visit, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getVisitByQrCode(Request $request)
    {
        $visit = Visit::where('qr_code', $request->qr_code)->first();
        if ($visit) {
            $visit->append('is_paid');
            $visit->makeHidden(['transactions']);
            return response()->json($visit, 200);
        } else {
            return response()->json([
                'message' => 'Visit not found',
            ], 404);
        }
    }

    public function end(int $id, Request $request)
    {
        $request->validate([
            'exit_guard_id' => 'required|exists:users,id',
            'exit_gate_id' => 'required|exists:gates,id',
        ]);

        $visit = Visit::find($id);
        if ($visit) {
            $visit->exit_gate_id = $request->exit_gate_id;
            $visit->exit_guard_id = $request->exit_guard_id;
            $visit->exit_time = now();
            $visit->save();
            return response()->json($visit, 200);
        } else {
            return response()->json([
                'message' => 'Visit not found',
            ], 404);
        }
    }
}
