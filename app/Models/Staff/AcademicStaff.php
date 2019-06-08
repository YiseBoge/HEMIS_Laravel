<?php

namespace App\Models\Staff;


use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

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
