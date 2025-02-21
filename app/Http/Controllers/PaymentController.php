<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function return(Request $request, $check_code)
    {

        $params = $request->all();
        echo "<pre>";
        var_dump($params,$check_code);
        echo "</pre>";
        exit();
    }

    public function cancel(Request $request, $check_code)
    {

        $params = $request->all();
        echo "<pre>";
        var_dump($params,$check_code);
        echo "</pre>";
        exit();
    }
}
