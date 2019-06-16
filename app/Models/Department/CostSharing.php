<?php

namespace App\Models\Department;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class CostSharing extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumSexs = [
        'MALE' => 'male',
        'FEMALE' => 'female',
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
