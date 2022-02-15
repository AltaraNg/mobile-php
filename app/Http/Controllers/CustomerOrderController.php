<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Repositories\Eloquent\Repository\CustomerRepository;

class CustomerOrderController extends Controller
{
    private $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function show(Customer $customer)
    {
        $customer = $customer->load('orders');
        return $this->sendSuccess([new CustomerResource($customer)], 'Customer orders successfully fetched');
    }
}
