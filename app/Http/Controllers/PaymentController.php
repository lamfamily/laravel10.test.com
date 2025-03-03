<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /*
     * 处理mastercard return
     * @author: Justin Lin
     * @date : 2025-03-03 11:27:44
     */
    public function return(Request $request, $check_code)
    {

        $params = $request->all();
        echo "<pre>";
        var_dump($params,$check_code);
        echo "</pre>";
        exit();
    }

    /*
     * 处理mastercard cancel
     * @author: Justin Lin
     * @date : 2025-03-03 11:27:52
     */
    public function cancel(Request $request, $check_code)
    {

        $params = $request->all();
        echo "<pre>";
        var_dump($params,$check_code);
        echo "</pre>";
        exit();
    }
}
