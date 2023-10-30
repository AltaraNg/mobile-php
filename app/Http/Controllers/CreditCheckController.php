<?php

namespace App\Http\Controllers;

use App\Models\CreditCheckerVerification;
use Illuminate\Http\Request;

class CreditCheckController extends Controller
{
    public function show(Request $request, CreditCheckerVerification $creditCheckerVerification)
    {
        if ($request->user()->id != $creditCheckerVerification->customer_id) {
            return $this->sendError('Invalid credit check verification id', 404, [], 404);
        }
        
        $creditCheckerVerification =  $creditCheckerVerification->load(['product', 'customer', 'repaymentDuration', 'repaymentCycle', 'downPaymentRate', 'businessType', 'documents']);
        return $this->sendSuccess(['creditCheckerVerification' => $creditCheckerVerification], 'Credit check verification retrieved');
    }
}
