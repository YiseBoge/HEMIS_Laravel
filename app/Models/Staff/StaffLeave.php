<?php

namespace App\Models\Staff;

use App\Models\Institution\Institution;
use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static StaffLeave find(Uuid $staff_leave_id)
 * @property string|null leave_type
 * @property Institution institution
 * @property string|null country_of_study
 * @property string|null rank_of_study
 * @property string|null status_of_study
 * @property string|null scholarship_type
 */
class StaffLeave extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    // Enums //
    protected $enumLeaveTypes = [
        'FULL' => 'Full',
        'PART' => 'Partial',
    ];
    protected $enumScholarshipTypes = [
        'GOVT' => 'Government',
        'OTHER' => 'Other',
    ];

    /**
     * @return HasOne
     */
    public function academicStaff()
    {
        return $this->hasOne('App\Models\Staff\AcademicStaff');
    }
}
