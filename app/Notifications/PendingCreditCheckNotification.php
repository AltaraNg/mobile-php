<?php

namespace App\Notifications;

use App\Models\BnplVendorProduct;
use App\Models\CreditCheckerVerification;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendingCreditCheckNotification extends Notification
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
        return (new MailMessage)->view('emails.pending-credit-check', [
            
            'customer_id' => $this->customer->id,
            'customer_phone_number' => $this->customer->telephone,
            'customer_name' => $this->customer->first_name . ' ' . $this->customer->last_name,
            'product_name' => $this->product->name,
            'product_price' => $this->product->retail_price,
            'url' => config('app.frontend_url') . "/credit-check/all?page=1&status=pending&searchTerm={$this->creditCheckVerification->id}"
        ]);
        // url('pending/credit/check/{id}', ['id' => $this->creditCheckVerification->id])
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
