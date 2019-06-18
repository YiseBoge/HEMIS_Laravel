<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class JointProgramEnrollment extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumSponsors = [
        'ETHIOPIAN_GOVERNMENT'=>'Ethiopian Government',
        'OTHER' => 'Other'        
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