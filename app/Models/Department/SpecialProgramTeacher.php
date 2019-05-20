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
        'English LANGUAGE IMPROVEMENT PROGRAM' => 'English Language Improvement Program',
        'COMPREHENSIVE CONTINUOUS PROFESSIONAL DEVELOPMENT' => 'Comprehensive Continuous Professional Development',
        'HIGHER DIPLOMA PROGRAM' => 'Higher Diploma Program'
    ];

    protected $enumProgramStats = [
        'COMPLETED' => 'Completed',
        'ON TRAINING' => 'On Training',
        'NOT YET STARTED' => 'Not Yet Started'
    ];

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query){
        return $query->with('department.College.band','department.departmentName');
    }
}
