<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerMobileAppAudit;
use App\Repositories\Eloquent\Repository\CustomerMobileAppAuditRepository;
use Illuminate\Http\Request;

class CustomerMobileAppAuditController extends Controller
{
    private CustomerMobileAppAuditRepository $customerMobileAppAuditRepository;
    public function __construct(CustomerMobileAppAuditRepository $customerMobileAppAuditRepository) {
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
}
