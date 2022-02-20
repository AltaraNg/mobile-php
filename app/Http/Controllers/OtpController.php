<?php

namespace App\Http\Controllers;

use App\Helper\HttpResponseCodes;
use App\Http\Requests\SendOtpRequest;
use App\Services\MessageService;
use App\Services\OtpService;

/**
 * @group Otp
 *
 * Api Endpoints for sending otp
 *
 */
class OtpController extends Controller
{


    private $messageService;
    private $otpService;

    public function __construct(MessageService $messageService, OtpService $otpService)
    {
        $this->otpService = $otpService;
        $this->messageService = $messageService;
    }

    /**
     * Send Otp
     *
     * Send otp to the provided email address.
     *
     */
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
        return $this->sendSuccess([], 'Otp has been successfully sent' . $messageStatus->groupName);
    }
}
