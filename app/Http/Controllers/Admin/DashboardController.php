<?php

namespace App\Http\Controllers\Admin;

use App\Events\SendBroadCastMessageEvent;
use App\Http\Controllers\Controller;
use App\Models\Broadcast;
use App\Repositories\Eloquent\Repository\BroadcastRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    private $broadcastRepository;
    public function __construct(BroadcastRepository $broadcastRepository)
    {
        $this->broadcastRepository = $broadcastRepository;
    }

    public function dashboard()
    {
        $broadcasts = $this->broadcastRepository->all();
        return view('pages.dashboard', compact('broadcasts'));
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
        $this->broadcastRepository->create([
            'subject' => $data['subject'],
            'messages' => $data['message'],
            'resent' => 0,
            'creator_id' => auth()->id()
        ]);
        SendBroadCastMessageEvent::dispatch($data);
        return back()->with('success', 'Message dispatched successfully!');
    }
    public function resendMessage(Request $request, Broadcast $broadcast)
    {
        $data = [
            'subject' => $broadcast->subject,
            'message' => $broadcast->messages
        ];
        $broadcast->increment('resent');
        SendBroadCastMessageEvent::dispatch($data);
        return back()->with('success', 'Message dispatched successfully!');
    }
}
