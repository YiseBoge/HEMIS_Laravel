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
 * @method static IctStaffType find(int $id)
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
        'Level 1' => 'Level 1',
        'Level 2' => 'Level 2',
        'Level 3' => 'Level 3',
        'Level 4' => 'Level 4',
        'Level 5' => 'Level 5',
        'Level 6' => 'Level 6',
        'Level 7' => 'Level 7',
        'Level 8' => 'Level 8',
        'Level 9' => 'Level 9',
        'Level 10' => 'Level 10',
        'Level 11' => 'Level 11',
        'Level 12' => 'Level 12',
        'Level 13' => 'Level 13',
        'Level 14' => 'Level 14',
        'Level 15' => 'Level 15',
        'Level 16' => 'Level 16',
        'Level 17' => 'Level 17',
        'Level 18' => 'Level 18',
        'Level 19' => 'Level 19',
        'Level 20' => 'Level 20',
        'Level 21' => 'Level 21',
        'Level 22' => 'Level 22',
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
        return "$this->type ($this->category)";
    }
}
