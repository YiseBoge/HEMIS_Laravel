<?php

namespace App\Models\Staff;

use App\Traits\Enums;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class IctStaffType extends Model
{
    use Uuids;
    use Enums;

    public $incrementing = false;

    public function ictStaffs()
    {
        return $this->hasMany('App\Models\Staff\IctStaff');
    }
    protected $enumCategories = [
        'INFRASTRUCTURE_SERVICES' => 'Infrastructure & Services',
        'BUSINESS_APPLICATION_DEVELOPMENT' => 'Business Application Administration & Development',
        'TEACHING_LEARNING_TECHNOLOGIES' => 'Teaching and Learning Technologies',
        'SUPPORT_MAINTENANCE' => 'Support and Maintenance',
        'TRAINING_CONSULTANCY' => 'Training and Consultancy'
    ];

    function __toString()
    {
        return "$this->type ($this->category)";
    }
}
