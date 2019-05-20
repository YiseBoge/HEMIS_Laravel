<?php

namespace App\Models\Department;


use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class ExpatriateStaff extends Model
{   
    use Enums;
    use Uuids;

    public $incrementing = false;

    protected $enumStaffRanks = [
        'GRADUATE ASSISTANT' => 'Graduate Assistant',
        'GRADUATE ASSISTANT I' => 'Graduate Assistant I',
        'GRADUATE ASSISTANT II' => 'Graduate Assistant II',
        'ASSISTANT LECTURER' => 'Assistant Lecturer',
        'LECTURER' => 'Lecturer',
        'ASSISTANT PROFESSOR' => 'Assistant Professor',
        'ASSOCIATE PROFESSOR' => 'Associate Professor',
        'PROFESSOR' => 'Professor',
        'OTHERS' => 'Others'
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

}
