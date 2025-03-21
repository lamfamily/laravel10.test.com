<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ECPayService;

class ECPayController extends Controller
{
    public function test1(Request $request)
    {
        try {
            $post_data = [
                'MerchantMemberID' => 'test123456',
                'Email' => 'customer@email.com',
                'Phone' => '0912345678',
                'Name' => 'Test',
                'CountryCode' => '158'
            ];

            $ecpay_service = new ECPayService();

            $post_data = [
                'MerchantMemberID' => 'test123456',
                'Email' => 'customer@email.com',
                'Phone' => '0912345678',
                'Name' => 'Test',
                'CountryCode' => '158'
            ];

            $token = $ecpay_service->getToken($post_data);

            return view('ecpay.test1', [
                'token' => $token,
                'env' => $ecpay_service->env,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
