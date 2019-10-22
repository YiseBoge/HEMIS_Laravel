<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property integer males_sat
 * @property integer females_sat
 * @property integer males_passed
 * @property integer females_passed
 * @method static ExitExamination find(int $id)
 */
class ExitExamination extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

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
        return ExitExamination::where(array(
                'department_id' => $this->department_id
            ))->first() != null;
    }
}
