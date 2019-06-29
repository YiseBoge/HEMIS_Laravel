<?php

namespace App\Models\Department;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null department_name
 * @property array|string|null acronym
 * @method static DepartmentName find(int $id)
 */
class DepartmentName extends Model
{
    use Uuids;

    public $incrementing = false;

    public function department()
    {
        return $this->hasOne('App\Models\Department\Department');
    }

    public function __toString()
    {
        return "$this->acronym - $this->department_name";
    }

    public function users()
    {
        return $this->hasMany('App\User');
    }
}
