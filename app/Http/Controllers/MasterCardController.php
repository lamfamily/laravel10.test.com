<?php

namespace App\Http\Controllers;

use App\Services\MasterCardService;
use Illuminate\Http\Request;

class MasterCardController extends Controller
{
    public function test1(Request $request)
    {
        $init_checkout_data = [
            'apiOperation' => 'INITIATE_CHECKOUT',
            'interaction' => [
                'action' => [
                    '3DSecure' => 'USE_GATEWAY_RECOMMENDATION',
                ],
                'displayControl' => [
                    'billingAddress' => 'HIDE',
                    'customerEmail' => 'HIDE',
                ],
                'operation' => 'AUTHORIZE',
                'merchant' => [
                    'name' => 'Test Merchant',
                ],
            ],
            'order' => [
                'id' => 'LAM000001',
                'amount' => 1.2,
                'currency' => config('mastercard.GATEWAY_DEFAULT_CURRENCY'),
                'description' => 'Test Order',
            ],
            'customer' => [
                'firstName' => 'Lam',
                'lastName' => 'Kakyun',
                'mobilePhone' => '85212312312',
                'email' => 'lam@gmail.com'
            ],
        ];

        $res = MasterCardService::createSession($init_checkout_data);

        if (isset($res['error']) && $res['error']) {
            return abort(500, $res['message'] ?? '');
        }

        $session_id = $res['session']['id'];

        return view('mastercard.test1', compact('session_id'));
    }
}
