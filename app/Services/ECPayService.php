<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ECPayService
{
    const RETURN_SUCCESSS_CODE = 1;

    private $base_url;
    private $merchant_id;
    private $hash_key;
    private $hash_iv;
    private $return_base_url;

    public $env;

    public function __construct()
    {
        if (config('app.env') == 'production') {
            $this->base_url = 'https://ecpg.ecpay.com.tw/';
            $this->env = 'Prod';

            throw new \Exception('Production MCPayService is not ready yet');
        } else {
            $this->base_url = 'https://ecpg-stage.ecpay.com.tw/';
            $this->env = 'Stage';
            $this->merchant_id = '3002607';
            $this->hash_key = 'pwFHCqoQZGmho4w6';
            $this->hash_iv = 'EkRm7iFT261dpevs';
        }

        $this->return_base_url = config('app.url');
    }

    public function buildCustomerInfo($post_data)
    {
        return [
            'MerchantMemberID' => $post_data['MerchantMemberID'] ?? '',
            'Email' => $post_data['Email'] ?? '',
            'Phone' => $post_data['Phone'] ?? '',
            'Name' => $post_data['Name'] ?? '',
            'CountryCode' => 158, // 表示台湾地区
        ];
    }

    // 这个token 时用来删除信用卡的，不能用来交易
    public function getTokenbyUser($post_data)
    {
        $req_id = __FUNCTION__ . ': ' . Str::uuid()->toString();

        $req_url = $this->base_url . 'Merchant/GetTokenbyUser';

        $current_timestamp = time();

        $req_data = [
            'MerchantID' => $this->merchant_id,
            'ConsumerInfo' => $this->buildCustomerInfo($post_data),
        ];

        $req_data = urlencode(json_encode($req_data));

        $req_data = openssl_encrypt($req_data, 'AES-128-CBC', $this->hash_key, OPENSSL_RAW_DATA, $this->hash_iv);

        $req_data = base64_encode($req_data);


        $req_data = [
            'MerchantID' => $this->merchant_id,
            'RqHeader' => [
                'Timestamp' => $current_timestamp,
            ],
            'Data' => $req_data,
        ];

        $res = Http::post($req_url, $req_data);

        Log::channel('ecpay')->info('request log: ' . $req_id, [$req_url, $req_data, $res->json()]);

        $res_data = $res->json();

        $status_code = $res->status();

        if ($status_code == 200) {
            $trans_code = $res_data['TransCode'] ?? '';

            if (!$trans_code) {
                throw new \Exception('HTTP Request Error: ' . $req_id);
            }

            if ($trans_code != 1) {
                throw new \Exception('HTTP Request Error: ' . $req_id);
            }

            $return_data = openssl_decrypt(base64_decode($res_data['Data']), 'AES-128-CBC', $this->hash_key, OPENSSL_RAW_DATA, $this->hash_iv);

            $return_data = json_decode(urldecode($return_data), true);

            Log::channel('ecpay')->info('response log: ' . $req_id, $return_data);

            if ($return_data['RtnCode'] == self::RETURN_SUCCESSS_CODE) {
                return $return_data['Token'];
            } else {
                throw new \Exception('HTTP Request Error: ' . $req_id);
            }
        } else {
            throw new \Exception('HTTP Request Error: ' . $req_id);
        }
    }


    public function getTokenByTrade($post_data)
    {
        $req_id = __FUNCTION__ . ': ' . Str::uuid()->toString();

        $req_url = $this->base_url . 'Merchant/GetTokenByTrade';

        $current_timestamp = time();

        $order_info = [
            //交易時間
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            //交易編號
            'MerchantTradeNo' => $post_data['order_no'],
            //交易金額
            'TotalAmount' => $post_data['order_amount'],
            //付款回傳結果
            'ReturnURL' => $this->return_base_url . '/ecpay/return_call',
            //交易描述
            'TradeDesc' => $post_data['order_goods_name'] . '*' . $post_data['order_goods_quantity'],
            //商品名稱
            'ItemName' => $post_data['order_goods_name'],
        ];

        $atm_info = [
            //允許繳費有效天數
            'ExpireDate' => '1',
            'ATMBankCode' => '118',
        ];

        $cvs_info = [
            //超商繳費截止時間
            'StoreExpireDate' => 7,
            'CVSCode' => 'FAMILY',
            'Desc_1' => '',
            'Desc_2' => '',
            'Desc_3' => '',
            'Desc_4' => '',
        ];

        $barcode_info = [
            //超商繳費截止時間
            'StoreExpireDate' => '10',
        ];

        $card_info = [
            //使用信用卡紅利 0: 不使用
            'Redeem' => '0',
            //刷卡分期期數
            'CreditInstallment' => '3,6,12',
            //定期定額每次授權金額
            'PeriodAmount' => '100',
            //定期定額週期種類
            'PeriodType' => 'M',
            //執行頻率
            'Frequency' => '12',
            //執行次數
            'ExecTimes' => '99',
            //定期定額的執行結果回應URL
            'PeriodReturnURL' => $this->return_base_url . '/ecpay/period_return_call',
            //3D授權回傳網址
            'OrderResultURL' => $this->return_base_url . '/ecpay/3d_order_result_call',
            //圓夢彈性分期期
            'FlexibleInstallment' => '30',
        ];

        $union_pay_info = [
            'OrderResultURL' => 'http://laravel10.test.com/ecpay/union_order_result_call',
        ];

        $req_data = [
            'MerchantID' => $this->merchant_id,
            //是否使用記憶卡號功能
            'RememberCard' => '1',
            //畫面的呈現方式 2 : 付款選擇清單頁
            'PaymentUIType' => '2',
            //付款方式 0 : 全部付款方式
            'ChoosePaymentList' => '0',
            //交易資訊
            'OrderInfo' => $order_info,
            //ATM資訊
            'ATMInfo' => $atm_info,
            //超商代碼資訊
            'CVSInfo' => $cvs_info,
            //超商條碼資訊
            'BarcodeInfo' => $barcode_info,
            //信用卡資訊
            'CardInfo' => $card_info,
            // 銀聯卡資訊
            'UnionPayInfo' => $union_pay_info,
            //消費者資訊
            'ConsumerInfo' => $this->buildCustomerInfo($post_data),
            //特店自訂欄位
            'CustomField' => '"designer":"icoderexpert","database":"MemberDB","solution":"mem"',
        ];

        $req_data = urlencode(json_encode($req_data));

        $req_data = openssl_encrypt($req_data, 'AES-128-CBC', $this->hash_key, OPENSSL_RAW_DATA, $this->hash_iv);

        $req_data = base64_encode($req_data);

        $req_data = [
            'MerchantID' => $this->merchant_id,
            'RqHeader' => [
                'Timestamp' => $current_timestamp,
            ],
            'Data' => $req_data,
        ];

        $res = Http::post($req_url, $req_data);

        Log::channel('ecpay')->info('request log: ' . $req_id, [$req_url, $req_data, $res->json()]);

        $res_data = $res->json();

        $status_code = $res->status();

        if ($status_code == 200) {
            $trans_code = $res_data['TransCode'] ?? '';

            if (!$trans_code) {
                throw new \Exception('HTTP Request Error: ' . $req_id);
            }

            if ($trans_code != 1) {
                throw new \Exception('HTTP Request Error: ' . $req_id);
            }

            $return_data = openssl_decrypt(base64_decode($res_data['Data']), 'AES-128-CBC', $this->hash_key, OPENSSL_RAW_DATA, $this->hash_iv);

            $return_data = json_decode(urldecode($return_data), true);

            Log::channel('ecpay')->info('response log: ' . $req_id, $return_data);

            if ($return_data['RtnCode'] == self::RETURN_SUCCESSS_CODE) {
                return $return_data['Token'];
            } else {
                throw new \Exception('HTTP Request Error: ' . $req_id);
            }
        } else {
            throw new \Exception('HTTP Request Error: ' . $req_id);
        }
    }


    public function createPayment($pay_token, $order_no)
    {
        $req_id = __FUNCTION__ . ': ' . Str::uuid()->toString();

        $req_url = $this->base_url . 'Merchant/CreatePayment';

        $current_timestamp = time();

        $req_data = [
            'MerchantID' => $this->merchant_id,
            'PayToken' => $pay_token,
            'MerchantTradeNo' => $order_no,
        ];

        $req_data = urlencode(json_encode($req_data));

        $req_data = openssl_encrypt($req_data, 'AES-128-CBC', $this->hash_key, OPENSSL_RAW_DATA, $this->hash_iv);

        $req_data = base64_encode($req_data);

        $req_data = [
            'MerchantID' => $this->merchant_id,
            'RqHeader' => [
                'Timestamp' => $current_timestamp,
            ],
            'Data' => $req_data,
        ];

        $res = Http::post($req_url, $req_data);

        Log::channel('ecpay')->info('request log: ' . $req_id, [$req_url, $req_data, $res->json()]);

        $res_data = $res->json();

        $status_code = $res->status();

        if ($status_code == 200) {
            $trans_code = $res_data['TransCode'] ?? '';

            if (!$trans_code) {
                throw new \Exception('HTTP Request Error: ' . $req_id);
            }

            if ($trans_code != 1) {
                throw new \Exception('HTTP Request Error: ' . $req_id);
            }

            $return_data = openssl_decrypt(base64_decode($res_data['Data']), 'AES-128-CBC', $this->hash_key, OPENSSL_RAW_DATA, $this->hash_iv);

            $return_data = json_decode(urldecode($return_data), true);

            Log::channel('ecpay')->info('response log: ' . $req_id, $return_data);

            if ($return_data['RtnCode'] == self::RETURN_SUCCESSS_CODE) {
                $_3d_url = $return_data['ThreeDInfo']['ThreeDURL'];

                header('Location: ' . $_3d_url);
                exit();
            } else {
                throw new \Exception('HTTP Request Error: ' . $req_id);
            }
        } else {
            throw new \Exception('HTTP Request Error: ' . $req_id);
        }
    }


    public function handle3DOrderResultData($result_data)
    {
        $req_id = __FUNCTION__ . ': ' . Str::uuid()->toString();

        $trans_code = $result_data['TransCode'] ?? '';

        if (!$trans_code) {
            throw new \Exception('HTTP Request Error: ' . $req_id);
        }

        if ($trans_code != 1) {
            throw new \Exception('HTTP Request Error: ' . $req_id);
        }

        $return_data = openssl_decrypt(base64_decode($result_data['Data']), 'AES-128-CBC', $this->hash_key, OPENSSL_RAW_DATA, $this->hash_iv);

        $return_data = json_decode(urldecode($return_data), true);

        Log::channel('ecpay')->info('response log: ' . $req_id, $return_data);

        if ($return_data['RtnCode'] == self::RETURN_SUCCESSS_CODE) {
            $order_info = $return_data['OrderInfo'];
            $order_no = $order_info['MerchantTradeNo'];

            // TODO: update database order_info status

            return $order_no;
        } else {
            throw new \Exception('HTTP Request Error: ' . $req_id);
        }
    }


    public function handleReturnCall($post_data)
    {
        $req_id = __FUNCTION__ . ': ' . Str::uuid()->toString();

        Log::channel('ecpay')->info('response log: ' . $req_id, $post_data);
    }


    public function handlePeriodReturnCall($post_data)
    {
        $req_id = __FUNCTION__ . ': ' . Str::uuid()->toString();

        Log::channel('ecpay')->info('response log: ' . $req_id, $post_data);
    }


    public function handleUnionOrderResultCall($post_data)
    {
        $req_id = __FUNCTION__ . ': ' . Str::uuid()->toString();

        Log::channel('ecpay')->info('response log: ' . $req_id, $post_data);
    }
}
