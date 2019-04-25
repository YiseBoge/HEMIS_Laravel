<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class OtherAttrition extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;


    // Enums //
    protected $enumTypes = [
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
