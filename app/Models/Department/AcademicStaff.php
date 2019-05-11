<?php

namespace App\Models\Department;

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

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }
}
