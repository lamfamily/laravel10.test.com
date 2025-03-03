<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MCPayController extends Controller
{
    public function test1(Request $request)
    {
        return view('mcpay.test1');
    }
}
