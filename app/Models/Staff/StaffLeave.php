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
