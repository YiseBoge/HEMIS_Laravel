<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null male_students_number
 * @property array|string|null female_students_number
 * @property array|string|null sponsor
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

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query)
    {
        return $query->with('department.college.band', 'department.departmentName');
    }

}
