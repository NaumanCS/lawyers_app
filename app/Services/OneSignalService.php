<?php

namespace App\Services;

use GuzzleHttp\Client;

class OneSignalService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://onesignal.com/api/v1/',
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . env('ONESIGNAL_REST_API_KEY'),
            ],
        ]);
    }

    public function sendOTP($userId, $otp)
    {
        $data = [
            'app_id' => env('ONESIGNAL_APP_ID'),
            'include_player_ids' => [$userId],
            'contents' => ['en' => "Your OTP is: $otp"],
        ];

        try {
            $response = $this->client->post('notifications', [
                'json' => $data,
            ]);

            return $response->getBody()->getContents();
        } catch (\Exception $e) {
            // Handle error
            return $e->getMessage();
        }
    }
}
