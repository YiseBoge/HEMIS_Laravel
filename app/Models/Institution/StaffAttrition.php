<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class StaffAttrition extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;



    // Enums //
    protected $enumQualifications = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];

    protected $enumCases = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];
}
