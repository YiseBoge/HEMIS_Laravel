<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null staffRank
 * @property Staff general
 * @method static AdministrativeStaff find($id)
 */
class AdministrativeStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (AdministrativeStaff $model) { // before delete() method call this
            $model->general()->delete();
        });
    }

    // Enums //

    /**
     * @return MorphOne
     */
    public function general()
    {
        return $this->morphOne('App\Models\Staff\Staff', 'staffable');
    }

    /**
     * @return BelongsTo
     */
    public function college()
    {
        return $this->belongsTo('App\Models\College\College');
    }

    /**
     * @return BelongsTo
     */
    public function jobTitle()
    {
        return $this->belongsTo('App\Models\Staff\JobTitle');
    }
}
