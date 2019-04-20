<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;


    // Enums //
    protected $enumInvestmentTitles = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];
}
