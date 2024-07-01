<?php

namespace App\Http\Controllers\OneSignal;

use App\Http\Controllers\Controller;
use App\Services\OneSignalService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class OneSignalController extends Controller
{
    protected $oneSignalService;

    public function __construct(OneSignalService $oneSignalService)
    {
        $this->oneSignalService = $oneSignalService;
    }

    public function sendOTP()
    {
        // Generate OTP
        $otp = mt_rand(100000, 999999);

        // Send OTP via OneSignal
        $userId = '+923087167360'; // Replace with the actual player ID
        $response = $this->oneSignalService->sendOTP($userId, $otp);

        // Handle response
        // You can return response or do any further processing here
    }
}
