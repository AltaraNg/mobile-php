<?php

namespace App\Http\Controllers;

use App\Helper\HttpResponseCodes;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Repositories\Eloquent\Repository\CustomerRepository;
use Illuminate\Http\Request;

/**
 * @group Otp
 *
 * Api Endpoints for Customer
 *
 */
class CustomerController extends Controller
{
    //
    private $customerRepository;
    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }
    /**
     * Update Profile
     *
     * This endpoint is used for updating the customer profiles.
     *
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $res = $this->customerRepository->update($customer->id, $request->validated());
        if (!$res) {
            return $this->sendError('Profile could not be updated, please try again later', HttpResponseCodes::ACTION_FAILED);
        }
        return $this->sendSuccess([new CustomerResource($customer->fresh()), 'Profile updated successfully']);
    }
}
