<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class InstitutionName extends Model
{
    use Uuids;

    public $incrementing = false;

    public function institutions()
    {
        return $this->hasMany('App\Models\Institution\Institution');
    }

    public function collegeNames()
    {
        return $this->hasMany('App\Models\College\CollegeName');
    }

    public function departmentNames()
    {
        return $this->hasMany('App\Models\Department\DepartmentName');
    }

    public function budgetDescriptions()
    {
        return $this->hasMany('App\Models\College\BudgetDescription');
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function __toString()
    {
        return "$this->acronym - $this->institution_name";
    }
}
