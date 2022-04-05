<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Customer;
use App\Services\OtpService;
use App\Services\MessageService;
use App\Helper\HttpResponseCodes;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\StoreCustomerRequest;
use App\Repositories\Eloquent\Repository\CustomerRepository;

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 */
class AuthenticationController extends Controller
{

    private $otpService;
    private $customerRepository;
    private $messageService;
    public function __construct(OtpService $otpService, CustomerRepository $customerRepository, MessageService $messageService)
    {
        $this->otpService = $otpService;
        $this->customerRepository = $customerRepository;
        $this->messageService = $messageService;
    }

    /**
     * Login
     *
     * Log customer in using the provided phone number and otp
     *
     */
    public function login(LoginRequest $request)
    {
        $customer = Customer::firstOrCreate(
            ['telephone' => $request->phone_number],
            $this->setNotNullableFields()
        );
        // if (!$customer) {
        //     return $this->sendError('Supplied phone is invalid', HttpResponseCodes::ACTION_FAILED);
        // }
        $otp = $this->otpService->validate($request->phone_number, $request->otp);
        if (!$otp->status) {
            return $this->sendError($otp->message, HttpResponseCodes::OTP_NOT_EXPIRED);
        }
        $token = $customer->createToken($request->device_name)->plainTextToken;
        $data = [
            'token' => $token,
            'user' => new CustomerResource($customer),
        ];
        return $this->sendSuccess($data, 'Logged in successfully');
    }


    // public function signup(StoreCustomerRequest $request)
    // {

    //     $otp = $this->otpService->generate($request->telephone);
    //     if (!$otp->status) {
    //         return $this->sendError($otp->message, HttpResponseCodes::OTP_NOT_EXPIRED);
    //     }
    //     $message = $otp->otp . " is your Altara app login code and it expires in " . $otp->expires_in;
    //     $response = $this->messageService->sendMessage($request->telephone, $message);
    //     $messageStatus = $response->messages[0]->status;
    //     if ($messageStatus->groupName != 'Success') {
    //         return $this->sendError($messageStatus->description, HttpResponseCodes::ACTION_FAILED);
    //     }
    //     $data = $request->validated();
    //     $data = array_merge(
    //         $data,
    //         $this->setNotNullableFields(),
    //     );
    //     $customer =  $this->customerRepository->create($data);
    //     return $this->sendSuccess(['customer' => new CustomerResource($customer)], 'Profile created and token has been sent to supplied phone number');
    // }

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
    private function setNotNullableFields()
    {
        return [
            'first_name' => 'N/A',
            'last_name' => 'N/A',
            'on_boarded' => false,
            'add_street' => 'N/A',
            'employee_name' => 'mobile',
            'user_id' => 1, 'employee_id' => 1,
            'date_of_registration' => Carbon::now(),
            'add_nbstop' => 'N/A',
            'area_address' => 'N/A',
            'add_houseno' => 'N/A',
            'city' => 'N/A', 
            'state' => 'N/A', 
            'gender' => 'N/A',
            'date_of_birth' => 'N/A',
            'civil_status' => 'N/A',
            'type_of_home' => 'N/A',
            'no_of_rooms' => 'N/A',
            'duration_of_residence' => 0,
            'people_in_household' => 0,
            'number_of_work' => 0,
            'depend_on_you' => 0,
            'level_of_education' => 'N/A',
            'visit_hour_from' => 'N/A',
            'visit_hour_to' => 'N/A',
            'employment_status' => 'N/A',
            'name_of_company_or_business' => 'N/A',
            'cadd_nbstop' => 'N/A',
            'company_city' => 'N/A',
            'company_state' => 'N/A',
            'company_telno' => 'N/A',
            'days_of_work' => 'N/A',
            'comp_street_name' => 'N/A',
            'comp_house_no' => 'N/A',
            'comp_area' => 'N/A',
            'current_sal_or_business_income' => 'N/A',
            'cvisit_hour_from' => 'N/A',
            'cvisit_hour_to' => 'N/A',
            'nextofkin_first_name' => 'N/A',
            'nextofkin_middle_name'  => 'N/A',
            'nextofkin_last_name' => 'N/A',
            'nextofkin_telno' => 'N/A'
        ];
    }
}
