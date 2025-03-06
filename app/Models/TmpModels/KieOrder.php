<?php

namespace App\Models\TmpModels;

use Illuminate\Database\Eloquent\Model;

class KieOrder extends Model
{
    protected $connection = 'loreal_dev';
    protected $table = 'lo_kie_pd__order';
}
