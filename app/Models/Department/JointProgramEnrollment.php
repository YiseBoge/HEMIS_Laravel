<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property int male_students_number
 * @property int female_students_number
 * @property int sponsor
 * @method static JointProgramEnrollment find(int $id)
 */
class JointProgramEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumSponsors = [
        'ETHIOPIAN_GOVERNMENT' => 'Ethiopian Government',
        'OTHER' => 'Other'
    ];

    /**
     * @return BelongsTo
     */
    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeInfo($query)
    {
        return $query->with('department.college.band', 'department.departmentName');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return JointProgramEnrollment::where(array(
                'department_id' => $this->department_id,
                'sponsor' => $this->sponsor,
            ))->first() != null;
    }

}
