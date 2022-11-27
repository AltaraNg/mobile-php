<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Models\OrderRequest;
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
        $customer = $customer->load('orders', 'orders.amortizations', 'orders.product', 'orders.businessType',  'orders.downPaymentRate',  'orders.orderType',  'orders.repaymentDuration',  'orders.salesCategory',  'orders.repaymentCycle', 'verification', 'orders.lateFee');
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
        $input = array(
            'Customer_Id' => (string) $customer->id,
            'Name' => $customer->first_name . ' ' . $customer->last_name,
            'Phone_Number' => $customer->telephone,
            'Order_Type' => $request->order_type,
            'Branch' => $request->branch,
            'Owner' => $request->staff_name,
            'Request_Date' => Carbon::now()->format('Y-m-d')
        );
        try {
            $length = json_encode($input);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => env('GOOGLE_SHEET_URL'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>  $input,
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: multipart/form-data',
                    // 'Content-Length: 1024',
                ),
            ));
            curl_exec($curl);
            $info = curl_getinfo($curl);
            curl_close($curl);
        } catch (\Throwable $th) {
            Log::error($th);
            throw new Exception("An error occurred while processing your request, kindly visit any of our offices.", 500);
        }

        if ($info["http_code"] == 411 || 200) {
            $orderRequest = OrderRequest::create([
                'customer_id' => $customer->id,
                'order_type' => $request->order_type,
                'branch' => $request->branch,
                'staff_name' => $request->staff_name,
                'request_date' => now(),
                'status' => OrderRequest::STATUS_PENDING
            ]);
            return $this->sendSuccess(['order_request' => $orderRequest], 'Order request has successfully been submitted');
        }
        return $this->sendError('Unable to submit order request, kindly contact admin', 500);
    }
}
