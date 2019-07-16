<?php

namespace App\Models\Institution;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property Collection bands
 * @property Uuid institution_name_id
 * @property Uuid instance_id
 * @property GeneralInformation generalInformation
 * @property InstitutionName institutionName
 * @method static Institution find(int $id)
 */
class Institution extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public static function boot() {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function(Institution $model) { // before delete() method call this
            $model->generalInformation()->delete();
            $model->bands()->delete();
        });
    }

    protected $enumApprovalTypes = [
        'APPROVED' => 'Approved',
        'PENDING' => 'Pending',
        'DISAPPROVED' => 'Disapproved'
    ];

    /**
     * @return BelongsTo
     */
    public function institutionName()
    {
        return $this->belongsTo('App\Models\Institution\InstitutionName');
    }

    /**
     * @return BelongsTo
     */
    public function generalInformation()
    {
        return $this->belongsTo('App\Models\Institution\GeneralInformation');
    }

    /**
     * @return BelongsTo
     */
    public function instance()
    {
        return $this->belongsTo('App\Models\Institution\Instance');
    }

    /**
     * @return HasMany
     */
    public function bands()
    {
        return $this->hasMany('App\Models\Band\Band');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->institutionName->__toString() . ' (' . $this->instance->__toString() . ')';
    }
}
