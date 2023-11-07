<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerMobileAppAudit;
use App\Repositories\Eloquent\Repository\CustomerMobileAppAuditRepository;
use Illuminate\Http\Request;

class CustomerMobileAppAuditController extends Controller
{
    private CustomerMobileAppAuditRepository $customerMobileAppAuditRepository;
    public function __construct(CustomerMobileAppAuditRepository $customerMobileAppAuditRepository)
    {
        $this->customerMobileAppAuditRepository = $customerMobileAppAuditRepository;
    }

    public function store(StoreCustomerMobileAppAudit $request)
    {
        $data = $request->validated() + [
            'customer_id' => auth()->user()->id,
        ];
        $this->customerMobileAppAuditRepository->create($data);
        return $this->sendSuccess([], "Audited successfully");
    }


    public function recentActivity(Request $request)
    {
        $activities =  $this->customerMobileAppAuditRepository->query()->where('customer_id', auth()->id())
        ->whereHas('mobileAppActivity', function ($query) {
             $query->where('is_admin', false);
         })
        ->with(['mobileAppActivity' => function ($query) {
           return $query->where('is_admin', false);
        }])->latest()->limit(10)->get();

        return $this->sendSuccess(['activities' => $activities], "Recent activities retrieved successfully");
    }
}
