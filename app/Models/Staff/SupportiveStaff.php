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
 * @method static SupportiveStaff find($id)
 */
class SupportiveStaff extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public static function boot() {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function(SupportiveStaff $model) { // before delete() method call this
            $model->general()->delete();
        });
    }

    protected $enumStaffRanks = [
        'a' => 'rank1',
        'b' => 'rank2',
        'c' => 'rank3',
    ];

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
}
