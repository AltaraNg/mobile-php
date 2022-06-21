<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class OrderRequestController extends Controller
{
    public function index(Customer $customer)
    {
        return $this->sendSuccess([
            'order_requests' => $customer->order_requests
        ], "All order requests fetched successfully");
    }
}
