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
 * @property string|null region
 * @method static RuralStudentEnrollment findOrFail(int $id)
 */
class RuralStudentEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumRegions = [
        'RURAL' => 'Rural',
        'URBAN' => 'Urban'

    ];

    /**
     * @return BelongsTo
     */
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
        return RuralStudentEnrollment::where(array(
                'department_id' => $this->department_id,
                'region' => $this->region,
            ))->first() != null;
    }
}
