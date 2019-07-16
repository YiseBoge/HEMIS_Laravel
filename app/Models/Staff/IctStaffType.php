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

    /**
     * @return HasMany
     */
    public function ictStaffs()
    {
        return $this->hasMany('App\Models\Staff\IctStaff');
    }

    /**
     * @return string
     */
    function __toString()
    {
        return "$this->type ($this->category)";
    }
}
