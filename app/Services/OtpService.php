<?php

namespace App\Services;

use App\Contracts\OtpInterface;
use App\Helper\HttpResponseMessages;
use App\Models\Otp as OtpModel;
use Carbon\Carbon;

class OtpService implements OtpInterface
{


    private $length = 4;
    private $onlyDigits = true;
    private $validity = 1440;
    private $numberOfRetries = 6;
    private $deleteOldOtps = 1440;

    public function __construct(
        int  $length = 4,
        bool $onlyDigits = true,
        int  $validity = 1440,
        int  $numberOfRetries = 6,
        int  $deleteOldOtps = 1440
    )
    {
        $this->deleteOldOtps = $deleteOldOtps;
        $this->numberOfRetries = $numberOfRetries;
        $this->validity = $validity;
        $this->onlyDigits = $onlyDigits;
        $this->length = $length;
    }

    public function generate(string $identifier): object
    {
        $this->deleteOldOtps();
        $otp = OtpModel::where('identifier', $identifier)->first();
        if ($otp == null) {
            $otp = OtpModel::create([
                'identifier' => $identifier,
                'token' => $this->createPin(),
                'validity' => $this->validity,
                'generated_at' => Carbon::now(),
            ]);
        } else {
            if (!$otp->isExpired() && !request()->regenerate) {
                return (object)[
                    'status' => false,
                    'message' => 'Please check your message, you have an otp that expires in: ' . $otp->expiresIn(),
                ];
            }
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
            'expires_in' => $otp->expiresIn(),
        ];
    }

    public function validate(string $identifier, string $token): object
    {
        $otp = OtpModel::where('identifier', $identifier)->first();

        if (!$otp) {
            return (object)[
                'status' => false,
                'message' => HttpResponseMessages::OTP_NOT_FOUND,
            ];
        }

        if ($otp->isExpired()) {
            return (object)[
                'status' => false,
                'message' => HttpResponseMessages::OTP_TIME_OUT,
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

    private function createPin(): string
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
