<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\ECPayService;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EcPayTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_user_by_token(): void
    {
        // $response = $this->get('/');

        // $response->assertStatus(200);

        $ecpay_service = new ECPayService();

        $post_data = [
            'MerchantMemberID' => 'test123456',
            'Email' => 'customer@email.com',
            'Phone' => '0912345678',
            'Name' => 'Test',
            'CountryCode' => '158'
        ];

        $token = $ecpay_service->getTokenbyUser($post_data);

        $this->assertIsString($token);
    }


    public function test_get_user_by_trade():void
    {
        $ecpay_service = new ECPayService();

        $post_data = [
            'MerchantMemberID' => 'test123456',
            'Email' => 'customer@email.com',
            'Phone' => '0912345678',
            'Name' => 'Test',
            'CountryCode' => '158',
            'order_no' => 'O' . time() . random_int(1000, 9999),
            'order_amount' => 900, // 必须整数
            'order_goods_name' => 'Test Goods',
            'order_goods_quantity' => 1,
        ];

        $token = $ecpay_service->getTokenbyTrade($post_data);

        $this->assertIsString($token);
    }
}
