<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static Collection where(string $string, array|string|null $input)
 * @method static RegionName findOrFail(int $id)
 * @property string|null name
 */
class RegionName extends Model
{
    use Uuids;

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (RegionName $model) { // before delete() method call this
            $model->specialRegionEnrollment()->delete();
        });
    }

    public function specialRegionEnrollment()
    {
        return $this->hasMany('App\Models\Department\SpecialRegionEnrollment');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return RegionName::where(array(
                'name' => $this->name,
            ))->first() != null;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}


