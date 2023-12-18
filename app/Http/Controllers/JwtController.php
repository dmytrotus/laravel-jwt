<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class JwtController extends Controller
{
    public function secretApiData(): JsonResponse
    {
        return response()->json([
            'data' => 'some secret data'
        ], 200);
    }
}
