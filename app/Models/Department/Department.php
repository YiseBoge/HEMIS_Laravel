<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    protected $enumYearLevels=[
        'ONE'=>'1',
        'TWO'=>'2',
        'THREE'=>'3',
        'FOUR'=>'4',
        'FIVE'=>'5',
        'SIX'=>'6',
        'SEVEN'=>'7'
    ];

    public function departmentName()
    {
        return $this->belongsTo('App\Models\Department\DepartmentName');
    }

    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }
}
