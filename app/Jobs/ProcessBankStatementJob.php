<?php

namespace App\Jobs;

use App\Models\CreditCheckerVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessBankStatementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public CreditCheckerVerification $creditCheckerVerification;
    public int $bank_statement_choice;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CreditCheckerVerification $creditCheckerVerification, int $bank_statement_choice)
    {
        $this->creditCheckerVerification = $creditCheckerVerification;
        $this->bank_statement_choice = $bank_statement_choice;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $bank_statement = $this->creditCheckerVerification->documents()->where('document_type', 'bank_statement')->first();
        
        Log::info("Bank statement pricessing started");
        if (!$bank_statement || !$this->bank_statement_choice) {
            Log::info("Bank statement processing altered");
            return;
        }
        Log::info("I got here");
        $bank_statement_file_url = env('AWS_URL') . "/" . $bank_statement->document_url;
        $data = [
            'bank_statement_choice' => $this->bank_statement_choice,
            'bank_statement_pdf_url' => $bank_statement_file_url,
            'customer_id' => $this->creditCheckerVerification->customer_id
        ];
        Log::info($data);
        $response =  Http::asMultipart()->post(
            config('app.bank_statement_url') . '/bank-statements', $data);
        Log::info($response);
        Log::info("Bank statement processing completed");
    }
}
