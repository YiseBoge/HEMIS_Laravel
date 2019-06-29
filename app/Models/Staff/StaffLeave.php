<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static StaffLeave find(int $staff_leave_id)
 * @property array|string|null leave_type
 * @property array|string|null institution
 * @property array|string|null country_of_study
 * @property array|string|null rank_of_study
 * @property array|string|null status_of_study
 * @property array|string|null scholarship_type
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

    public function academicStaff()
    {
        return $this->hasOne('App\Models\Staff\AcademicStaff');
    }
}
