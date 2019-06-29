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
 * @property array|string|null quintile
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

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query)
    {
        return $query->with('department.college.band', 'department.departmentName');
    }
}
