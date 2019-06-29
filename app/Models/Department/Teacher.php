<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null male_number
 * @property array|string|null female_number
 * @property array|string|null level_of_education
 * @property array|string|null citizenship
 */
class Teacher extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumEducationLevels = [
        'FIRST_DEGREE' => 'First Degree(Bachelors)',
        'SECOND_DEGREE' => 'Second Degree(Masters)',
        'THIRD_DEGREE' => 'Third Degree(PhD)'
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
