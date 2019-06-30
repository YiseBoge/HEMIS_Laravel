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
 * @property string|null student_type
 * @property string|null specialization_type
 * @property string|null field_of_specialization
 */
class SpecializingStudentsEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumStudentTypes = [
        'CURRENT' => 'Current',
        'PREVIOUS_YEAR_GRADUATES' => 'Previous Year Graduates',
        'PROSPECTIVE_GRADUATES' => 'Prospective Graduates'
    ];

    protected $enumSpecializationTypes = [
        'SPECIALIZATION' => 'Specialization',
        'SUB_SPECIALIZATION' => 'Sub Specialization'
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
}
