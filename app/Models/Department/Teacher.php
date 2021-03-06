<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property int male_number
 * @property int female_number
 * @property string|null level_of_education
 * @property string|null citizenship
 * @method static Teacher findOrFail(int $id)
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
        return $query->with('department.college', 'department.departmentName');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return Teacher::where(array(
                'department_id' => $this->department_id,
                'level_of_education' => $this->level_of_education,
                'citizenship' => $this->citizenship,
            ))->first() != null;
    }
}
