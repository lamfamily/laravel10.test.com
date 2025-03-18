<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MCPayService
{
    const RETURN_SUCCESSS_CODE = 1;

    private $base_url;
    private $merchant_id;
    private $hash_key;
    private $hash_iv;

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

    public function getToken($post_data)
    {
        $req_id = Str::uuid()->toString();

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

        Log::channel('mcpay')->info('request log: ' . $req_id, [$req_url, $req_data, $res->json()]);

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

            Log::channel('mcpay')->info('response log: ' . $req_id, $return_data);

            if ($return_data['RtnCode'] == self::RETURN_SUCCESSS_CODE) {
                return $return_data['Token'];
            } else {
                throw new \Exception('HTTP Request Error: ' . $req_id);
            }
        } else {
            throw new \Exception('HTTP Request Error: ' . $req_id);
        }
    }
}
