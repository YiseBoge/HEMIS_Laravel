<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null case
 */
class StaffAttrition extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    // Enums //
    protected $enumCases = [
        'GOVERNMENT_APPOINTMENT' => 'Government Appointment',
        'TRANSFER_TO_HIGHER_EDUCATION_INSTITUTIONS' => 'Transfer to Higher Education Institutions',
        'TRANSFER_TO_OTHER_GOVERNMENT_AGENCIES' => 'Transfer to Other Government Agencies',
        'RESIGNATION' => 'Resignation',
        'RETIREMENT' => 'Retirement',
        'DEATH' => 'Death',
        'DISCIPLINE' => 'Discipline',
        'OTHERS' => 'Others'
    ];

    public function staff()
    {
        return $this->belongsTo('App\Models\Staff\Staff');
    }
}
