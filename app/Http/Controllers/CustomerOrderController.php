<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Repositories\Eloquent\Repository\CustomerRepository;
use App\Services\GoogleSheetService;
use Carbon\Carbon;
use Illuminate\Support\Arr;

/**
 * @group Customer Order
 *
 * Api Endpoints for Customer orders
 *
 */
class CustomerOrderController extends Controller
{
    private $customerRepository;
    private $googleSheetService;

    public function __construct(CustomerRepository $customerRepository, GoogleSheetService $googleSheetService)
    {
        $this->customerRepository = $customerRepository;
        $this->googleSheetService = $googleSheetService;
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


    public function submitRequest(string $documentId)
    {
        $customer = auth()->user();
        $input = [
            'customer_id' => $customer->id,
            'name' => $customer->first_name . ' ' . $customer->last_name,
            'phone_number' => $customer->telephone,
            'order_type' => $request->order_t
            'request_date' => Carbon::now()->format('Y-m-d')
        ];
        $data = [
            array_values($input)
        ];
        dd($data);
        $this->googleSheetService->appendSheet($data, $documentId);
    }
}
