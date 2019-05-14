<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class SpecialProgramTeacher extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;    

    protected $enumProgramTypes = [
        'ELIP' => 'English Language Improvement Program',
        'CCPD' => 'Comprehensive Continous Professional Development',
        'HDP' => 'Higher Diploma Program'
    ];

    protected $enumProgramStats= [
        'COMPLETED' => 'Completed',
        'ON_TRAINING' => 'On Training',
        'NOT_YET_STARTED' => 'Not Yet Started'
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query){
        return $query->with('department.College.band','department.departmentName');
    }
}
