<?php

namespace App\Http\Controllers\Admin;
use App\Events\SendBroadCastMessageEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    public function dashboard()
    {
        return view('pages.dashboard');
    }

    public function createMessage()
    {
        return view('pages.send-message');
    }
    public function sendMessage(Request $request)
    {
        $data = [
            'subject' => $request->subject,
            'message' => $request->message
        ];
        SendBroadCastMessageEvent::dispatch($data);
        return back()->with('success', 'Message dispatched successfully!');
    }
}
