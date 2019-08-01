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
 * @property int student_type
 * @property string approval_status
 * @property Uuid department_id
 * @method static Enrollment find($id)
 */
class Enrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumStudentTypes = [
        'NORMAL' => 'Normal',
        'PROSPECTIVE' => 'Prospective Graduates',
        'GRADUATES' => 'Graduates'

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
        die($this->department_id);
        return Enrollment::where(array(
                'department_id' => $this->department_id,
                'student_type' => $this->student_type,
            ))->first() != null;
    }

}
