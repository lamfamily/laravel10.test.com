<?php

use App\Services\MCPayService;
use App\Models\TmpModels\KieOrder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('find_loreal_incorrect_amount_order', function () {

    // $count = KieOrder::count();
    // $this->info("Total order: $count");

    $select_size = 10;

    $page = 1;


    do {
        $order_list = KieOrder::where('payment_settle_date', '!=', null)
            ->orderBy('id', 'DESC')
            ->skip(($page - 1) * $select_size)
            ->take($select_size)
            ->get();

        foreach ($order_list as $tmp_order) {

            $tmp_order_info = json_decode($tmp_order->order_info, true);

            $tmp_total = $tmp_order->total;
            $tmp_subtotal = $tmp_order->subtotal;
            $tmp_discount = $tmp_order->discount;
            $tmp_shipping_fee = $tmp_order->shipping_fee;

            $tmp_real_total = $tmp_subtotal - $tmp_discount + $tmp_shipping_fee;

            $tmp_products_total = 0;
            foreach ($tmp_order_info['products'] as $tmp_product) {
                $tmp_products_total += $tmp_product['total'];
            }

            $tmp_products_total += $tmp_shipping_fee;

            $tmp_products_discount_non_client = $tmp_order_info['discount_non_client'] ?? 0;
            $tmp_products_total = round($tmp_products_total, 0) - $tmp_products_discount_non_client;

            if ($tmp_products_total != $tmp_total) {
                echo "<pre>";
                var_dump($tmp_order->id, $tmp_products_total, $tmp_total);
                var_dump($tmp_discount, $tmp_shipping_fee, $tmp_subtotal, $tmp_order_info['products'], $tmp_products_discount_non_client);
                echo "</pre>";
                exit();
            }

            // echo "<pre>";
            // var_dump($tmp_total, $tmp_real_total, $tmp_products_total);
            // echo "</pre>";
            // exit();
        }

        $page++;
    } while ($order_list->count() > 0);
});


Artisan::command('test-color', function () {
    $this->line('this is a line');
    $this->warn('this is a warning');
    $this->comment('this is a comment');
    $this->error('this is an error');
    $this->question('this is a question');
    $this->info('this is an info');
    $this->line('<bg=black> My awesome message </>');
    $this->line('<fg=green> My awesome message </>');
    $this->line('<bg=red;fg=yellow> My awesome message </>');
    $this->line('<bg=red;fg=yellow> My awesome message </>');
    $this->line("<options=bold;fg=red> MY AWESOME MESSAGE </>");
    $this->line("<options=bold;fg=red> MY AWESOME MESSAGE </>");
    $this->line("<options=underscore;bg=cyan;fg=blue> MY MESSAGE </>");
});


Artisan::command('test-ecpay-get-token', function () {
    $url = 'https://ecpg-stage.ecpay.com.tw/Merchant/GetTokenbyUser';

    $merchant_id = '3002607';
    $current_timestamp = time();

    // AES 加密用的 KEY 和 IV
    $hask_key = 'pwFHCqoQZGmho4w6';
    $hash_iv = 'EkRm7iFT261dpevs';

    $tmp_data = [
        'MerchantID' => $merchant_id,
        'ConsumerInfo' => [
            'MerchantMemberID' => 'test123456',
            'Email' => 'customer@email.com',
            'Phone' => '0912345678',
            'Name' => 'Test',
            'CountryCode' => '158'
        ]
    ];

    // 先 urlencode,在进行AES加密，128bit,cipermode = CBC, padding_mode = PKCS7
    $data = urlencode(json_encode($tmp_data));
    $data = openssl_encrypt($data, 'AES-128-CBC', $hask_key, OPENSSL_RAW_DATA, $hash_iv);
    $data = base64_encode($data);

    $data = [
        'MerchantID' => $merchant_id,
        'RqHeader' => [
            'Timestamp' => $current_timestamp,
        ],
        'Data' => $data,
    ];

    $res = Http::post($url, $data);

    $res_data = $res->json();

    $status_code = $res->status();

    if ($status_code == 200) {

        $trans_code = $res_data['TransCode'] ?? '';
        if (!$trans_code) {
            $this->info('request api error!');
            return;
        }

        if ($trans_code != 1) {
            $this->info('request api error:' . $res_data['TransMsg'] ?? '');
            return;
        }

        // AES decrpt
        $return_data = openssl_decrypt(base64_decode($res_data['Data']), 'AES-128-CBC', $hask_key, OPENSSL_RAW_DATA, $hash_iv);

        $return_data = json_decode(urldecode($return_data), true);

        echo "<pre>";
        var_dump($return_data);
        echo "</pre>";
        exit();
    } else {
        $this->info('request api error!');
    }
});

Artisan::command('test-ecpay-service', function () {
    $ecpay_service = new MCPayService();

    $post_data = [
        'MerchantMemberID' => 'test123456',
        'Email' => 'customer@email.com',
        'Phone' => '0912345678',
        'Name' => 'Test',
        'CountryCode' => '158'
    ];

    $this->info($ecpay_service->getToken($post_data));
});
