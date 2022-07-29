<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //

    public function update(Request $request, Notification $notification)
    {
        //
        $notification->read_at = Carbon::now()->toDateTimeString();
        $notification->save();
        return $this->sendSuccess([$notification, 'Notification updated successfully']);
    }
}
