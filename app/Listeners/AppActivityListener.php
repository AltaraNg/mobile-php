<?php

namespace App\Listeners;

use App\Events\AppActivityEvent;
use App\Models\CustomerMobileAppAudit;
use App\Models\MobileAppActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class AppActivityListener
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
     * @param  MobileAppActivity  $event
     * @return void
     */
    public function handle(AppActivityEvent $appActivityEvent)
    {
        try {
            CustomerMobileAppAudit::query()->create([
                'mobile_app_activity_id' => $appActivityEvent->mobileAppActivity->id,
                'customer_id' => $appActivityEvent->customer->id,
                'meta' => $appActivityEvent->meta,
            ]);
        } catch (\Throwable $th) {
            Log::error($th);
            //throw $th;
        }
    }
}
