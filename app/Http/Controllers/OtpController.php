<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendOtpRequest;
use App\Services\MessageService;
use App\Services\OtpService;

class OtpController extends Controller
{


    public function __construct(private MessageService $messageService, private OtpService $otpService)
    {

    }

    public function sendOtp(SendOtpRequest $request)
    {
        $otp = $this->otpService->generate($request->phone_number);
        dd($otp);
//        dd($res);
    }
}
