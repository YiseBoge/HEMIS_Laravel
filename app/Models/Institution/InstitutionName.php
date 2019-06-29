<?php

namespace App\Models\Institution;

use App\Models\College\CollegeName;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null institution_name
 * @property array|string|null acronym
 * @property bool is_private
 * @property CollegeName collegeNames
 * @property Collection departmentNames
 * @method static InstitutionName find($id)
 */
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
