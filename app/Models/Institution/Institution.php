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
 * @property Collection managements
 * @property Collection colleges
 * @method static Institution findOrFail(int $id)
 */
class Institution extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumApprovalTypes = [
        'APPROVED' => 'Approved',
        'COLLEGE_APPROVED' => 'College Approved',
        'PENDING' => 'Pending',
        'DISAPPROVED' => 'Disapproved'
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (Institution $model) { // before delete() method call this
            $model->generalInformation()->delete();
            $model->colleges()->delete();
            $model->managements()->delete();
        });
    }

    /**
     * @return BelongsTo
     */
    public function generalInformation()
    {
        return $this->belongsTo('App\Models\Institution\GeneralInformation');
    }

    /**
     * @return HasMany
     */
    public function colleges()
    {
        return $this->hasMany('App\Models\College\College');
    }

    /**
     * @return HasMany
     */
    public function managements()
    {
        return $this->hasMany('App\Models\Institution\ManagementData');
    }

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
    public function instance()
    {
        return $this->belongsTo('App\Models\Institution\Instance');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->institutionName->__toString() . ' (' . $this->instance->__toString() . ')';
    }
}
