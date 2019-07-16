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
