<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MCPayService;

class MCPayController extends Controller
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

            $ecpay_service = new MCPayService();

            $post_data = [
                'MerchantMemberID' => 'test123456',
                'Email' => 'customer@email.com',
                'Phone' => '0912345678',
                'Name' => 'Test',
                'CountryCode' => '158'
            ];

            $token = $ecpay_service->getToken($post_data);

            return view('mcpay.test1', [
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
