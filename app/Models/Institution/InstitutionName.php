<?php

namespace App\Models\Institution;

use App\Models\College\CollegeName;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null institution_name
 * @property string|null acronym
 * @property bool is_private
 * @property CollegeName collegeNames
 * @property Collection departmentNames
 * @method static InstitutionName find($id)
 */
class InstitutionName extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * @return HasMany
     */
    public function institutions()
    {
        return $this->hasMany('App\Models\Institution\Institution');
    }

    /**
     * @return HasMany
     */
    public function collegeNames()
    {
        return $this->hasMany('App\Models\College\CollegeName');
    }

    /**
     * @return HasMany
     */
    public function departmentNames()
    {
        return $this->hasMany('App\Models\Department\DepartmentName');
    }

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->acronym - $this->institution_name";
    }
}
