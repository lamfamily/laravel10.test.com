<?php

namespace App\Http\Controllers;

use App\Services\Contracts\TestServiceInterface;
use App\Services\Test1Service;
use App\Services\Test2Service;

class TestController extends Controller
{

    protected $testService;
    protected $test1Service;
    protected $test2Service;

    public function __construct(TestServiceInterface $testService, Test1Service $test1Service, Test2Service $test2Service)
    {
        $this->testService = $testService;
        $this->test1Service = $test1Service;
        $this->test2Service = $test2Service;
    }

    public function test1()
    {
        echo "<pre>";
        var_dump($this->testService->doSomething());
        var_dump($this->test1Service->doSomething());
        var_dump($this->test2Service->doSomething());
        echo "</pre>";
        exit();
    }

    public function test2(TestServiceInterface $testService)
    {
        return response($testService->doSomething());
    }

    public function test3()
    {
        return response(app(TestServiceInterface::class)->doSomething());
    }
}
