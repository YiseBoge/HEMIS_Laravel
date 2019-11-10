<?php

namespace App\Models\Institution;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property CommunityService communityService
 * @property Resource resource
 * @property int campuses
 * @property int colleges
 * @property int schools
 * @property int institutes
 * @property int centers
 * @property int faculties
 * @property int departments
 * @property int board_members
 * @property int vice_presidents
 * @property int middle_level_leaders
 */
class GeneralInformation extends Model
{
    use Uuids;

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (GeneralInformation $model) { // before delete() method call this
            $model->resource()->delete();
            $model->communityService()->delete();
        });
    }

    /**
     * @return BelongsTo
     */
    public function resource()
    {
        return $this->belongsTo('App\Models\Institution\Resource');
    }

    /**
     * @return BelongsTo
     */
    public function communityService()
    {
        return $this->belongsTo('App\Models\Institution\CommunityService');
    }

    /**
     * @return HasOne
     */
    public function institution()
    {
        return $this->hasOne('App\Models\Institution\Institution');
    }
}
