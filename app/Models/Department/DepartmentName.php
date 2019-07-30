<?php

namespace App\Models\Department;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
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

    public static function boot() {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function(DepartmentName $model) { // before delete() method call this
            $model->department()->delete();
            $model->users()->delete();
        });
    }

    /**
     * @return HasMany
     */
    public function department()
    {
        return $this->hasMany('App\Models\Department\Department');
    }

    /**
     * @param Collection $collegeNames
     * @return DepartmentName[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function departmentNamesByColleges(Collection $collegeNames)
    {
        return DepartmentName::all()->whereIn('college_name_id', $collegeNames->pluck('id'));
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
