<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Repositories\Eloquent\Repository\CustomerRepository;
use App\Services\GoogleSheetService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * @group Customer Order
 * 
 * @authenticated
 *
 * Api Endpoints for Customer order
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


    /**
     * Apply for Orders
     *
     * This endpoint is used for applying for orders by customers
     *
     */
    public function submitRequest(StoreOrderRequest $request)
    {
        $customer = auth()->user();
        $input = [
            'Customer_Id' => $customer->id,
            'Name' => $customer->first_name . ' ' . $customer->last_name,
            'Phone_Number' => $customer->telephone,
            'Order_Type' => $request->order_type,
            'Request_Date' => Carbon::now()->format('Y-m-d')
        ];
        $data = [
            array_values($input)
        ];
        try {
            $response = Http::post(env('GOOGLE_SHEET_URL'), $data);
        } catch (\Throwable $th) {
            Log::error($th);
            throw new Exception("Unable to Process Request", 500);
        }
        if ($response->status() == 200) {
            return $this->sendSuccess([], 'Order request has successfully been submitted');
        }
        return $this->sendError('Unable to submit order request, kindly contact admin', 500);
    }
}
