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
 * @property string|null quintile
 */
class DisadvantagedStudentEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumQuintiles = [
        'LOWEST' => 'Lowest',
        'SECOND' => 'Second',
        'THIRD' => 'Third',
        'FOURTH' => 'Fourth',
        'HIGHEST_FIFTH' => 'Highest Fifth'
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
