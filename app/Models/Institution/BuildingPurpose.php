<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string purpose
 * @method static Collection where(string $string, $purposeString)
 */
class BuildingPurpose extends Model
{
    use Uuids;

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (BuildingPurpose $model) { // before delete() method call this
            $model->buildings()->delete();
        });
    }

    /**
     * @return BelongsToMany
     */
    public function buildings()
    {
        return $this->belongsToMany('App\Models\Institution\Building', 'building_building_purpose', 'building_purpose_id', 'building_id');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->purpose;
    }
}
