<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\LoanSubmissionRequestEvent;
use App\Models\CreditCheckerVerification;
use App\Models\Customer;
use App\Notifications\LoanRequestEmailNotification;
use App\Notifications\PendingCreditCheckNotification;
use App\Services\MessageService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class LoanSubmissionRequestListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(LoanSubmissionRequestEvent $event)
    {
        // $customer = $event->customer;
        // $creditCheck = $event->creditCheckerVerification;
        $this->sendCreditCheckMailToAdmin($event->customer,  $event->product,  $event->creditCheckerVerification);
        $this->sendLoanRequestEmailToCustomer($event->customer,  $event->product,  $event->creditCheckerVerification);
        $this->sendLoanRequestMessageToCustomer($event->creditCheckerVerification, $event->customer);
    }

    private function sendCreditCheckMailToAdmin($customer, $product, $creditCheckerVerification)
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
    private function sendLoanRequestEmailToCustomer($customer, $product, $creditCheckerVerification)
    {
        try {
            $isInProduction = App::environment() === 'production';
            $customerEmail =  config('app.credit_checker_mail');
            //check if there is an authenticated user and app is not in production
            //if there is an authenticated user and is not in production
            // the authenticated user email receives the mail
            if (Auth::check() && !$isInProduction) {
                $customerEmail = auth()->user()->email ?  auth()->user()->email : null;
            }

            Log::info("Mail about to be sent to customer if customer has a mail");
            if ($customerEmail) {
                Notification::route('mail', $customerEmail)->notify(new LoanRequestEmailNotification($customer, $product, $creditCheckerVerification));
                Log::info("Mail is sent to Customer");
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    private function sendLoanRequestMessageToCustomer(CreditCheckerVerification $creditCheckerVerification, Customer $customer)
    {
        try {
            $isInProduction = App::environment() === 'production';
            $customerPhoneNumber =  $customer->telephone;
            //check if there is an authenticated user and app is not in production
            //if there is an authenticated user and is not in production
            // the authenticated user email receives the mail
            if (Auth::check() && !$isInProduction) {
                $customerPhoneNumber = auth()->user()->telephone ?  auth()->user()->telephone : null;
            }

            Log::info("Mail about to be sent to customer if customer has a mail");
            if ($customerPhoneNumber) {
                $messageService = new MessageService();
                $message = "Hello {$customer->first_name}, Thank you for your loan request. We are processing your application with id {$creditCheckerVerification->credit_check_no} and will notify you shortly.";
                $messageService->sendMessage($customerPhoneNumber, $message);
            }
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

}
