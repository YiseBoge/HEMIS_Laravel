<?php

namespace App\Models\Student;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class ForeignerStudent extends Model
{
    use Uuids;

    public $incrementing = false;

    public function general()
    {
        return $this->morphOne('App\Models\Student\Student', 'studentable');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department\Department');
    }

    public function scopeInfo($query)
    {
        
        return $query->with('general.studentService.dormitoryService', 'department.departmentName', 'department.band.bandName');

        
    }
}
