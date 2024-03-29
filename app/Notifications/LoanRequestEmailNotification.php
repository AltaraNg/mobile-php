<?php

namespace App\Notifications;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Bus\Queueable;
use App\Models\CreditCheckerVerification;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class LoanRequestEmailNotification extends Notification
{
    use Queueable;

    public Customer $customer;
    public Product $product;
    public CreditCheckerVerification $creditCheckVerification;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, Product $product, CreditCheckerVerification $creditCheckerVerification)
    {
        $this->customer = $customer;
        $this->product = $product;
        $this->creditCheckVerification = $creditCheckerVerification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->view('emails.customer-loan-request', [
            
            'customer_id' => $this->customer->id,
            'application_id' => $this->creditCheckVerification->credit_check_no,
            'customer_name' => $this->customer->first_name . ' ' . $this->customer->last_name,
            'request_date' => $this->creditCheckVerification->created_at->format('Y-m-d'),
            'product_price' => $this->product->retail_price,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
