<?php

use App\Services\ECPayService;
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

