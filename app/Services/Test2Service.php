<?php

namespace App\Services;

use App\Services\Contracts\TestServiceInterface;

class Test2Service implements TestServiceInterface
{
    public function doSomething()
    {
        return "Test2Service doSomething";
    }
}
