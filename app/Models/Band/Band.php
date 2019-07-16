<?php

namespace App\Models\Band;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @method static Collection where(array $array)
 * @property Uuid band_name_id
 */
class Band extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public static function boot() {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function(Band $model) { // before delete() method call this
            $model->colleges()->delete();
        });
    }

    /**
     * @return BelongsTo
     */
    public function bandName()
    {
        return $this->belongsTo('App\Models\Band\BandName');
    }

    /**
     * @return HasMany
     */
    public function colleges()
    {
        return $this->hasMany('App\Models\College\College');
    }
}
