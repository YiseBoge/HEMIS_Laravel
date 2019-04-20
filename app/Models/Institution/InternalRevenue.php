<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class InternalRevenue extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;


    // Enums //
    protected $enumRevenueDescriptions = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];
}
