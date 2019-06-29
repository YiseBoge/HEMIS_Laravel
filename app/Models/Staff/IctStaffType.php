<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Webpatser\Uuid\Uuid;

/**
 * @property Uuid id
 * @property array|string|null category
 * @property array|string|null type
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

    public function ictStaffs()
    {
        return $this->hasMany('App\Models\Staff\IctStaff');
    }

    function __toString()
    {
        return "$this->type ($this->category)";
    }
}
