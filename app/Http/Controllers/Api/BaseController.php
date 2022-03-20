<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function sendResponse($data, $code = 200, $message = "Berhasil")
    {
        return response()->json([
            'message' => $message,
            'status' => $code,
            'data' => $data
        ], $code);
    }

    public function sendError($data, $code = 404, $message = "Gagal")
    {
        return response()->json([
            'message' => $message,
            'status' => $code,
            'data' => $data
        ], $code);
    }
}
