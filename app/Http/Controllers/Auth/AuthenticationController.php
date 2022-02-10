<?php

namespace App\Http\Controllers\Auth;

use App\Helper\HttpResponseCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Services\OtpService;
use Illuminate\Http\Request;

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 */
class AuthenticationController extends Controller
{

    public function __construct(private OtpService $otpService)
    {
    }

    /**
     * Login
     * 
     * Log customer in using the provided phone number and otp
     * 
     */
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
        $token = $customer->createToken($request->device_name)->plainTextToken;
        $data = [
            'token' => $token,
            'user' => new CustomerResource($customer),
        ];
        return $this->sendSuccess($data, 'Logged in successfully');
    }



    /**
     * Logout 
     * 
     * Log customer out of the app
     * 
     * @authenticated
     * 
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->sendSuccess([], 'Successfully logged out');
    }


    /**
     * 
     * Authenticated Customer
     * 
     * Get authenticated user profile
     * 
     * @authenticated
     * 
     */
    public function user()
    {
        return $this->sendSuccess([new CustomerResource(auth()->user())], 'Customer profile fetched');
    }
}
