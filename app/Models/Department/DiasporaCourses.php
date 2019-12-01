<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property int number_of_courses
 * @property int number_of_researches
 * @property string|null approval_status
 * @property string|null action
 * @property int male_number
 * @property int female_number
 * @method static DiasporaCourses findOrFail(int $id)
 */
class DiasporaCourses extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumActions = [
        'TEACHING' => 'Teaching',
        'RESEARCH' => 'Research',
        'ACADEMIC_ADVISING' => 'Academic Advising'

    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query)
    {
        return $query->with('department.college', 'department.departmentName');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return DiasporaCourses::where(array(
                'department_id' => $this->department_id,
                'action' => $this->action,
            ))->first() != null;
    }
}
