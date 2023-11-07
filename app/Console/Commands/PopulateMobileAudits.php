<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use App\Models\MobileAppActivity;

class PopulateMobileAudits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'populate:audit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $auditTypes = [
            ["name" => "Loan Request", "is_admin" => false],
            ["name" => "Send Verification", "is_admin" => true],
            ["name" => "Make Downpayment", "is_admin" => false],
            ["name" => "Edit Profile", "is_admin" => true],
            ["name" => "Upload Documents", "is_admin" => true],
            ["name" => "View Loan Details", "is_admin" => true],
        ];

        foreach ($auditTypes as $key => $value) {
            MobileAppActivity::query()->updateOrCreate(
                [
                    'slug' => Str::slug($value['name'], '_'),
                ],
                [
                    'name' => $value['name'],
                    'is_admin' => $value['is_admin'],
                ]
                
                
            );
        }
    }
}
