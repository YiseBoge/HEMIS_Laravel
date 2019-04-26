<?php

namespace App\Models\Staff\Specialization;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class AcademicStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public function general(){
        return $this->morphOne('App\Models\Staff\Staff', 'staffable');
    }



    // Enums //
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
}
