<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * @group Notifications
 *
 * Api Endpoints for Customer Notifications
 *
 */
class CustomerNotificationController extends Controller
{
    
     /**
     * All Notifications
     *
     * This endpoint is used for getting all customer notifications.
     * 
     * @param Customer $customer
     * 
     */
    public function show(Customer $customer)
    {
        $notifications = DB::table('notifications')->where('notifiable_type', 'App\Customer')->where('notifiable_id', $customer->id)->latest()->paginate(15);
        return $this->sendSuccess(['notifications' => $notifications], 'User notifications retrieved');
    }
}
