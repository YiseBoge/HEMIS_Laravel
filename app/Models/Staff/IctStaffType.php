<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property string|null category
 * @property string|null type
 * @property string|null level
 * @method static IctStaffType findOrFail(int $id)
 */
class IctStaffType extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;
    protected $enumCategories = [
        'INFRASTRUCTURE_SERVICES' => 'Infrastructure & Services',
        'BUSINESS_APPLICATION_DEVELOPMENT' => 'Business Application Administration & Development',
        'TEACHING_LEARNING_TECHNOLOGIES' => 'Teaching and Learning Technologies',
        'SUPPORT_MAINTENANCE' => 'Support and Maintenance',
        'TRAINING_CONSULTANCY' => 'Training and Consultancy'
    ];
    protected $enumLevels = [
        'Level I' => 'Level I',
        'Level II' => 'Level II',
        'Level III' => 'Level III',
        'Level IV' => 'Level IV',
        'Level V' => 'Level V',
        'Level VI' => 'Level VI',
        'Level VII' => 'Level VII',
        'Level VIII' => 'Level VIII',
        'Level IX' => 'Level IX',
        'Level X' => 'Level X',
        'Level XI' => 'Level XI',
        'Level XII' => 'Level XII',
        'Level XIII' => 'Level XIII',
        'Level XIV' => 'Level XIV',
        'Level XV' => 'Level XV',
        'Level XVI' => 'Level XVI',
        'Level XVII' => 'Level XVII',
        'Level XVIII' => 'Level XVIII',
        'Level XIX' => 'Level XIX',
        'Level XX' => 'Level XX',
        'Level XXI' => 'Level XXI',
        'Level XXII' => 'Level XXII',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function (Model $model) {
            $model->{$model->getKeyName()} = Uuid::generate()->string;
        });

        static::deleting(function (IctStaffType $model) { // before delete() method call this
            $model->ictStaffs()->delete();
        });
    }

    /**
     * @return HasMany
     */
    public function ictStaffs()
    {
        return $this->hasMany('App\Models\Staff\IctStaff');
    }

    /**
     * @return bool
     */
    public function isDuplicate()
    {
        return IctStaffType::where(array(
                'type' => $this->type,
            ))->first() != null;
    }

    /**
     * @return string
     */
    function __toString()
    {
        return "$this->type - $this->category ($this->level)";
    }
}
