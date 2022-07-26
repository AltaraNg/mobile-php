<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\Customer;
use App\Services\OtpService;
use Illuminate\Http\Request;
use App\Services\MessageService;
use App\Helper\HttpResponseCodes;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CustomerResource;

use App\Http\Requests\LoginWithOtpRequest;
use App\Http\Requests\LoginWithPasswordRequest;
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


    public function login(LoginRequest $request)
    {
        $customer = $this->getFirstCustomerOrCreate($request->phone_number);
        $validatedData = (object) $request->validated();
        if ($request->login_type == 'otp') {
            return  $this->loginWithOtp($validatedData, $customer);
        }
        if ($request->login_type == 'password') {
            return $this->loginWithPassword($validatedData, $customer);
        }
    }

    /**
     * Login With Otp
     *
     * Log customer in using the provided phone number and otp
     *
     */
    private function loginWithOtp($requestData, $customer)
    {

        $otp = $this->otpService->validate($requestData->phone_number, $requestData->otp);
        if (!$otp->status) {
            return $this->sendError($otp->message, HttpResponseCodes::OTP_NOT_EXPIRED);
        }
        return $this->sendToken($customer, $requestData->device_name);
    }

    /**
     * Login With Password
     *
     * Log customer in using the provided phone number and password
     *
     */
    private function loginWithPassword($requestData, $customer)
    {
        if ($customer->password == null || !$customer->password) {
            $customer->password = Hash::make($requestData->password);
            $customer->save();
        }
        if (Hash::check($requestData->password, $customer->password) != true) {
            return $this->sendError('Credential provided is invalid', HttpResponseCodes::BAD_REQUEST);
        }

        return $this->sendToken($customer, $requestData->device_name);
    }

    public function customerExist($phone_number)
    {
        $customerExists = Customer::where('telephone', $phone_number)->first();
        if (!$customerExists) {
            return $this->sendError('Customer not found', HttpResponseCodes::NOT_FOUND);
        }
        return $this->sendSuccess([], 'Customer found');
    }

    private function sendToken($customer, $device_name)
    {
        $token = $customer->createToken($device_name)->plainTextToken;
        $data = [
            'token' => $token,
            'user' => new CustomerResource($customer),
        ];
        return $this->sendSuccess($data, 'Logged in successfully');
    }

    private function getFirstCustomerOrCreate($phone_number)
    {
        return Customer::firstOrCreate(
            ['telephone' => $phone_number],
            $this->setNotNullableFields()
        );
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
        return $this->sendSuccess([new CustomerResource(auth()->user()->load('verification'))], 'Customer profile fetched');
    }
    private function setNotNullableFields()
    {
        return [
            'registration_channel' => 'mobile',
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
