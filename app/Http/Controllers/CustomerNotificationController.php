<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerNotificationController extends Controller
{
    public function show(Customer $customer)
    {
        $notifications = DB::table('notifications')->where('notifiable_type', 'App\Customer')->where('notifiable_id', $customer->id)->latest()->paginate(15);
        return $this->sendSuccess(['notifications' => $notifications], 'User notifications retrieved');
    }
}
