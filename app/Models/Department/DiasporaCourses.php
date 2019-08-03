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
 * @method static DiasporaCourses find(int $id)
 */
class DiasporaCourses extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query)
    {
        return $query->with('department.college.band', 'department.departmentName');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return DiasporaCourses::where(array(
                'department_id' => $this->department_id,
            ))->first() != null;
    }
}
