<?php

namespace App\Services;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

/**
 *
 * @author Adeniyi
 */
class MessageService
{
    public function sendMessage(string $receiver, string $message)
    {
        $receiver = $this->appendPrefix($receiver);
        $isInProduction = App::environment() === 'production';
        if (!$isInProduction) {
            $num = rand(0, 1);
            if ($num > 0.5) {
                return json_decode(json_encode($this->success($receiver)));
            }
            return json_decode(json_encode($this->error($receiver)));
        }
        $data = Http::get(env('SMS_URL'), [
            'user' => env('SMS_USERNAME'),
            'password' => env('SMS_PASSWORD'),
            'sender' => env('SENDER'),
            'SMSText' => $message,
            'GSM' => $receiver,
            'type' => 'longSMS',
        ]);
        $response = (int)preg_replace('/[^0-9]/', '', $data);
        $res_message = match ($data) {
            -1 => 'Send_Error',
            -2 => 'Not_Enough Credits',
            -3 => 'Network_NotCovered',
            -5 => 'Invalid user or password',
            -6 => 'Missing destination address',
            -7 => 'Missing SMS Text',
            -8 => 'Missing sender name',
            -9 => 'Invalid phone number format',
            -10 => 'Missing Username',
            -13 => 'Invalid phone number',
            default => 'Successful, Message was sent',
        };

        if ($data > 0) {
            return json_decode(json_encode([
                'messages' => [
                    0 => [
                        "status" => [
                            "groupId" => 1,
                            "groupName" => "Success",
                            "id" => $response,
                            "name" => "PENDING_ENROUTE",
                            "description" => $res_message
                        ],
                        "to" => $receiver

                    ]
                ]
            ]));
        } else {
            return json_decode(json_encode([
                'messages' => [
                    0 => [
                        "status" => [
                            "groupId" => 1,
                            "groupName" => "Failed",
                            "id" => $response,
                            "name" => "PENDING_ENROUTE",
                            "description" => $res_message
                        ],
                        "to" => $receiver
                    ]
                ]
            ]));
        }
    }

    private function success($receiver): array
    {

        return [
            'messages' => [
                0 => [
                    "status" => [
                        "groupId" => 1,
                        "groupName" => "PENDING ",
                        "id" => 7,
                        "name" => "PENDING_ENROUTE",
                        "description" => "Message has been processed and sent to the next instance",
                        "received" => $receiver
                    ]
                ]
            ]
        ];
    }

    private function error($receiver): array
    {

        return [
            'messages' => [
                0 => [
                    "status" => [
                        "groupId" => 5,
                        "groupName" => "REJECTED",
                        "id" => 52,
                        "name" => "REJECTED_DESTINATION",
                        "description" => "Invalid destination address.",
                        "received" => $receiver
                    ]
                ]
            ]
        ];
    }

    private function appendPrefix(string $number): string
    {
        if (!$number) return '';
        $pre = '234';
        if ($number[0] == 0) {
            return $pre . substr($number, 1);
        } elseif (substr($number, 0, 3) == $pre) {
            return $number;
        }
        return $pre . $number;
    }
}
