<?php

namespace App\Models\Department;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null department_name
 * @property string|null acronym
 * @method static DepartmentName find(int $id)
 */
class DepartmentName extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * @return HasOne
     */
    public function department()
    {
        return $this->hasOne('App\Models\Department\Department');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->acronym - $this->department_name";
    }

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}
