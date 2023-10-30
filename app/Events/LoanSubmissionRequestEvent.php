<?php

namespace App\Events;

use App\Models\CreditCheckerVerification;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoanSubmissionRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public  Customer $customer;
    public  CreditCheckerVerification $creditCheckerVerification;
    public Product $product;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Customer $customer, Product $product,CreditCheckerVerification $creditCheckerVerification)
    {
        $this->customer = $customer;
        $this->creditCheckerVerification = $creditCheckerVerification;
        $this->product = $product;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
