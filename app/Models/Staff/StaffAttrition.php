<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null case
 * @method static StaffAttrition findOrFail(int $id)
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

    /**
     * @return BelongsTo
     */
    public function staff()
    {
        return $this->belongsTo('App\Models\Staff\Staff');
    }
}
