<?php

use App\Models\TmpModels\KieOrder;
use Illuminate\Foundation\Inspiring;
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
