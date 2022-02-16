<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Repositories\Eloquent\Repository\CustomerRepository;

/**
 * @group Customer Order
 *
 * Api Endpoints for Customer orders
 *
 */
class CustomerOrderController extends Controller
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * All Customer Orders
     *
     * This endpoint is used for fetching customer orders
     *
     */
    public function show(Customer $customer)
    {
        $customer = $customer->load('orders');
        return $this->sendSuccess([new CustomerResource($customer)], 'Customer orders successfully fetched');
    }
}
