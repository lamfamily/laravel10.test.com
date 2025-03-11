<?php

namespace App\Services;

use App\Services\Contracts\TestServiceInterface;

class Test1Service implements TestServiceInterface
{
    public function doSomething()
    {
        return "Test1Service doSomething";
    }
}
