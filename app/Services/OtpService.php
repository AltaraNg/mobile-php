<?php

namespace App\Services;

use App\Contracts\OtpInterface;
use App\Models\Otp as OtpModel;
use Carbon\Carbon;

class OtpService implements OtpInterface
{
    private bool $onlyDigits;
    private int $validity;
    private int $deleteOldOtps;

    public function __construct()
    {
        $this->onlyDigits = false;
        $this->validity = 1440; // 24 hrs converted to minutes
        $this->deleteOldOtps = 1440;
    }

    public function generate(string $identifier): object
    {
        $this->deleteOldOtps();
        $otp = OtpModel::where('identifier', $identifier)->first();
        if ($otp == null) {
            $otp = OtpModel::create([
                'identifier' => $identifier,
                'otp' => $this->createPin(),
                'validity' => $this->validity,
                'generated_at' => Carbon::now(),
            ]);
        } else {
            $otp->update([
                'identifier' => $identifier,
                'token' => $this->createPin(),
                'validity' => $this->validity,
                'generated_at' => Carbon::now(),
            ]);
        }
        return (object)[
            'status' => true,
            'otp' => $otp->token,
            'message' => "OTP generated",
        ];
    }

    public function validate(string $identifier, string $token): object
    {
        $otp = OtpModel::where('identifier', $identifier)->first();

        if (!$otp) {
            return (object)[
                'status' => false,
                'message' => 'OTP does not exists, Please generate new OTP',
            ];
        }

        if ($otp->isExpired()) {
            return (object)[
                'status' => false,
                'message' => 'OTP is expired',
            ];
        }

        if ($otp->token == $token) {
            return (object)[
                'status' => true,
                'message' => 'OTP is valid',
            ];
        }
        return (object)[
            'status' => false,
            'message' => 'OTP does not match',
        ];
    }

    public function createPin(): string
    {
        if ($this->onlyDigits) {
            $characters = '0123456789';
        } else {
            $characters = '123456789abcdefghijklmnopqrstuvwzyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }
        $length = strlen($characters);
        $pin = '';
        for ($i = 0; $i < $this->length; $i++) {
            $pin .= $characters[rand(0, $length - 1)];
        }

        return $pin;
    }

    public function deleteOldOtps(): bool
    {
        return OtpModel::where('expired', true)
            ->orWhere('created_at', '<', Carbon::now()->subMinutes($this->deleteOldOtps))
            ->delete();
    }
}
