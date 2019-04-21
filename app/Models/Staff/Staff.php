<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    // Enums //
    protected $enumAcademicLevels = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];

    protected $enumDedications = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];

    protected $enumSexs = [
        'MALE' => 'male',
        'FEMALE' => 'female',
    ];

    protected $enumEmploymentTypes = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];
}
