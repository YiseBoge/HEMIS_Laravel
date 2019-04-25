<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class StaffLeave extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    // Enums //
    protected $enumLeaveTypes = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];

    protected $enumScholarshipTypes = [
        'a' => 'abebe',
        'b' => 'bacha',
        'c' => 'challa',
    ];
}