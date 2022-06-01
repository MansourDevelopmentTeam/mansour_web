<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logs\RequestLog;
use Illuminate\Http\Request;

class RequestLogController extends Controller
{
    public function index()
    {
        $logs = RequestLog::latest()->paginate();
        $data = [
            'total' => $logs->total(),
            'logs' => $logs->items(),
        ];
        return $this->jsonResponse("Success", $data);
    }
}
