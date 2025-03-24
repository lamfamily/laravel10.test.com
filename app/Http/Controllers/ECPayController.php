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

            $order_no = 'O' . time() . random_int(1000, 9999);

            $post_data = [
                'MerchantMemberID' => 'test123456',
                'Email' => 'customer@email.com',
                'Phone' => '0912345678',
                'Name' => 'Test',
                'CountryCode' => '158',
                'order_no' => $order_no,
                'order_amount' => 900, // 必须整数
                'order_goods_name' => 'Test Goods',
                'order_goods_quantity' => 1,
            ];

            $token = $ecpay_service->getTokenByTrade($post_data);

            return view('ecpay.test1', [
                'token' => $token,
                'env' => $ecpay_service->env,
                'order_no' => $order_no,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }


    public function test2(Request $request)
    {
        $ecpay_service = new ECPayService();
        $post_data = $request->all();

        $ecpay_service->createPayment($post_data['PayToken'], $post_data['order_no']);
    }

    public function orderSuccess(Request $request)
    {
        $order_no = $request->get('order_no');
        return view('ecpay.order_success', ['order_no' => $order_no]);
    }


    public function orderFail(Request $request)
    {
        return view('ecpay.order_fail');
    }


    public function returnCall(Request $request)
    {
        $post_data = $request->all();

        $ecpay_service = new ECPayService();

        

    }

    public function periodReturnCall(Request $request)
    {
        $post_data = $request->all();
        echo "<pre>";
        var_dump('period return call', $post_data);
        echo "</pre>";
        exit();
    }

    public function threeDOrderResultCall(Request $request)
    {
        $post_data = $request->all();

        $result_data = $post_data['ResultData'];

        $result_data = json_decode($result_data, true);

        $ecpay_service = new ECPayService();

        try {
            $order_no = $ecpay_service->handle3DOrderResultData($result_data);

            return redirect()->route('ecpay.order_success', ['order_no' => $order_no]);
        } catch (\Exception $e) {
            return redirect()->route('ecpay.order_fail');
        }
    }


    public function unionOrderResultCall(Request $request)
    {
        $post_data = $request->all();
        echo "<pre>";
        var_dump('union order result call', $post_data);
        echo "</pre>";
        exit();
    }
}
