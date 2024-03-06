<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\JsonResponse;

class PositionController extends Controller
{
    public function index(): JsonResponse
    {
        $positions = Position::all();

        return response()->json(['positions' => $positions]);
    }
}
