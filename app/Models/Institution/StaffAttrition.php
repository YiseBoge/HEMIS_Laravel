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
        'GOVERNMENT_APPOINTMENT' => 'Government Appointment',
        'TRANSFER_TO_OTHER_HIGHER_EDUCATION_INSTITUTIONS' => 'Transfer to Other Higher Education Institutions',
        'TRANSFER_TO_OTHER_GOVERNMENT_AGENCIES' => 'Transfer to Other Government Agencies',
        'RESIGNATION' => 'Resignation',
        'RETIREMENT' => 'Retirement',
        'DEATH' => 'Death',
        'DISCIPLINE' => 'Descipline',
        'OTHERS' => 'Others',
    ];
}
