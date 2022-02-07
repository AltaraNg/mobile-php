<?php

namespace App\Http\Controllers\Auth;

use App\Helper\HttpResponseCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Customer;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{

    public function __construct(private OtpService $otpService)
    {
    }

    public function login(LoginRequest $request)
    {
        $customer = Customer::where('telephone', $request->phone_number)->first();
        if (!$customer) {
            return $this->sendError('Supplied phone is invalid', HttpResponseCodes::ACTION_FAILED);
         }
         $otp = $this->otpService->validate($request->phone_number, $request->otp);
         if (!$otp->status) {
            return $this->sendError($otp->message, HttpResponseCodes::ACTION_FAILED);
         }
        $res = $customer->createToken($request->device_name)->plainTextToken;
        dd($res);
    }



    /**
     * Log user out of the app
     */

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return $this->sendSuccess(['Successfully logged out'], HttpResponseCodes::ACTION_SUCCESSFUL);
    }
}
