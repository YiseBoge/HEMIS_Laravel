<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class ForeignStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    // protected $enumStaffRanks = [
    //     'GRADUATE_ASSISTANT_I' => 'Graduate Assistant I',
    //     'GRADUATE_ASSISTANT_II' => 'Graduate Assistant II',
    //     'ASSISTANT_LECTURER' => 'Assistant Lecturer',
    //     'LECTURER' => 'Lecturer',
    //     'ASSISTANT_PROFESSOR' => 'Assistant Professor',
    //     'ASSOCIATE_PROFESSOR' => 'Associate Professor',
    //     'PROFESSOR' => 'Professor',
    //     'OTHERS' => 'Others'
    // ];

    protected $enumEducationLevels = [
        'DIPLOMA' => 'Diploma',
        'BACHELORS' => 'Bachelors',
        'MD_DV' => 'M.D/D.V',
        'MASTERS' => 'Masters',
        'PHD' => 'PhD'       
    ];

    protected $enumSexs = [
        'MALE' => 'Male',
        'FEMALE' => 'Female',
    ];

    public function institution()
    {
        return $this->belongsTo('App\Models\Institution\Institution');
    }
}
