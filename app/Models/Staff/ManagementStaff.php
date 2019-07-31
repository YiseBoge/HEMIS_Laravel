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
 * @property string|null management_level
 * @property Staff general
 * @method static ManagementStaff find($id)
 */
class ManagementStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumManagementLevels = [
        'SENIOR' => 'Senior',
        'MIDDLE' => 'Middle',
        'LOWER' => 'Lower'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (ManagementStaff $model) { // before delete() method call this
            $model->general()->delete();
        });
    }

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
}
