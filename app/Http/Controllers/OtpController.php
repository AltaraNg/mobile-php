<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendOtpRequest;
use App\Services\MessageService;

class OtpController extends Controller
{
    public function sendOtp(SendOtpRequest $request, MessageService $messageService)
    {
        $res = $messageService->sendMessage('07086556010', 'hello');
        dd($res);
    }
}
