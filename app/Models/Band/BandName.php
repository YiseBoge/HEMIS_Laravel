<?php

namespace App\Models\Band;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null band_name
 * @property string|null acronym
 * @method static BandName find(mixed $id)
 */
class BandName extends Model
{
    use Uuids;

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (BandName $model) { // before delete() method call this
            $model->departmentNames()->delete();
        });
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
     * @return bool
     */
    public function isDuplicate()
    {
        return BandName::where(array(
                'acronym' => $this->acronym,
            ))->first() != null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "$this->acronym - $this->band_name";
    }
}
