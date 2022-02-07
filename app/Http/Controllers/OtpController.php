<?php

namespace App\Http\Controllers;

use App\Helper\HttpResponseCodes;
use App\Http\Requests\SendOtpRequest;
use App\Services\MessageService;
use App\Services\OtpService;

class OtpController extends Controller
{


    public function __construct(private MessageService $messageService, private OtpService $otpService)
    {
    }
 // ddd($messageStatus->groupName);
    public function sendOtp(SendOtpRequest $request)
    {
        $otp = $this->otpService->generate($request->phone_number);
        if (!$otp->status) {
            return $this->sendError($otp->message, HttpResponseCodes::REQUEST_NOT_PERMITTED);
        }
        $message = $otp->otp . " is your Altara app login code and it expires in " . $otp->expires_in;
        $response = $this->messageService->sendMessage($request->phone_number, $message);
        $messageStatus = $response->messages[0]->status;
        if ($messageStatus->groupName != 'Success') {
            return $this->sendError($messageStatus->description, HttpResponseCodes::ACTION_FAILED);
        }
        return $this->sendSuccess([], 'Otp has been successfully sent'.$messageStatus->groupName);
    }
}
