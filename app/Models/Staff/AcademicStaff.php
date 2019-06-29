<?php

namespace App\Models\Staff;


use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null field_of_study
 * @property array|string|null teaching_load
 * @property array|string|null overload_remark
 * @property array|string|null staffRank
 * @property int staff_leave_id
 * @property Staff general
 * @method static AcademicStaff find($id)
 * @method static Collection where(array $array)
 */
class AcademicStaff extends Model
{
    use Uuids;
    use Enums;
    public $incrementing = false;
    protected $enumStaffRanks = [
        'GRADUATE_ASSISTANT_I' => 'Graduate Assistant I',
        'GRADUATE_ASSISTANT_II' => 'Graduate Assistant II',
        'ASSISTANT_LECTURER' => 'Assistant Lecturer',
        'LECTURER' => 'Lecturer',
        'ASSISTANT_PROFESSOR' => 'Assistant Professor',
        'ASSOCIATE_PROFESSOR' => 'Associate Professor',
        'PROFESSOR' => 'Professor',
        'OTHERS' => 'Others'
    ];

    // Enums //
    public function general()
    {
        return $this->morphOne('App\Models\Staff\Staff', 'staffable');
    }

    public function staffLeave()
    {
        return $this->belongsTo('App\Models\Staff\StaffLeave');
    }

    public function publications()
    {
        return $this->hasMany('App\Models\Staff\StaffPublication');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query)
    {
        if ($this->staff_leave_id == 0) {
            return $query->with('general');
        } else {
            return $query->with('general', 'staffLeave');
        }

    }
}
