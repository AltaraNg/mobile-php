<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Guarantor;
use App\Models\NewDocument;
use Illuminate\Support\Str;
use App\Models\OrderRequest;
use App\Http\Requests\LoanRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Dtos\GuarantorDto;
use App\Events\AppActivityEvent;
use App\Events\LoanSubmissionRequestEvent;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\CustomerResource;
use App\Models\BusinessType;
use App\Models\CreditCheckerVerification;
use App\Models\DownPaymentRate;
use App\Models\MobileAppActivity;
use App\Models\Product;
use App\Models\RepaymentDuration;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PendingCreditCheckNotification;
use App\Repositories\Eloquent\Repository\CustomerRepository;
use Illuminate\Support\Facades\DB;

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
        $customer = $customer->load(
            [
                'orders', 'orders.amortizations',
                'orders.product', 'orders.businessType',
                'orders.downPaymentRate',  'orders.orderType',
                'orders.repaymentDuration',  'orders.salesCategory',
                'orders.repaymentCycle', 'verification', 'orders.lateFee',
                'orders.orderStatus'
            ]
        );
        return $this->sendSuccess([new CustomerResource($customer)], 'Customer orders successfully fetched');
    }


    public function submitLoanRequest(LoanRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = $request->user();
            $customer = $this->customerRepository->findById($user->id);
            // dd($customer);
            $guarantors  = GuarantorDto::fromOrderApiRequest($request, $user->id);


            foreach ($guarantors as $key => $guarantor) {
                $guarantorDto  = GuarantorDto::fromSelf($guarantor);
                Guarantor::query()->updateOrCreate(
                    [
                        'customer_id' => $guarantorDto->customer_id,
                        'phone_number' => $guarantorDto->phone_number
                    ],
                    [
                        'first_name' => $guarantorDto->first_name,
                        'last_name' => $guarantorDto->last_name,
                        'home_address' => $guarantorDto->home_address,
                    ]
                );
            }
            $downpaymentRate = DownPaymentRate::query()->where('percent', 20)->first();
            $repaymentDuration = RepaymentDuration::query()->where('name', 'six_months')->first();
            $businessType = BusinessType::query()->where('slug', 'ap_starter_cash_loan-no_collateral')->first();
            $product = Product::query()->firstOrCreate(
                ['retail_price' => $request->input('loan_amount')],
                [
                    'brand_id' => 1, 'category_id' => 4,
                    'product_type_id' => 4, 'user_id' => 442,
                    'name' => "Cash Loan " . $request->input('loan_amount'),
                    'feature' => 'N/A'
                ]

            );


            if ($customer->creditCheckerVerifications()->where('status', CreditCheckerVerification::PENDING)->exists()) {
                $creditCheckerVerification = $customer->latestCreditCheckerVerifications()->where('status', CreditCheckerVerification::PENDING)->first();
            } else {
                $customer_id  = request()->user()->id;
                $creditCheckerVerification = CreditCheckerVerification::create([
                    'customer_id' =>  request()->user()->id,
                    'initiated_by' => 1,
                    'repayment_duration_id' => $repaymentDuration->id,
                    'repayment_cycle_id' => $request->input('repayment_cycle_id'),
                    'down_payment_rate_id' => $downpaymentRate->id,
                    'business_type_id' => $businessType->id,
                    'product_id' => $product->id
                ]);

                $creditCheckerVerification->credit_check_no = $this->generateCreditCheckNumber($creditCheckerVerification->id, $customer_id);
                $creditCheckerVerification->update();
                if ($request->has('documents')) {
                    $documents = $request->documents;
                    $customerDocuments = [];
                    foreach ($documents as $key => $document) {
                        $customerDocuments[] =  $this->moldDocument($document['name'], $document['url']);
                    }
                    $creditCheckerVerification->documents()->saveMany($customerDocuments);
                }
            }
            // $this->sendCreditCheckMailToAdmin($customer, $product, $creditCheckerVerification);
            event(new LoanSubmissionRequestEvent($customer, $product, $creditCheckerVerification));

            event(new AppActivityEvent(
                MobileAppActivity::query()->where('slug', 'loan_request')->first(), 
                $customer, 
                ['credit_check' => $creditCheckerVerification->load(['product', 'repaymentDuration', 'repaymentCycle', 'downPaymentRate', 'businessType', 'documents'])])
            );
            DB::commit();
            return $this->sendSuccess(['credit_check_verification' =>  $creditCheckerVerification], 'Credit check initiated and notification sent');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return $this->sendError('An error ocurred while try to initiate credit check', 500, [], 500);
        }
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

    public function moldDocument($documentName, $documentUrl)
    {
        $document = new NewDocument();
        $document->document_url = $documentUrl;

        $document->user_id = 1;
        $document->name = $documentName;
        $document->document_type = Str::slug($documentName, '_');

        return $document;
    }

    public function generateCreditCheckNumber($creditCheckerVerificationId, $vendorId)
    {
        return 'CR/' . $creditCheckerVerificationId . '/' . $vendorId;
    }
    public function sendCreditCheckMailToAdmin($customer, $product, $creditCheckerVerification)
    {
        try {
            $isInProduction = App::environment() === 'production';
            $creditCheckerMail =  config('app.credit_checker_mail');
            //check if there is an authenticated user and app is not in production
            //if there is an authenticated user and is not in production
            // the authenticated user email receives the mail
            if (Auth::check() && !$isInProduction) {
                $creditCheckerMail = auth()->user()->email ?  auth()->user()->email : $creditCheckerMail;
            }
            Log::info("Mail about to be sent to Credit checker");
            Notification::route('mail', $creditCheckerMail)->notify(new PendingCreditCheckNotification($customer, $product, $creditCheckerVerification));
            Log::info("Mail is sent to Credit checker");
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}
